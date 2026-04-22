<?php

namespace App\Livewire\Backend\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    // Form State
    public $categoryId, $name, $slug, $p_id = 0, $is_home = 0;
    public $icon, $image, $oldIcon, $oldImage;
    public $isEditMode = false;

    protected $paginationTheme = 'bootstrap';

    // Auto-generate slug
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetFields()
    {
        $this->reset(['name', 'slug', 'p_id', 'is_home', 'icon', 'image', 'categoryId', 'isEditMode', 'oldIcon', 'oldImage']);
        $this->resetErrorBag();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->dispatch('openModal');
    }

    public function edit($id)
    {
        $this->authorize('category.edit');
        $this->resetFields();
        $this->isEditMode = true;

        $category = Category::findOrFail($id);
        $this->categoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->p_id = $category->p_id;
        $this->is_home = $category->is_home;
        $this->oldIcon = $category->icon;
        $this->oldImage = $category->image;

        $this->dispatch('openModal');
    }

    public function save()
    {
        $permission = $this->isEditMode ? 'category.edit' : 'category.create';
        $this->authorize($permission);

        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', $this->isEditMode ? Rule::unique('categories')->ignore($this->categoryId) : 'unique:categories'],
            'p_id' => 'required',
            'icon' => 'nullable|image|max:1024', // 1MB Max
            'image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        $category = $this->isEditMode ? Category::find($this->categoryId) : new Category();

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'p_id' => $this->p_id,
            'is_home' => $this->is_home ? 1 : 0,
            'added_by' => Auth::id(),
        ];

        if ($this->icon) {
            if ($this->oldIcon) {
                $this->deleteFile($this->oldIcon);
            }
            $data['icon'] = $this->icon->store('upload/images', 'public_uploads');
        }

        if ($this->image) {
            if ($this->oldImage) {
                $this->deleteFile($this->oldImage);
            }
            $data['image'] = $this->image->store('upload/images', 'public_uploads');
        }

        $category->fill($data)->save();

        $this->dispatch('closeModal');
        session()->flash('success', $this->isEditMode ? 'Category updated.' : 'Category created.');
        $this->resetFields();
    }

    public function delete($id)
    {
        $this->authorize('admin.category.destroy');
        $category = Category::findOrFail($id);
        if ($category->icon) {
            $this->deleteFile($category->icon);
        }
        if ($category->image) {
            $this->deleteFile($category->image);
        }
        $category->delete();
        session()->flash('success', 'Category deleted.');
    }

    private function deleteFile($path)
    {
        $fullPath = public_path('upload/images/' . $path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    public function render()
    {
        // Fetch categories for the list with search and hierarchy
        $categories = Category::with('sub.sub')
            ->where('p_id', 0)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        // Fetch parent categories for the dropdown
        $parent_categories = Category::where('p_id', 0)->get();

        return view('livewire.backend.category.index', [
            'categories' => $categories,
            'parent_categories' => $parent_categories
        ]);
    }
}