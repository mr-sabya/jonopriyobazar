<div class="login_register_wrap section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-10">
                <div class="login_wrap shadow-sm">
                    <div class="padding_eight_all bg-white">
                        <div class="heading_s1 text-center">
                            <h3>Verify OTP</h3>
                            <p class="small text-muted">Sent to: {{ $phone }}</p>
                        </div>

                        <form wire:submit.prevent="verify">
                            <div class="userinput">
                                <!-- Code 1 -->
                                <input wire:model.defer="code_1" type="text" id='ist' maxlength="1"
                                    class="otp-input" onkeyup="clickEvent(this,'sec')">
                                <!-- Code 2 -->
                                <input wire:model.defer="code_2" type="text" id="sec" maxlength="1"
                                    class="otp-input" onkeyup="clickEvent(this,'third')">
                                <!-- Code 3 -->
                                <input wire:model.defer="code_3" type="text" id="third" maxlength="1"
                                    class="otp-input" onkeyup="clickEvent(this,'fourth')">
                                <!-- Code 4 -->
                                <input wire:model.defer="code_4" type="text" id="fourth" maxlength="1"
                                    class="otp-input">
                            </div>

                            <div class="text-center">
                                @error('otp_error')
                                <small style="color: red;">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-fill-out btn-block bg-main-green ">
                                    <span wire:loading.remove wire:target="verify" class="text-white">Verify & Login</span>
                                    <span wire:loading wire:target="verify" class="text-white">Checking...</span>
                                </button>
                            </div>
                        </form>

                        <div class="different_login text-center mt-4">
                            <span>If you don't get OTP</span>
                        </div>

                        <div class="form-note text-center">
                            <a href="#" class="text-success font-weight-bold">Resend OTP</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function clickEvent(first, last) {
        if (first.value.length) {
            document.getElementById(last).focus();
        }
    }
</script>