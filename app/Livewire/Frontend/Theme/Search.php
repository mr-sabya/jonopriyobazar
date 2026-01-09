<?php

namespace App\Livewire\Frontend\Theme;

use Livewire\Component;
use Livewire\Attributes\Url;

class Search extends Component
{
    #[Url(as: 'search', history: true)]
    public $query = '';

    /**
     * This hook runs every time $query is updated.
     * It only takes ONE argument ($value).
     */
    public function updatedQuery($value)
    {
        $referer = request()->header('referer');

        // Check if we are currently on the shop page
        if (str_contains($referer, '/shop')) {
            // Dispatch the search term to the Shop Index component
            // We pass an array instead of named arguments for better compatibility
            $this->dispatch('filter-search', [
                'query' => $value
            ])->to(\App\Livewire\Frontend\Shop\Index::class);
        } else {
            // If not on shop page, redirect when user types 2+ characters
            if (strlen($value) >= 2) {
                // Using standard redirect without named arguments
                return $this->redirect('/shop?search=' . urlencode($value), true);
            }
        }
    }

    public function search()
    {
        if (!empty($this->query)) {
            return $this->redirect('/shop?search=' . urlencode($this->query), true);
        }
    }

    public function render()
    {
        return view('livewire.frontend.theme.search');
    }
}