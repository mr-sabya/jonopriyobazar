<?php

namespace App\Livewire\Backend\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    protected $paginationTheme = 'bootstrap';

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function delete($id)
    {
        $this->authorize('admin.products.destroy');
        $product = Product::findOrFail($id);

        if ($product->image) {
            $path = public_path('upload/images/' . $product->image);
            if (File::exists($path)) { File::delete($path); }
        }

        $product->delete();
        session()->flash('success', 'Product deleted successfully.');
    }

    public function render()
    {
        $products = Product::with('categories')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.product.index', compact('products'));
    }
}