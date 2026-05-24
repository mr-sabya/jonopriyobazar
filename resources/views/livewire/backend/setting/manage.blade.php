<div>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            @if (session()->has('success'))
            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
            @endif

            <form wire:submit.prevent="update">
                <!-- General Settings -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Website General Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Website Title</label>
                                <input type="text" wire:model="website_name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Website Tagline</label>
                                <input type="text" wire:model="tagline" class="form-control">
                            </div>

                            <!-- Image Upload Grid -->
                            <div class="col-md-3">
                                <label class="form-label">Main Logo</label>
                                <div class="mb-2">
                                    @if($new_logo) <img src="{{ $new_logo->temporaryUrl() }}" width="100">
                                    @else <img src="{{ asset('upload/images/'.$setting->logo) }}" width="100"> @endif
                                </div>
                                <input type="file" wire:model="new_logo" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Footer Logo</label>
                                <div class="mb-2">
                                    @if($new_footer_logo) <img src="{{ $new_footer_logo->temporaryUrl() }}" width="100">
                                    @else <img src="{{ asset('upload/images/'.$setting->footer_logo) }}" width="100"> @endif
                                </div>
                                <input type="file" wire:model="new_footer_logo" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Invoice Logo</label>
                                <div class="mb-2">
                                    @if($new_invoice_logo) <img src="{{ $new_invoice_logo->temporaryUrl() }}" width="100">
                                    @else <img src="{{ asset('upload/images/'.$setting->invoice_logo) }}" width="100"> @endif
                                </div>
                                <input type="file" wire:model="new_invoice_logo" class="form-control form-control-sm">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Favicon</label>
                                <div class="mb-2">
                                    @if($new_favicon) <img src="{{ $new_favicon->temporaryUrl() }}" width="32">
                                    @else <img src="{{ asset('upload/images/'.$setting->favicon) }}" width="32"> @endif
                                </div>
                                <input type="file" wire:model="new_favicon" class="form-control form-control-sm">
                            </div>

                            <hr>

                            <div class="col-md-3">
                                <label class="form-label">Refer %</label>
                                <input type="number" wire:model="refer_percentage" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Min Refer</label>
                                <input type="number" wire:model="min_refer" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Dev %</label>
                                <input type="number" wire:model="dev_percentage" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Marketing %</label>
                                <input type="number" wire:model="marketing_percentage" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Copyright Text</label>
                                <textarea wire:model="copyright" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rich Text Editors (Summernote) -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Policies & About</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            @php
                            $editors = [
                            'terms' => 'Terms & Conditions',
                            'privacy' => 'Privacy Policy',
                            'refer' => 'Refer Policy',
                            'refund' => 'Refund Policy',
                            'about_1' => 'About Section 1',
                            'about_2' => 'About Section 2'
                            ];
                            @endphp

                            <!-- Define Quill styles once -->
                            <style>
                                .ql-container {
                                    min-height: 250px;
                                    background: #fff;
                                    font-size: 16px;
                                }

                                .ql-editor {
                                    min-height: 250px;
                                }
                            </style>

                            @foreach($editors as $key => $label)
                            <div class="col-12" wire:key="editor-container-{{ $key }}">
                                <label class="form-label fw-bold">{{ $label }}</label>

                                {{--
                Dynamic wire:model: 
                This binds to the specific property in your Manage.php 
                (e.g., $this->terms, $this->privacy, etc.)
            --}}
                                <livewire:quill-text-editor
                                    wire:model.live="{{ $key }}"
                                    theme="snow"
                                    wire:key="quill-{{ $key }}" />

                                @error($key)
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- SEO Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">SEO Settings</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Meta Description</label>
                                <textarea wire:model="meta_desc" class="form-control"></textarea>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Meta Tags (comma separated)</label>
                                <input type="text" wire:model="tags" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Facebook OG Image</label>
                                <input type="file" wire:model="new_og_image" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light py-3 text-end">
                        <button type="submit" class="btn btn-primary px-5">
                            <span wire:loading.remove wire:target="update">Save All Settings</span>
                            <span wire:loading wire:target="update">Updating...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>