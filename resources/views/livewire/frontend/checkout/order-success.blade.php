<div class="main_content auth-bg-gradient" style="min-height: 80vh; display: flex; align-items: center;">
    <style>
        .success-animation {
            animation: scaleIn 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .checkmark-circle {
            width: 100px;
            height: 100px;
            background: var(--shwapno-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 50px;
            box-shadow: 0 10px 20px rgba(67, 160, 71, 0.2);
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <div class="card br-20 shadow-sm p-5 success-animation">
                    <div class="checkmark-circle">
                        <i class="fas fa-check"></i>
                    </div>

                    <h1 class="fw-bold mb-2">Order Placed Successfully!</h1>
                    <p class="text-muted fs-5">Thank you for your purchase. We've received your order and are processing it now.</p>

                    <div class="order-info bg-light br-15 p-4 my-4 d-inline-block w-100">
                        <div class="row">
                            <div class="col-6 text-start">
                                <span class="text-muted small text-uppercase fw-bold">Order Number</span>
                                <p class="mb-0 fw-bold">#{{ $order->id }}</p>
                            </div>
                            <div class="col-6 text-end">
                                <span class="text-muted small text-uppercase fw-bold">Total Amount</span>
                                <p class="mb-0 fw-bold text-success">{{ $order->total }}৳</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="{{ route('product.index') }}" wire:navigate class="btn btn-outline-success w-100 br-10 fw-bold">
                                <i class="fas fa-shopping-basket me-2"></i> Continue Shopping
                            </a>
                        </div>
                        <div class="col-sm-6">
                            <a href="{{ route('user.order.index') }}" wire:navigate class="btn btn-login w-100 br-10 fw-bold text-white">
                                <i class="fas fa-file-invoice me-2"></i> View Order Status
                            </a>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <p class="small text-muted mb-0">A confirmation SMS has been sent to <strong>{{ Auth::user()->phone }}</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>