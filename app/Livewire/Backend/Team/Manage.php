<?php

namespace App\Livewire\Backend\Team;

use App\Models\Team;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Manage extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $name, $designation, $image, $team_id;
    public $old_image; // To display current image during edit
    public $search = '';
    public $isEditMode = false;

    // Validation Rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->designation = '';
        $this->image = null;
        $this->team_id = null;
        $this->old_image = null;
        $this->isEditMode = false;
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetFields();
        $this->dispatch('open-modal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        $team = Team::findOrFail($id);
        
        $this->team_id = $team->id;
        $this->name = $team->name;
        $this->designation = $team->designation;
        $this->old_image = $team->image;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate();

        $team = $this->isEditMode ? Team::find($this->team_id) : new Team;
        $team->name = $this->name;
        $team->designation = $this->designation;

        if ($this->image) {
            // Delete old file if updating
            if ($this->isEditMode && $team->image) {
                $oldPath = public_path('upload/images/' . $team->image);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }

            // Upload new file
            $filename = time() . '-team-' . $this->image->getClientOriginalName();
            $this->image->storeAs('images', $filename, 'public_uploads');
            $team->image = $filename;
        }

        $team->save();

        $this->dispatch('close-modal');
        $this->resetFields();
        session()->flash('success', $this->isEditMode ? 'Member updated successfully.' : 'Member added successfully.');
    }

    public function delete($id)
    {
        $team = Team::findOrFail($id);
        
        // Clean up file
        if ($team->image) {
            $path = public_path('upload/images/' . $team->image);
            if (File::exists($path)) { File::delete($path); }
        }
        
        $team->delete();
        session()->flash('success', 'Member removed successfully.');
    }

    public function render()
    {
        $teams = Team::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('designation', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.team.manage', [
            'teams' => $teams
        ]);
    }
}