<?php

namespace App\Livewire\Frontend\Checkout;

use App\Models\Cart;
use App\Models\Address;
use App\Models\District;
use App\Models\Cupon;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Computed; // Required for #[Computed]

class Index extends Component
{
    // Do NOT add public $carts; here if using Computed
    public $addresses;
    public $districts;
    public $shipping_address;
    public $billing_address;
    public $coupon_code;
    public $applied_coupon = null;
    public $payment_option = 'cash';

    public $subtotal = 0;
    public $delivery_charge = 0;

    /**
     * COMPUTED PROPERTY: This defines $this->carts
     * It is automatically available in Blade as $this->carts or $carts
     */
    #[Computed]
    public function carts()
    {
        return Cart::with('product')->where('user_id', Auth::id())->get();
    }

    public function mount()
    {
        $this->addresses = Address::where('user_id', Auth::id())->get();

        if ($this->addresses->count() == 0) {
            return redirect()->route('address.showform');
        }

        $this->districts = District::orderBy('name', 'ASC')->get();
        $this->shipping_address = Address::where('user_id', Auth::id())->where('is_shipping', 1)->first();
        $this->billing_address = Address::where('user_id', Auth::id())->where('is_billing', 1)->first();

        if ($this->shipping_address) {
            $this->delivery_charge = $this->shipping_address->city['delivery_charge'] ?? 0;
        }

        $this->calculateTotals();
    }

    public function updatedPaymentOption()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $tempSubtotal = 0;
        // Use $this->carts to access the computed property
        foreach ($this->carts as $cart) {
            if ($this->payment_option === 'wallet' || $this->payment_option === 'refer') {
                $tempSubtotal += ($cart->product->actual_price * $cart->quantity);
            } else {
                $tempSubtotal += $cart->price * $cart->quantity;
            }
        }
        $this->subtotal = $tempSubtotal;
    }

    public function applyCoupon()
    {
        $this->validate(['coupon_code' => 'required']);
        $coupon = Cupon::where('code', $this->coupon_code)->first();

        if (!$coupon) {
            $this->addError('coupon_error', 'Invalid Coupon Code!');
            return;
        }

        $this->applied_coupon = $coupon->toArray();
        $this->calculateTotals(); // Recalculate after coupon
        $this->dispatch('swal', ['icon' => 'success', 'title' => 'Coupon applied!']);
    }

    public function removeCoupon()
    {
        $this->applied_coupon = null;
        $this->coupon_code = '';
        $this->calculateTotals();
    }

    #[Computed]
    public function finalTotal()
    {
        $discount = $this->applied_coupon ? $this->applied_coupon['amount'] : 0;
        return ($this->subtotal + $this->delivery_charge) - $discount;
    }

    public function placeOrder()
    {
        if (!$this->shipping_address || !$this->billing_address) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Addresses not selected!']);
            return;
        }

        // 1. Check if cart is actually populated before starting
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        if ($cartItems->isEmpty()) {
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Your cart is empty!']);
            return;
        }

        try {
            $orderId = DB::transaction(function () use ($cartItems) {
                $user = User::find(Auth::id());
                $grandTotal = $this->finalTotal;

                // 2. Handle Balance Deductions
                if ($this->payment_option === 'wallet') {
                    if ($user->wallet_balance < $grandTotal) throw new \Exception('Insufficient wallet balance.');
                    $user->wallet_balance -= $grandTotal;
                } elseif ($this->payment_option === 'refer') {
                    if ($user->ref_balance < $grandTotal) throw new \Exception('Insufficient refer balance.');
                    $user->ref_balance -= $grandTotal;
                }
                $user->save();

                // 3. Create Order
                $order = Order::create([
                    'user_id'             => $user->id,
                    'invoice'             => time() . rand(100, 999),
                    'cupon_id'            => $this->applied_coupon['id'] ?? null,
                    'shipping_address_id' => $this->shipping_address->id,
                    'billing_address_id'  => $this->billing_address->id,
                    'type'                => 'product',
                    'payment_option'      => $this->payment_option,
                    'sub_total'           => $this->subtotal,
                    'total'               => $this->subtotal,
                    'grand_total'         => $grandTotal,
                    'status'              => 0,
                ]);

                // 4. Create Order Items using the fresh $cartItems collection
                foreach ($cartItems as $cart) {
                    // Ensure the product exists to avoid "trying to get property of non-object"
                    if (!$cart->product) continue;

                    $itemPrice = ($this->payment_option === 'wallet' || $this->payment_option === 'refer')
                        ? $cart->product->actual_price
                        : ($cart->price / $cart->quantity);

                    Orderitem::create([
                        'order_id'   => $order->id,
                        'product_id' => $cart->product_id,
                        'image'      => $cart->product->image,
                        'quantity'   => $cart->quantity,
                        'price'      => $itemPrice * $cart->quantity,
                    ]);
                }

                // 5. Clear Cart
                Cart::where('user_id', $user->id)->delete();

                return $order->id;
            });

            // Redirect to success page
            return $this->redirect(route('order.success', ['order_id' => $orderId]), navigate: true);
        } catch (\Exception $e) {
            // This will now catch database errors (like missing columns in orderitems)
            $this->dispatch('swal', ['icon' => 'error', 'title' => 'Order Failed: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.checkout.index');
    }
}
