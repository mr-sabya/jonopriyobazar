<?php

namespace App\Livewire\Backend\Setup;

use App\Models\PowerCompany;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class PowerCompanyManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $name;
    public $type;
    public $logo;
    public $oldLogo; // To display existing image during edit
    public $powerId;
    public $isEditMode = false;

    // Table Controls
    public $search = '';
    public $deleteId;

    /**
     * Validation Rules
     */
    protected function rules()
    {
        return [
            'name' => 'required|max:255',
            'type' => 'required|max:100',
            'logo' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function resetInput()
    {
        $this->name = '';
        $this->type = '';
        $this->logo = null;
        $this->oldLogo = null;
        $this->powerId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    /**
     * Create Mode
     */
    public function create()
    {
        $this->resetInput();
        $this->dispatch('open-modal', id: 'powerModal');
    }

    /**
     * Store New Company
     */
    public function store()
    {
        $this->validate();

        $filename = null;
        if ($this->logo) {
            $filename = time() . '-power-' . $this->logo->getClientOriginalName();
            $this->logo->storeAs('images', $filename, 'public_uploads');
            // Note: Ensure you have a 'public_uploads' disk pointing to public/upload
        }

        PowerCompany::create([
            'name' => $this->name,
            'type' => $this->type,
            'logo' => $filename,
        ]);

        $this->dispatch('swal', ['title' => 'Success!', 'text' => 'Company added successfully', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'powerModal');
        $this->resetInput();
    }

    /**
     * Edit Mode
     */
    public function edit($id)
    {
        $this->resetInput();
        $power = PowerCompany::findOrFail($id);
        $this->powerId = $power->id;
        $this->name = $power->name;
        $this->type = $power->type;
        $this->oldLogo = $power->logo;
        $this->isEditMode = true;

        $this->dispatch('open-modal', id: 'powerModal');
    }

    /**
     * Update Company
     */
    public function update()
    {
        $this->validate();

        $power = PowerCompany::findOrFail($this->powerId);
        $filename = $power->logo;

        if ($this->logo) {
            // Delete old logo
            if ($power->logo && File::exists(public_path('upload/images/' . $power->logo))) {
                File::delete(public_path('upload/images/' . $power->logo));
            }
            // Upload new
            $filename = time() . '-power-' . $this->logo->getClientOriginalName();
            $this->logo->storeAs('images', $filename, 'public_uploads');
        }

        $power->update([
            'name' => $this->name,
            'type' => $this->type,
            'logo' => $filename,
        ]);

        $this->dispatch('swal', ['title' => 'Updated!', 'text' => 'Company updated successfully', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'powerModal');
        $this->resetInput();
    }

    /**
     * Delete logic
     */
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('open-modal', id: 'deleteModal');
    }

    public function delete()
    {
        $power = PowerCompany::findOrFail($this->deleteId);
        if ($power->logo && File::exists(public_path('upload/images/' . $power->logo))) {
            File::delete(public_path('upload/images/' . $power->logo));
        }
        $power->delete();

        $this->dispatch('swal', ['title' => 'Deleted!', 'text' => 'Company removed', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'deleteModal');
    }

    public function render()
    {
        $companies = PowerCompany::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.setup.power-company-manager', [
            'companies' => $companies
        ]);
    }
}
