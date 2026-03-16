<div class="col-lg-9 pt-3">
    <div class="order_review shadow-sm br-15 p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h5 class="font-weight-bold mb-0">Cancel Order: #{{ $order->invoice }}</h5>
                <p class="text-muted small mb-0">Placed On: {{ $order->created_at->format('d-m-Y') }}</p>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-light br-10 text-muted">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>

        <form wire:submit.prevent="submit">
            <div class="form-group mb-4">
                <label class="font-weight-bold small text-uppercase">Reason for Cancellation <span class="text-danger">*</span></label>
                <select wire:model="reason_id" class="form-control br-10 @error('reason_id') is-invalid @enderror">
                    <option value="">Select a reason</option>
                    @foreach($reasons as $reason)
                    <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                    @endforeach
                </select>
                @error('reason_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold small text-uppercase">Remark (Optional)</label>
                <textarea wire:model="remark" class="form-control br-10" rows="3" placeholder="Additional details..."></textarea>
            </div>

            <div class="bg-light p-4 br-15 mb-4">
                <h6 class="font-weight-bold mb-3"><i class="fas fa-exclamation-triangle text-warning mr-2"></i>Cancellation Terms</h6>
                <ul class="small text-muted pl-3 mb-0">
                    <li class="mb-2">অর্ডার ক্যানসেল করলে আপনার অর্জিত পয়েন্ট বাতিল হবে।</li>
                    <li class="mb-2">আপনি যদি ক্রেডিট ওয়ালেট ব্যবহার করেন তাহলে বিল পুনরায় ক্রেডিট ওয়ালেটে যুক্ত হবে।</li>
                    <li>উপযুক্ত কারণ ছাড়া আপনি অর্ডার ক্যানসেল করতে পারবেন না।</li>
                </ul>
            </div>

            <div class="custom-control custom-checkbox mb-4">
                <input type="checkbox" wire:model="is_agree_cancel" class="custom-control-input @error('is_agree_cancel') is-invalid @enderror" id="is_agree">
                <label class="custom-control-label small" for="is_agree">I agree with the cancellation terms and conditions</label>
                @error('is_agree_cancel') <br><small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button type="submit" class="btn btn-danger btn-block br-10 py-3 font-weight-bold" wire:loading.attr="disabled">
                <span wire:loading.remove>Confirm Cancellation</span>
                <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i>Processing...</span>
            </button>
        </form>
    </div>
</div>