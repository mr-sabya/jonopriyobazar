<div class="col-lg-9 pt-3">
    <div class="card border-0 shadow-sm br-15 p-5 text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle fa-5x text-success"></i>
        </div>
        <h3 class="font-weight-bold">Order Canceled Successfully!</h3>
        <p class="text-muted mb-4">Your order has been canceled and any applicable refunds have been processed to your wallet.</p>

        <div class="d-flex justify-content-center">
            <a href="{{ route('product.index') }}" class="btn btn-primary br-10 px-4 mr-2" wire:navigate>
                Continue Shopping
            </a>
            <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary br-10 px-4" wire:navigate>
                Go to Profile
            </a>
        </div>
    </div>
</div>