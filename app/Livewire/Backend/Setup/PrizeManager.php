<?php

namespace App\Livewire\Backend\Setup;

use App\Models\Prize;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class PrizeManager extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $title;
    public $point;
    public $image;      // For new uploads
    public $oldImage;   // For showing current image during edit
    public $prizeId;
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
            'title' => 'required|string|max:255',
            'point' => 'required|integer|min:0',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function resetInput()
    {
        $this->title = '';
        $this->point = '';
        $this->image = null;
        $this->oldImage = null;
        $this->prizeId = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetInput();
        $this->dispatch('open-modal', id: 'prizeModal');
    }

    public function store()
    {
        $this->validate();

        $filename = null;
        if ($this->image) {
            $filename = time() . '-prize-' . $this->image->getClientOriginalName();
            $this->image->storeAs('images', $filename, 'public_uploads');
        }

        Prize::create([
            'title' => $this->title,
            'point' => $this->point,
            'prize' => $filename,
        ]);

        $this->dispatch('swal', ['title' => 'Success!', 'text' => 'Prize added successfully', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'prizeModal');
        $this->resetInput();
    }

    public function edit($id)
    {
        $this->resetInput();
        $prize = Prize::findOrFail($id);
        $this->prizeId = $prize->id;
        $this->title = $prize->title;
        $this->point = $prize->point;
        $this->oldImage = $prize->prize;
        $this->isEditMode = true;

        $this->dispatch('open-modal', id: 'prizeModal');
    }

    public function update()
    {
        $this->validate();

        $prize = Prize::findOrFail($this->prizeId);
        $filename = $prize->prize;

        if ($this->image) {
            // Delete old file
            if ($prize->prize && File::exists(public_path('upload/images/' . $prize->prize))) {
                File::delete(public_path('upload/images/' . $prize->prize));
            }
            // Upload new
            $filename = time() . '-prize-' . $this->image->getClientOriginalName();
            $this->image->storeAs('images', $filename, 'public_uploads');
        }

        $prize->update([
            'title' => $this->title,
            'point' => $this->point,
            'prize' => $filename,
        ]);

        $this->dispatch('swal', ['title' => 'Updated!', 'text' => 'Prize updated successfully', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'prizeModal');
        $this->resetInput();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->dispatch('open-modal', id: 'deleteModal');
    }

    public function delete()
    {
        $prize = Prize::findOrFail($this->deleteId);
        if ($prize->prize && File::exists(public_path('upload/images/' . $prize->prize))) {
            File::delete(public_path('upload/images/' . $prize->prize));
        }
        $prize->delete();

        $this->dispatch('swal', ['title' => 'Deleted!', 'text' => 'Prize removed', 'icon' => 'success']);
        $this->dispatch('close-modal', id: 'deleteModal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prizes = Prize::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.setup.prize-manager', [
            'prizes' => $prizes
        ]);
    }
}
