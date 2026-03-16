<div class="main_content">
    <div class="section">
        <div class="container">
            <div class="row">
                <!-- ORDER HEADER & CANCEL BUTTON -->
                <div class="col-md-12">
                    <div class="order_review shadow-sm br-15 p-4 bg-white">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="order-info">
                                    <h5 class="font-weight-bold">Order: #{{ $order->invoice }}</h5>
                                    <p class="m-0 text-muted">Placed On: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                                    <span class="badge badge-info px-3 py-1 mt-1">{{ ucfirst($order->type) }} Order</span>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                

                                @if($order->status != 4)
                                <a class="btn btn-warning br-10 {{ $order->status < 2 ? '' : 'disabled' }}"
                                    href="{{ route('user.order.cencel.create', $order->invoice) }}" wire:navigate>
                                    <i class="fas fa-times-circle mr-1"></i> Cancel Order
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 1. ELECTRICITY TYPE DETAILS -->
                @if($order->type == 'electricity')
                <div class="col-md-12 mt-4">
                    <div class="order_review shadow-sm br-15 p-4 bg-white">
                        <h4 class="mb-3">Electricity Bill Details</h4>
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <tr>
                                    <td class="bg-light w-25">Invoice</td>
                                    <td>#{{ $order->invoice }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light">Power Company</td>
                                    <td>{{ $order->company['name'] }} - {{ $order->company['type'] }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light">Meter/Customer No</td>
                                    <td>{{ $order->meter_no }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light">Phone Number</td>
                                    <td>{{ $order->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="bg-light">Amount</td>
                                    <td class="font-weight-bold text-success">{{ number_format($order->grand_total, 2) }}৳</td>
                                </tr>
                                <tr>
                                    <td class="bg-light">Status</td>
                                    <td>
                                        @include('livewire.frontend.user.order.partials.status-badge')
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 2. CUSTOM & MEDICINE TYPE DETAILS -->
                @if($order->type == 'custom' || $order->type == 'medicine')
                <div class="col-md-12 mt-4">
                    <div class="order_review shadow-sm br-15 p-4 bg-white">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="font-weight-bold border-bottom pb-2">Requirement List</h6>
                                <div class="p-3 bg-light br-10 mt-2">
                                    {!! $order->custom !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold border-bottom pb-2">Attached Image</h6>
                                <div class="mt-2 text-center">
                                    @if($order->image)
                                    <img src="{{ url('upload/images', $order->image) }}" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                    @else
                                    <div class="p-5 text-muted bg-light rounded">No image attached</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- 3. PRODUCT TYPE TABLE -->
                @if($order->type == 'product')
                <div class="col-md-12 mt-4">
                    <div class="order_review shadow-sm br-15 p-4 bg-white">
                        <h4 class="mb-3">Purchased Items</h4>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ url('upload/images', $item->product->image) }}" class="rounded mr-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <span class="font-weight-bold">{{ $item->product->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($order->payment_option == 'wallet')
                                            {{ $item->product->actual_price }}৳
                                            @else
                                            {{ $item->product->sale_price }}৳
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right font-weight-bold">{{ number_format($item->price, 2) }}৳</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

                <!-- SUMMARY, TRACKING & ADDRESSES (COMMON FOR ALL EXCEPT ELECTRICITY) -->
                @if($order->type != 'electricity')
                <div class="col-md-12 mt-4">
                    <div class="row">
                        <!-- Tracking & History -->
                        <div class="col-lg-7">
                            <div class="order_review shadow-sm br-15 p-4 bg-white h-100">
                                <h4 class="mb-4">Order Tracking</h4>
                                <div class="track mb-5">
                                    <div class="step {{ $order->status >= 1 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text small">Confirmed</span> </div>
                                    <div class="step {{ $order->status >= 2 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-spinner"></i> </span> <span class="text small">Processing</span> </div>
                                    <div class="step {{ $order->status >= 3 ? 'active' : '' }}"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text small">Delivered</span> </div>
                                </div>

                            </div>
                        </div>

                        <!-- Price Calculation & Totals -->
                        <div class="col-lg-5 mt-4 mt-lg-0">
                            <div class="order_review shadow-sm br-15 p-4 bg-white">
                                <h4 class="mb-3">Payment Summary</h4>
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td class="px-0">SubTotal</td>
                                        <td class="text-right px-0">{{ number_format($order->sub_total, 2) }}৳</td>
                                    </tr>
                                    @if($order->type == 'product')
                                    <tr>
                                        <td class="px-0">Coupon</td>
                                        <td class="text-right px-0 text-danger">
                                            @if($order->cupon_id != null) -{{ $order->cupon['amount'] }}৳ @else 0.00৳ @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="px-0">Delivery Charge</td>
                                        <td class="text-right px-0">+{{ number_format($order->shippingAddress['city']['delivery_charge'] ?? 0, 2) }}৳</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td class="px-0 font-weight-bold fs-5">Grand Total</td>
                                        <td class="text-right px-0 font-weight-bold fs-5 text-success">{{ number_format($order->grand_total, 2) }}৳</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="history shadow-sm p-4 br-15 bg-white mt-4">
                                <h6 class="small font-weight-bold text-uppercase text-muted">History Log</h6>
                                @foreach($order->histories as $history)
                                <p class="mb-1 small">
                                    <span class="text-primary fw-bold">{{ date('d-M-Y h:i A', strtotime($history->date_time)) }}</span>
                                    - Your Order is {{ $history->status['name'] }}
                                </p>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Addresses Section -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="order_review shadow-sm br-15 p-4 bg-white">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-truck text-muted mr-2"></i>Shipping Address</h5>
                                <p class="mb-0">
                                    <strong>{{ $order->shippingAddress['name'] }}</strong><br>
                                    {{ $order->shippingAddress['street'] }}, {{ $order->shippingAddress['city']['name'] }} - {{ $order->shippingAddress['post_code']}}<br>
                                    {{ $order->shippingAddress['thana']['name'] }}, {{ $order->shippingAddress['district']['name']}}<br>
                                    <i class="fas fa-phone-alt small mr-1"></i> {{ $order->shippingAddress['phone']}}<br>
                                    <span class="badge badge-warning mt-2">
                                        {{ ucfirst($order->shippingAddress['type']) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 mt-4 mt-md-0">
                            <div class="order_review shadow-sm br-15 p-4 bg-white">
                                <h5 class="font-weight-bold mb-3"><i class="fas fa-file-invoice text-muted mr-2"></i>Billing Address</h5>
                                <p class="mb-0">
                                    <strong>{{ $order->billingAddress['name'] }}</strong><br>
                                    {{ $order->billingAddress['street'] }}, {{ $order->billingAddress['city']['name'] }} - {{ $order->billingAddress['post_code']}}<br>
                                    {{ $order->billingAddress['thana']['name'] }}, {{ $order->billingAddress['district']['name']}}<br>
                                    <i class="fas fa-phone-alt small mr-1"></i> {{ $order->billingAddress['phone']}}<br>
                                    <span class="badge badge-warning mt-2">
                                        {{ ucfirst($order->billingAddress['type']) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>