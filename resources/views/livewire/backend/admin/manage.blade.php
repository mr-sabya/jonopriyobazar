<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="m-0 fw-bold text-primary">
                            <i class="fas {{ $isEditMode ? 'fa-user-edit' : 'fa-user-plus' }} me-2"></i>
                            {{ $isEditMode ? 'Edit Administrator' : 'Create New Administrator' }}
                        </h5>
                        <small class="text-muted">Fill in the details below to {{ $isEditMode ? 'update' : 'register' }}
                            an admin account.</small>
                    </div>
                    <a href="{{ route('admin.admins.index') }}" wire:navigate class="btn btn-light btn-sm border">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <!-- Form Body -->
                <div class="card-body p-4">
                    <form wire:submit.prevent="save">
                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-user text-muted"></i></span>
                                    <input type="text" wire:model.defer="name"
                                        class="form-control border-start-0 ps-2 @error('name') is-invalid @enderror"
                                        placeholder="Enter full name">
                                </div>
                                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" wire:model.defer="email"
                                        class="form-control border-start-0 ps-2 @error('email') is-invalid @enderror"
                                        placeholder="email@example.com">
                                </div>
                                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-phone text-muted"></i></span>
                                    <input type="text" wire:model.defer="phone"
                                        class="form-control border-start-0 ps-2 @error('phone') is-invalid @enderror"
                                        placeholder="Enter phone number">
                                </div>
                                @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Roles (Multi-select) -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Assign Roles</label>
                                <div wire:ignore>
                                    <select id="roles-select" class="form-select select2" multiple
                                        data-placeholder="Choose one or more roles...">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}" {{ in_array($role->name, $selectedRoles) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('selectedRoles') <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <hr class="my-3 opacity-25">
                            </div>

                            <!-- Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">
                                    Password
                                    @if($isEditMode) <small class="text-muted fw-normal">(Leave blank to keep
                                    current)</small> @endif
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-lock text-muted"></i></span>
                                    <input type="password" wire:model.defer="password"
                                        class="form-control border-start-0 ps-2 @error('password') is-invalid @enderror"
                                        placeholder="••••••••">
                                </div>
                                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-dark">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i
                                            class="fas fa-shield-alt text-muted"></i></span>
                                    <input type="password" wire:model.defer="password_confirmation"
                                        class="form-control border-start-0 ps-2" placeholder="••••••••">
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="mt-5 d-flex align-items-center justify-content-end">
                            <a href="{{ route('admin.admins.index') }}"
                                class="btn btn-link text-muted me-3 text-decoration-none">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 shadow-sm py-2">
                                <span wire:loading wire:target="save"
                                    class="spinner-border spinner-border-sm me-2"></span>
                                <i wire:loading.remove wire:target="save" class="fas fa-save me-2"></i>
                                {{ $isEditMode ? 'Update Administrator' : 'Create Administrator' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




</div>
@push('css')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom Select2 Bootstrap 5 Theme Tweaks */
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #dee2e6 !important;
            border-radius: 0.375rem !important;
            padding: 4px 8px !important;
            min-height: 38px !important;
            background-color: #fff !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #86b7fe !important;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
            outline: 0 !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #0d6efd !important;
            border: none !important;
            color: #fff !important;
            border-radius: 4px !important;
            padding: 2px 8px !important;
            margin-top: 4px !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff !important;
            margin-right: 5px !important;
            border: none !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background: transparent !important;
            color: #f8f9fa !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            margin-top: 7px !important;
            font-family: inherit !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__display {
            margin-left: 10px;
        }
    </style>
@endpush


@push('scripts')
    <!-- Load Select2 JS only once -->
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Use a function to initialize Select2
        function initRolesSelect() {
            const el = $('#roles-select');

            // Only initialize if the element exists on the current page
            if (el.length > 0) {
                // Destroy existing instance if it exists to prevent duplicates
                if (el.hasClass("select2-hidden-accessible")) {
                    el.select2('destroy');
                }

                el.select2({
                    placeholder: el.data('placeholder'),
                    width: '100%',
                    closeOnSelect: false
                });

                // Sync Select2 value to Livewire
                el.on('change', function (e) {
                    let data = $(this).select2("val");
                    // Using @this works because this script is in the component blade
                    @this.set('selectedRoles', data);
                });
            }
        }

        // 1. Run on initial load
        document.addEventListener('livewire:init', () => {
            initRolesSelect();
        });

        // 2. Run every time wire:navigate completes
        document.addEventListener('livewire:navigated', () => {
            initRolesSelect();
        });

        // 3. Re-run after Livewire component updates (validation fails, etc.)
        window.addEventListener('re-init-select2', event => {
            initRolesSelect();
        });
    </script>
@endpush