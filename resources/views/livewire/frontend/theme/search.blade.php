<div class="flex-grow-1 mx-3 mx-lg-5 search-wrapper">
    <form wire:submit.prevent="search" class="position-relative">
        <input
            type="text"
            wire:model.live.debounce.300ms="query"
            id="search-input"
            class="form-control rounded-pill-custom"
            placeholder="Search products..."
            autocomplete="off"
            {{-- Focus logic using plain JS to avoid closure issues --}}
            x-init="if (window.location.pathname.includes('/shop')) { $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length); }">
        <button type="submit" class="search-btn-custom">
            <i class="lnr lnr-magnifier d-md-none"></i>
            <span class="d-none d-md-block">SEARCH</span>
        </button>
    </form>
</div>