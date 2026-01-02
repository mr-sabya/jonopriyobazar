<table class="cart_list">
	@foreach($carts as $cart)
	<tr>
		<td style="width: 10%">
			<div class="quantity">
				<button class="quantity-chnage increment" data-id="{{ $cart->id }}" data-price="{{ $cart->product['sale_price']}}"><i class="lnr lnr-chevron-up"></i></button>
				<span class="cart_quantity" id="quantity_{{ $cart->id }}">{{ $cart->quantity }}</span>
				<button class="quantity-chnage decrement" data-id="{{ $cart->id }}" data-price="{{ $cart->product['sale_price']}}"><i class="lnr lnr-chevron-down"></i></button>
			</div>
		</td>
		<td style="width: 30%">
			<a href="javascript:void(0)">
				<img src="{{ url('upload/images', $cart->product->image) }}" alt="cart_thumb1">
			</a>
		</td>
		<td style="width: 55%">
			<p class="title">{{ $cart->product->name }} - {{ $cart->product->quantity }}</p>
			<p class="price">
				<span id="sub_quantity_{{ $cart->id }}">{{ $cart->quantity }}</span> x {{ $cart->product['sale_price']}}৳ = <span class="cart_amount" id="item_price_{{ $cart->id }}">{{ $cart->price }}</span><span class="price_symbol">৳ </span>
				@if($cart->product['actual_price'] != '')
				<span style="color: #6e6e6e"><del><span id="actual_price_{{ $cart->id }}" >{{ $cart->product['actual_price'] * $cart->quantity }}</span><span class="price_symbol">৳ </span></del></span> 
				<span id="product_actual_price_{{ $cart->id }}" style="display: none;">{{ $cart->product['actual_price'] }}</span>
				@else
				<span id="actual_price_{{ $cart->id }}" style="display: none;"></span>
				<span id="product_actual_price_{{ $cart->id }}" style="display: none;"></span>

				@endif
			</p>

		</td>
		<td style="width: 5%">
			<a id="{{ $cart->id }}" href="javascript:void(0)" class="item_remove"><i class="lnr lnr-cross"></i></a>
		</td>



	</tr>
	@endforeach
</table>

