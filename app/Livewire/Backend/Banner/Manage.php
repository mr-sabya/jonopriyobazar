<?php

namespace App\Livewire\Backend\Banner;

use App\Models\Banner;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Manage extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    // Form properties
    public $title, $link, $image, $banner_id;
    public $old_image; // To show existing image during edit
    public $search = '';
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'title' => 'required|max:255',
            'link' => 'nullable|url',
            'image' => $this->isEditMode ? 'nullable|image|max:2048' : 'required|image|max:2048',
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->title = '';
        $this->link = '';
        $this->image = null;
        $this->banner_id = null;
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
        $banner = Banner::findOrFail($id);
        
        $this->banner_id = $banner->id;
        $this->title = $banner->title;
        $this->link = $banner->link;
        $this->old_image = $banner->image;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate();

        $banner = $this->isEditMode ? Banner::find($this->banner_id) : new Banner;
        $banner->title = $this->title;
        $banner->link = $this->link;

        if ($this->image) {
            // Delete old file if updating
            if ($this->isEditMode && $banner->image) {
                $oldPath = public_path('upload/images/' . $banner->image);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }

            // Upload new file
            $filename = time() . '-banner-' . $this->image->getClientOriginalName();
            $this->image->storeAs('images', $filename, 'public_uploads');
            $banner->image = $filename;
        }

        $banner->save();

        $this->dispatch('close-modal');
        $this->resetFields();
        session()->flash('success', $this->isEditMode ? 'Banner updated successfully.' : 'Banner created successfully.');
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        $path = public_path('upload/images/' . $banner->image);
        if (File::exists($path)) { File::delete($path); }
        
        $banner->delete();
        session()->flash('success', 'Banner deleted successfully.');
    }

    public function render()
    {
        $banners = Banner::where('title', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.banner.manage', [
            'banners' => $banners
        ]);
    }
}