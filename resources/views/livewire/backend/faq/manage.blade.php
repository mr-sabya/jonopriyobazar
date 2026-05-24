<div>
    <div class="row g-4">
        <!-- Form Section (Create/Edit) -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">{{ $isEditMode ? 'Edit FAQ' : 'Add New FAQ' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Question</label>
                            <textarea wire:model="question" class="form-control @error('question') is-invalid @enderror" rows="3" placeholder="Enter the question..."></textarea>
                            @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Answer</label>
                            <textarea wire:model="answer" class="form-control @error('answer') is-invalid @enderror" rows="5" placeholder="Enter the answer..."></textarea>
                            @error('answer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn {{ $isEditMode ? 'btn-success' : 'btn-primary' }}">
                                <span wire:loading.remove wire:target="save">
                                    <i class="ri-save-line me-1"></i> {{ $isEditMode ? 'Update FAQ' : 'Save FAQ' }}
                                </span>
                                <span wire:loading wire:target="save">Processing...</span>
                            </button>
                            @if($isEditMode)
                            <button type="button" wire:click="resetFields" class="btn btn-outline-secondary">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">FAQ List</h5>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0"><i class="ri-search-line"></i></span>
                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control bg-light border-start-0" placeholder="Search FAQ...">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mx-3 mt-3 border-0 shadow-sm" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3" width="50">#</th>
                                    <th>Question & Answer</th>
                                    <th class="text-end pe-3" width="120">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($faqs as $index => $faq)
                                <tr wire:key="faq-{{ $faq->id }}">
                                    <td class="ps-3 text-muted">{{ $faqs->firstItem() + $index }}</td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $faq->question }}</div>
                                        <div class="small text-muted mt-1 text-truncate" style="max-width: 400px;">
                                            {{ Str::limit($faq->answer, 100) }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button wire:click="edit({{ $faq->id }})" class="btn btn-sm btn-outline-success me-1">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button wire:click="delete({{ $faq->id }})"
                                            wire:confirm="Are you sure you want to delete this FAQ?"
                                            class="btn btn-sm btn-outline-danger">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="ri-questionnaire-line ri-2x d-block mb-2"></i>
                                        No FAQs found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($faqs->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $faqs->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>