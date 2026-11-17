<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Livewire\Frontend\Checkout\Index as Checkout;
use App\Livewire\Frontend\User\CancelOrder\Manage as CancelOrder;
use App\Models\Address;
use App\Models\Cart;
use App\Models\City;
use App\Models\Cupon;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Prize;
use App\Models\Product;
use App\Models\ReferPurchase;
use App\Models\User;
use App\Models\UserPoint;
use App\Models\UserPrize;
use App\Models\WalletPurchase;
use App\Traits\ManagesOrderStatuses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** Wallets, referral balance, points and coupons: everything that moves a customer's money. */
class MoneyFlowTest extends TestCase
{
    use RefreshDatabase;

    private int $seq = 0;

    private function customer(array $attributes = []): User
    {
        $this->seq++;

        return User::forceCreate(array_merge([
            'name' => 'Customer '.$this->seq,
            'username' => 'customer'.$this->seq,
            'phone' => '0170000000'.$this->seq,
            'affiliate_code' => 'AFF'.$this->seq,
            'password' => bcrypt('secret'),
            'status' => 1,
            'wallet_balance' => 0,
            'ref_balance' => 0,
            'point' => 0,
        ], $attributes));
    }

    private function product(int $price = 100, int $point = 0): Product
    {
        $this->seq++;

        return Product::forceCreate([
            'name' => 'Product '.$this->seq, 'slug' => 'product-'.$this->seq, 'quantity' => '1kg',
            'sale_price' => $price, 'actual_price' => $price, 'point' => $point,
            'image' => 'p.jpg', 'is_stock' => 1, 'added_by' => 1,
        ]);
    }

    private function addressFor(User $user, int $deliveryCharge = 50): Address
    {
        $n = ++$this->seq;
        $district = \App\Models\District::forceCreate(['name' => 'District '.$n]);
        $thana = \App\Models\Thana::forceCreate(['name' => 'Thana '.$n, 'district_id' => $district->id]);
        $city = City::forceCreate(['name' => 'City '.$n, 'thana_id' => $thana->id, 'delivery_charge' => $deliveryCharge]);

        return Address::forceCreate([
            'user_id' => $user->id, 'name' => $user->name, 'phone' => $user->phone, 'street' => 'Road 1',
            'district_id' => $district->id, 'thana_id' => $thana->id, 'city_id' => $city->id, 'post_code' => '1200',
            'is_shipping' => 1, 'is_billing' => 1,
        ]);
    }

    private function inCart(User $user, Product $product, int $quantity = 2): void
    {
        Cart::forceCreate(['user_id' => $user->id, 'product_id' => $product->id, 'quantity' => $quantity, 'price' => $product->sale_price]);
    }

    private function coupon(array $attributes = []): Cupon
    {
        return Cupon::forceCreate(array_merge(['amount' => 30, 'code' => 'SAVE30', 'limit' => 0, 'expire_date' => now()->addWeek()->toDateString()], $attributes));
    }

    /** Place an order through the real checkout screen. */
    private function placeOrder(User $user, string $payment = 'cash', ?string $coupon = null): Order
    {
        $component = Livewire::actingAs($user)->test(Checkout::class)->set('payment_option', $payment);
        if ($coupon) {
            $component->set('coupon_code', $coupon)->call('applyCoupon');
        }
        $component->call('placeOrder');

        return Order::where('user_id', $user->id)->latest('id')->firstOrFail();
    }

    private function admin(): object
    {
        return new class
        {
            use ManagesOrderStatuses;
        };
    }

    // ---- Coupons -------------------------------------------------------------

    public function test_a_coupon_is_expired_only_after_its_last_day(): void
    {
        $this->assertFalse($this->coupon(['expire_date' => now()->toDateString()])->isExpired());
        $this->assertTrue($this->coupon(['code' => 'OLD', 'expire_date' => now()->subDay()->toDateString()])->isExpired());
    }

    public function test_a_coupon_stops_working_once_its_usage_limit_is_reached(): void
    {
        $user = $this->customer();
        $coupon = $this->coupon(['limit' => 1]);
        $this->assertTrue($coupon->isValid());

        Order::forceCreate(['user_id' => $user->id, 'invoice' => 'INV1', 'cupon_id' => $coupon->id, 'type' => 'product', 'payment_option' => 'cash', 'status' => 0]);

        $this->assertTrue($coupon->fresh()->isLimitReached());
        $this->assertFalse($coupon->fresh()->isValid());
        $this->assertFalse($this->coupon(['code' => 'FREE', 'limit' => 0])->isLimitReached(), 'limit 0 means unlimited');
    }

    public function test_checkout_rejects_expired_and_used_up_coupons_but_takes_a_good_one(): void
    {
        $user = $this->customer();
        $this->addressFor($user);
        $this->inCart($user, $this->product(100));
        $this->coupon(['code' => 'OLD', 'expire_date' => now()->subDays(3)->toDateString()]);
        $this->coupon(['code' => 'GOOD', 'amount' => 30]);

        Livewire::actingAs($user)->test(Checkout::class)
            ->set('coupon_code', 'OLD')->call('applyCoupon')->assertHasErrors('coupon_error')
            ->set('coupon_code', 'NOPE')->call('applyCoupon')->assertHasErrors('coupon_error')
            ->set('coupon_code', 'GOOD')->call('applyCoupon')->assertHasNoErrors();
    }

    public function test_a_coupon_bigger_than_the_basket_never_makes_the_total_negative(): void
    {
        $user = $this->customer();
        $this->addressFor($user, 0);
        $this->inCart($user, $this->product(100), 1);
        $this->coupon(['amount' => 5000]);

        $order = $this->placeOrder($user, 'cash', 'SAVE30');

        $this->assertSame(0, (int) $order->grand_total);
    }

    // ---- Checkout totals ---------------------------------------------------------

    public function test_cash_order_total_is_items_plus_delivery_minus_coupon_and_empties_the_cart(): void
    {
        $user = $this->customer();
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);
        $this->coupon(['amount' => 30]);

        $order = $this->placeOrder($user, 'cash', 'SAVE30');

        $this->assertSame(200, (int) $order->sub_total);
        $this->assertSame(220, (int) $order->grand_total); // 200 + 50 delivery - 30 coupon
        $this->assertSame(1, Orderitem::where('order_id', $order->id)->count());
        $this->assertSame(0, Cart::where('user_id', $user->id)->count());
    }

    public function test_an_order_with_an_empty_cart_is_not_created(): void
    {
        $user = $this->customer();
        $this->addressFor($user);

        Livewire::actingAs($user)->test(Checkout::class)->call('placeOrder');

        $this->assertSame(0, Order::count());
    }

    // ---- Wallet and refer balance ----------------------------------------------------

    public function test_paying_from_the_wallet_takes_the_money_once_even_after_delivery(): void
    {
        $user = $this->customer(['wallet_balance' => 1000]);
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);

        $order = $this->placeOrder($user, 'wallet');

        $this->assertEquals(750, $user->fresh()->wallet_balance, '200 items + 50 delivery are taken at checkout');
        $this->assertSame(1, WalletPurchase::where('order_id', $order->id)->count());

        $this->admin()->updateOrderStatus($order->id, OrderStatus::DELIVERED->value);

        $this->assertEquals(750, $user->fresh()->wallet_balance, 'delivery must not charge a second time');
        $this->assertSame(1, WalletPurchase::where('order_id', $order->id)->count());
    }

    public function test_a_wallet_order_that_is_cancelled_gives_the_money_back(): void
    {
        $user = $this->customer(['wallet_balance' => 1000]);
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);
        $order = $this->placeOrder($user, 'wallet');

        $this->admin()->updateOrderStatus($order->id, OrderStatus::CANCELED->value);

        $this->assertEquals(1000, $user->fresh()->wallet_balance);
        $this->assertSame(0, WalletPurchase::where('order_id', $order->id)->count());
    }

    public function test_the_customer_can_cancel_and_is_refunded_and_the_order_is_marked_cancelled(): void
    {
        $user = $this->customer(['wallet_balance' => 1000]);
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);
        $order = $this->placeOrder($user, 'wallet');
        $reason = \App\Models\CancelReason::forceCreate(['name' => 'Changed my mind']);

        Livewire::actingAs($user)->test(CancelOrder::class, ['invoice' => $order->invoice])
            ->set('reason_id', $reason->id)->set('is_agree_cancel', true)->call('submit')->assertHasNoErrors();

        $this->assertSame(OrderStatus::CANCELED, $order->fresh()->status);
        $this->assertEquals(1000, $user->fresh()->wallet_balance);
    }

    public function test_the_wallet_cannot_be_overspent(): void
    {
        $user = $this->customer(['wallet_balance' => 100]);
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);

        Livewire::actingAs($user)->test(Checkout::class)->set('payment_option', 'wallet')->call('placeOrder');

        $this->assertEquals(100, $user->fresh()->wallet_balance);
        $this->assertSame(0, Order::count());
        $this->assertSame(1, Cart::where('user_id', $user->id)->count(), 'the cart is kept');
    }

    public function test_paying_from_the_refer_balance_takes_it_once_and_cancelling_returns_it(): void
    {
        $user = $this->customer(['ref_balance' => 500]);
        $this->addressFor($user, 50);
        $this->inCart($user, $this->product(100), 2);

        $order = $this->placeOrder($user, 'refer');
        $this->assertEquals(250, $user->fresh()->ref_balance);
        $this->assertSame(1, ReferPurchase::where('order_id', $order->id)->count());

        $this->admin()->updateOrderStatus($order->id, OrderStatus::DELIVERED->value);
        $this->assertEquals(250, $user->fresh()->ref_balance);
    }

    // ---- Points and prizes ----------------------------------------------------------

    public function test_points_are_given_once_on_delivery_and_taken_back_on_cancel(): void
    {
        $user = $this->customer();
        $this->addressFor($user);
        $this->inCart($user, $this->product(100, 5), 3); // 5 points x 3
        $order = $this->placeOrder($user, 'cash');
        $admin = $this->admin();

        $admin->updateOrderStatus($order->id, OrderStatus::DELIVERED->value);
        $this->assertSame(15, $user->fresh()->point);

        $admin->updateOrderStatus($order->id, OrderStatus::DELIVERED->value); // same status again does nothing
        $this->assertSame(15, $user->fresh()->point);
        $this->assertSame(1, UserPoint::where('order_id', $order->id)->count());

        $admin->updateOrderStatus($order->id, OrderStatus::CANCELED->value);
        $this->assertSame(0, $user->fresh()->point);
    }

    public function test_a_prize_costs_points_and_needs_enough_of_them(): void
    {
        $prize = Prize::forceCreate(['title' => 'Rice cooker', 'prize' => 'Rice cooker', 'point' => 100]);

        $poor = $this->customer(['point' => 40]);
        $this->actingAs($poor)->get(route('user.point.prize.apply', $prize->id))->assertRedirect(route('user.point.index'));
        $this->assertSame(40, $poor->fresh()->point);
        $this->assertSame(0, UserPrize::count());

        $rich = $this->customer(['point' => 130]);
        $this->actingAs($rich)->get(route('user.point.prize.apply', $prize->id));
        $this->assertSame(30, $rich->fresh()->point);
        $this->assertSame(1, UserPrize::where('user_id', $rich->id)->count());
    }

    public function test_an_account_on_hold_is_not_paid_out_on_delivery(): void
    {
        $user = $this->customer(['is_hold' => 1, 'wallet_balance' => 1000]);
        $this->addressFor($user);
        $this->inCart($user, $this->product(100, 5), 1);
        $order = $this->placeOrder($user, 'cash');

        $this->admin()->updateOrderStatus($order->id, OrderStatus::DELIVERED->value);

        $this->assertNotSame(OrderStatus::DELIVERED, $order->fresh()->status);
        $this->assertSame(0, $user->fresh()->point);
    }
}
