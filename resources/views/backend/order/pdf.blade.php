 <!DOCTYPE html>
 <html>
 <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">

        body { 
            font-family: 'Poppins', sans-serif;
        }
        h3, p{
            margin: 0;
        }
        
        .table{
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            font-size: 13px;
        }

        .table tr th,
        .table tr td{
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }

        .table tfoot tr th{
            font-weight: normal;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="body">
            <table style="width: 100%">
                <tr>
                    <td style="width: 50%">
                        @php
                        $image = './upload/images/'.$setting->invoice_logo;
                        @endphp
                         <img src="{{ url('upload/images/',$setting->invoice_logo) }}"> 
                        <!--<img src="{{ $image }}">-->
                    </td>
                    <td style="width: 50%">
                        <h3>Order: #{{ $order->invoice }}</h3>
                        <h3><strong>{{ $order->customer['name']}}</strong></h3>
                        <p style="font-size: 12px">Date: {{ date('d-m-Y', strtotime($order->created_at)) }}</p>
                        <p style="font-size: 12px">Payment By:
                            @if($order->payment_option == 'cash')
                            Cash On Delievery
                            @elseif($order->payment_option == 'wallet')
                            Credit Wallet
                            @elseif ($order->payment_option == 'refer')
                            Refer Wallet
                        @endif</p>
                    </td>
                </tr>
            </table>

            <table style="font-size: 12px; width: 100%">
                <tr>
                    <td style="width: 50%">
                        <h4>Shipping Address</h4>
                        <p><strong>{{ $order->shippingAddress['name'] }}</strong><br>
                            {{ $order->shippingAddress['street'] }},<br> {{ $order->shippingAddress['city']['name'] }} - {{ $order->shippingAddress['post_code']}}, {{ $order->shippingAddress['thana']['name'] }}, {{ $order->shippingAddress['district']['name']}}<br>
                            {{ $order->shippingAddress['phone']}}<br>
                            <span class="badge badge-warning">
                                @if($order->shippingAddress['type'] == 'home') Home @else Office @endif
                            </span>
                        </p>
                    </td>



                    <td style="width: 50%">
                        <h4>Billing Address</h4>
                        <p><strong>{{ $order->billingAddress['name'] }}</strong><br>
                            {{ $order->billingAddress['street'] }},<br> {{ $order->billingAddress['city']['name'] }} - {{ $order->billingAddress['post_code']}}, {{ $order->billingAddress['thana']['name'] }}, {{ $order->billingAddress['district']['name']}}<br>
                            {{ $order->billingAddress['phone']}}<br>
                            <span class="badge badge-warning">
                                @if($order->billingAddress['type'] == 'home') Home @else Office @endif
                            </span>
                        </p>
                    </td>

                </tr>
            </table>
            <div class="row" style="margin-top: 20px">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover product-table">
                            <thead>
                                <tr>
                                    <th style="width: 5%">#</th>
                                    
                                    <th style="width: 50%; text-align: center;">Product</th>
                                    <th style="width: 15%; text-align: center;">Quantity</th>
                                    <th style="width: 15%; text-align: right;">Unit Price</th>
                                    <th style="width: 15%; text-align: right;">Price</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    
                                    <td style="text-align: center;">{{ $item->product['name'] }} - {{ $item->product['quantity']}}</td>
                                    <td style="text-align: center;">{{ $item->quantity }}</td>
                                    <td style="text-align: right;">
                                        @if($order->payment_option =='wallet')
                                        {{ $item->product['actual_price'] }} tk.
                                        @else
                                        {{ $item->product['sale_price'] }} tk.
                                        @endif

                                    </td>
                                    <td style="text-align: right;">{{ $item->price }} tk.</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Sub Total</th>
                                    <th style="text-align: right;">
                                        {{ $order->sub_total }} tk.
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Cupon</th>
                                    <th style="text-align: right;">
                                        @if($order->cupon_id != null)
                                        - {{ $order->cupon['amount']}} tk.
                                        @else
                                        No Cupon
                                        @endif
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Total</th>
                                    <th style="text-align: right;">
                                        {{ $order->total }} tk.
                                    </th>
                                </tr>

                                <tr>
                                    <th style="text-align: right;" colspan="4">Delivery Charge</th>
                                    <th style="text-align: right;">
                                        + {{ $order->shippingAddress['city']['delivery_charge'] }} tk.
                                    </th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;" colspan="4">Grand Total</th>
                                    <th style="text-align: right;">
                                        {{ $order->grand_total }} tk.
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <p style="margin-top: 20px; font-size: 12px; text-align: center;">Thank you for ordering from Jonopriyo Bazar.<br>If you have any complaint about this order, Please call us at 01322-882568</p>

            <table style="width: 100%; font-size: 12px; margin-top: 100px">
                <tr>
                    <td style="width: 50%">
                        <div style="text-align: center;">
                            --------------------<br>
                            Authorized Signature
                        </div>
                    </td>
                    <td style="width: 50%">
                        <div style="text-align: center;">
                            --------------------<br>
                            Customer Signature
                        </div>
                    </td>
                </tr>
            </table>

            
        </div>
    </div>

</body>
</html>
