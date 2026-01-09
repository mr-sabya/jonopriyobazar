<?php

namespace App\Livewire\Frontend\Shop;

use App\Models\Product;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination;

    // Track filters in the URL
    #[Url(history: true)]
    public $category = '';

    #[Url(history: true)]
    public $search = ''; // ADD THIS LINE

    #[Url(history: true)]
    public $sort = 'name-asc';

    public $perPage = 30;

    // Reset pagination when filters change
    public function updatedCategory()
    {
        $this->resetPage();
        $this->perPage = 30;
    }
    public function updatedSort()
    {
        $this->resetPage();
    }

    // Reset pagination when search changes
    /**
     * Listen for the search event from the Search Component
     */
    #[On('filter-search')]
    public function handleSearch($data)
    {
        $this->search = is_array($data) ? ($data['query'] ?? '') : $data;
        $this->resetPage(); // Back to page 1
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function render()
    {
        $query = Product::with('categories')
            ->where('is_stock', 1);

        // Filter by Category Slug
        if ($this->category) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', $this->category);
            });
        }

        // ADD SEARCH LOGIC HERE
        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }
        // Sorting Logic
        switch ($this->sort) {
            case 'price-low':
                $query->orderBy('price', 'ASC');
                break;
            case 'price-high':
                $query->orderBy('price', 'DESC');
                break;
            case 'name-desc':
                $query->orderBy('name', 'DESC');
                break;
            default:
                $query->orderBy('name', 'ASC');
                break;
        }

        return view('livewire.frontend.shop.index', [
            'products' => $query->paginate($this->perPage)
        ]);
    }
}
