<?php

namespace App\Livewire\Backend\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class Manage extends Component
{
    use WithFileUploads;

    public $productId, $isEditMode = false;
    public $name, $slug, $description, $quantity, $sale_price, $actual_price, $off, $point;
    public $is_percentage = 0, $is_stock = 1, $image, $oldImage;
    public $selectedCategories = [];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->isEditMode = true;
            $this->productId = $productId;
            $product = Product::with('categories')->findOrFail($productId);
            
            $this->name = $product->name;
            $this->slug = $product->slug;
            $this->description = $product->description;
            $this->quantity = $product->quantity;
            $this->sale_price = $product->sale_price;
            $this->actual_price = $product->actual_price;
            $this->off = $product->off;
            $this->point = $product->point;
            $this->is_percentage = $product->is_percentage;
            $this->is_stock = $product->is_stock;
            $this->oldImage = $product->image;
            $this->selectedCategories = $product->categories->pluck('id')->toArray();
        }
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', Rule::unique('products')->ignore($this->productId)],
            'selectedCategories' => 'required|array|min:1',
            'sale_price' => 'required|numeric',
            'quantity' => 'required',
            'image' => $this->isEditMode ? 'nullable|image|max:1024' : 'required|image|max:1024',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'sale_price' => $this->sale_price,
            'actual_price' => $this->actual_price,
            'off' => $this->off,
            'point' => $this->point,
            'is_percentage' => $this->is_percentage ? 1 : 0,
            'is_stock' => $this->is_stock ? 1 : 0,
            'added_by' => Auth::id(),
        ];

        if ($this->image) {
            if ($this->oldImage) {
                $oldPath = public_path('upload/images/' . $this->oldImage);
                if (File::exists($oldPath)) { File::delete($oldPath); }
            }
            $filename = time() . '.' . $this->image->getClientOriginalExtension();
            $this->image->storeAs('upload/images', $filename, 'public_uploads');
            $data['image'] = $filename;
        }

        $product = $this->isEditMode ? Product::find($this->productId) : new Product();
        $product->fill($data)->save();
        $product->categories()->sync($this->selectedCategories);

        session()->flash('success', 'Product saved successfully.');
        return redirect()->route('admin.products.index');
    }

    public function render()
    {
        return view('livewire.backend.product.manage', [
            'categories' => Category::with('sub.sub')->where('p_id', 0)->get()
        ]);
    }
}