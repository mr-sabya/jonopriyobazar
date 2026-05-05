<?php

namespace App\Livewire\Backend\Wallet\WalletPackage;

use App\Models\Walletpackage;
use Livewire\Component;
use Livewire\WithPagination;

class Manager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $amount;
    public $validate;
    public $packageId;
    public $isEditMode = false;

    // Search and Delete Properties
    public $search = '';
    public $packageIdToDelete;

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'amount' => 'required|numeric|min:1',
            'validate' => 'required|numeric|min:1',
        ];
    }

    /**
     * Reset Input Fields
     */
    public function resetInput()
    {
        $this->amount = '';
        $this->validate = '';
        $this->packageId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Save New Package
     */
    public function store()
    {
        $this->validate();

        Walletpackage::create([
            'amount' => $this->amount,
            'validate' => $this->validate,
        ]);

        $this->dispatch('swal', [
            'title' => 'Success!',
            'text' => 'New Package added successfully',
            'icon' => 'success'
        ]);

        $this->resetInput();
    }

    /**
     * Load Data for Edit
     */
    public function edit($id)
    {
        $this->resetErrorBag();
        $package = Walletpackage::findOrFail($id);
        $this->packageId = $package->id;
        $this->amount = $package->amount;
        $this->validate = $package->validate;
        $this->isEditMode = true;
    }

    /**
     * Update Existing Package
     */
    public function update()
    {
        $this->validate();

        $package = Walletpackage::findOrFail($this->packageId);
        $package->update([
            'amount' => $this->amount,
            'validate' => $this->validate,
        ]);

        $this->dispatch('swal', [
            'title' => 'Updated!',
            'text' => 'Package updated successfully',
            'icon' => 'success'
        ]);

        $this->resetInput();
    }

    /**
     * Trigger Delete Confirmation Modal
     */
    public function confirmDelete($id)
    {
        $this->packageIdToDelete = $id;
        // Dispatch event to show Bootstrap Modal
        $this->dispatch('open-delete-modal');
    }

    /**
     * Final Deletion
     */
    public function delete()
    {
        if ($this->packageIdToDelete) {
            Walletpackage::findOrFail($this->packageIdToDelete)->delete();

            $this->dispatch('swal', [
                'title' => 'Deleted!',
                'text' => 'Package has been removed',
                'icon' => 'success'
            ]);
        }

        $this->packageIdToDelete = null;
        $this->dispatch('close-delete-modal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $packages = Walletpackage::query()
            ->where('amount', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.wallet.wallet-package.manager', [
            'packages' => $packages
        ]);
    }
}
