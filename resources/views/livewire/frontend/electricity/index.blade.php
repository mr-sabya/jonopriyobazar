<div class="section py-5">
    <div class="custom-container">

        @if($step == 1)
        <!-- STEP 1: COMPANY SELECTION -->
        <div class="text-center mb-5">
            <h2 class="font-weight-bold">Select Power Company</h2>
            <p class="text-muted">আপনার বিদ্যুৎ সরবরাহকারী প্রতিষ্ঠানটি নির্বাচন করুন</p>
            <div class="bg-primary mx-auto" style="width: 50px; height: 3px; border-radius: 2px;"></div>
        </div>

        <div class="row justify-content-center">
            @forelse($companies as $company)
            <div class="col-lg-2 col-md-4 col-6 mb-4">
                <div wire:click="selectCompany({{ $company->id }})"
                    class="card h-100 border-0 shadow-sm text-center company-card p-3"
                    style="cursor: pointer; transition: 0.3s; border-radius: 15px;">
                    <div class="category_image mb-3">
                        @if($company->logo == null)
                        <img src="{{ url('frontend/images/demo.png')}}" class="img-fluid rounded" alt="demo" style="max-height: 80px;">
                        @else
                        <img src="{{ url('upload/images', $company->logo) }}" class="img-fluid rounded" alt="logo" style="max-height: 80px;">
                        @endif
                    </div>
                    <div class="category_info">
                        <h6 class="font-weight-bold mb-1 text-dark">{{ $company->name }}</h6>
                        <span class="badge badge-light text-muted small px-2 py-1">{{ $company->type }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <p class="text-muted">No Power Companies Found</p>
            </div>
            @endforelse
        </div>

        @else
        <!-- STEP 2: BILL PAYMENT FORM -->
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="d-flex align-items-center mb-4">
                    <button wire:click="goBack" class="btn btn-link text-dark p-0 mr-3">
                        <i class="fas fa-arrow-left fa-lg"></i>
                    </button>
                    <h4 class="mb-0 font-weight-bold">Pay Bill: {{ $selectedCompany->name }} ({{ $selectedCompany->type }})</h4>
                </div>

                <div class="row">
                    <!-- Form Side -->
                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm br-15">
                            <div class="card-body p-4">
                                <form wire:submit.prevent="store">
                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">মিটার নম্বর/গ্রাহক নম্বর</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-bolt text-warning"></i></span>
                                            </div>
                                            <input type="text" wire:model="meter_no" class="form-control border-left-0 @error('meter_no') is-invalid @enderror" placeholder="Enter Meter No">
                                            @error('meter_no') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="font-weight-bold small text-muted">মোবাইল নম্বর</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0"><i class="fas fa-phone-alt"></i></span>
                                            </div>
                                            <input type="text" wire:model="phone" class="form-control border-left-0 @error('phone') is-invalid @enderror" placeholder="017XXXXXXXX">
                                            @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label class="font-weight-bold small text-muted">টাকার পরিমাণ</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-white border-right-0">৳</span>
                                            </div>
                                            <input type="number" wire:model.live="amount" class="form-control border-left-0 @error('amount') is-invalid @enderror" placeholder="Enter Amount">
                                            @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="payment-method-selection mb-4">
                                        <h6 class="font-weight-bold small text-muted mb-3 text-uppercase">Payment Method</h6>

                                        @php $user = Auth::user(); @endphp

                                        <!-- Cash on Delivery -->
                                        <label class="payment-item d-flex align-items-center border p-3 rounded mb-2 {{ $payment_option == 'cash' ? 'active' : '' }}">
                                            <input type="radio" wire:model="payment_option" value="cash" class="mr-3">
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold small">Cash On Delivery</span>
                                            </div>
                                            <i class="fas fa-money-bill-wave text-success"></i>
                                        </label>

                                        <!-- Wallet -->
                                        @php
                                        $walletDisabled = ($user->is_wallet != 1 || $user->is_hold == 1 || $user->is_expired == 1 || ($amount && $amount > $user->wallet_balance));
                                        @endphp
                                        <label class="payment-item d-flex align-items-center border p-3 rounded mb-2 {{ $walletDisabled ? 'disabled' : ($payment_option == 'wallet' ? 'active' : '') }}">
                                            <input type="radio" wire:model="payment_option" value="wallet" class="mr-3" {{ $walletDisabled ? 'disabled' : '' }}>
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold small">Credit Wallet (৳{{ $user->wallet_balance }})</span>
                                                @if($amount && $amount > $user->wallet_balance)
                                                <span class="text-danger small" style="font-size: 10px;">Insufficient Balance</span>
                                                @endif
                                            </div>
                                            <i class="fas fa-wallet text-primary"></i>
                                        </label>

                                        <!-- Refer -->
                                        @php $referDisabled = ($user->is_percentage != 1 || ($amount && $amount > $user->ref_balance)); @endphp
                                        <label class="payment-item d-flex align-items-center border p-3 rounded mb-4 {{ $referDisabled ? 'disabled' : ($payment_option == 'reffer' ? 'active' : '') }}">
                                            <input type="radio" wire:model="payment_option" value="reffer" class="mr-3" {{ $referDisabled ? 'disabled' : '' }}>
                                            <div class="flex-grow-1">
                                                <span class="d-block font-weight-bold small">Refer Wallet (৳{{ $user->ref_balance }})</span>
                                            </div>
                                            <i class="fas fa-users text-info"></i>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-success btn-block shadow br-10 font-weight-bold" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Submit Order</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Rules Side -->
                    <div class="col-md-5 mt-4 mt-md-0">
                        <div class="card border-0 bg-white br-15">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="fas fa-info-circle text-primary mr-2"></i>
                                    <h5 class="mb-0 font-weight-bold">নিয়মাবলী</h5>
                                </div>
                                <div class="rules-box p-3 bg-light rounded" style="font-size: 13px; line-height: 1.8;">
                                    <ul class="list-unstyled mb-0 text-dark">
                                        <li><i class="fas fa-check text-success mr-2"></i>১. চার্জ ১০ টাকা (১০০ - ১,০০০ টাকা)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>২. চার্জ ২০ টাকা (১,০০১ - ২,০০০ টাকা)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>৩. চার্জ ৩০ টাকা (২,০০১ - ৩,০০০ টাকা)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>৪. চার্জ ৪০ টাকা (৩,০০১ - ৪,০০০ টাকা)</li>
                                        <li><i class="fas fa-check text-success mr-2"></i>৫. চার্জ ৫০ টাকা (৪,০০১ - ১০,০০০ টাকা)</li>
                                        <li class="mt-2 text-danger font-weight-bold"><i class="fas fa-clock mr-2"></i>সকাল ৯.০০ থেকে রাত ৯.০০ পর্যন্ত রির্চাজ করা যাবে।</li>
                                        <li class="mt-1"><i class="fas fa-exclamation-triangle mr-2 text-warning"></i>টোকেন আসতে মাঝে মাঝে দেরি হতে পারে।</li>
                                        <li class="mt-3 p-2 bg-white border rounded">
                                            <span class="d-block font-weight-bold small">জরুরি প্রয়োজনে কল করুন:</span>
                                            <a href="tel:+8801322882568" class="text-primary font-weight-bold">+88 01322 882568</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
