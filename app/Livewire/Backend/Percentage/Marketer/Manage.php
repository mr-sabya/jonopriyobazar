<?php

namespace App\Livewire\Backend\Percentage\Marketer;

use Livewire\Component;
use App\Models\MarketerWithdraw;
use App\Models\MarketerPercentage;
use Livewire\WithPagination;

class Manage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form Properties
    public $date, $amount, $method;
    
    // Stats
    public $totalEarning = 0;
    public $totalWithdraw = 0;
    public $balance = 0;

    protected $rules = [
        'date' => 'required|date',
        'amount' => 'required|numeric|min:1',
        'method' => 'nullable|string|max:100',
    ];

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $this->totalEarning = MarketerPercentage::sum('amount');
        $this->totalWithdraw = MarketerWithdraw::sum('amount');
        $this->balance = $this->totalEarning - $this->totalWithdraw;
    }

    public function store()
    {
        $this->validate();

        MarketerWithdraw::create([
            'date' => $this->date,
            'amount' => $this->amount,
            'method' => $this->method,
        ]);

        $this->reset(['date', 'amount', 'method']);
        $this->calculateStats();
        
        $this->dispatch('close-modal');
        session()->flash('success', 'Marketer withdraw has been completed.');
    }

    public function deleteWithdraw($id)
    {
        $withdraw = MarketerWithdraw::findOrFail($id);
        $withdraw->delete();

        $this->calculateStats();
        session()->flash('success', 'Withdraw record deleted! Marketer income has been refunded.');
    }

    public function render()
    {
        return view('livewire.backend.percentage.marketer.manage', [
            'percentages' => MarketerPercentage::with('order')->latest()->paginate(10, ['*'], 'earnPage'),
            'withdraws' => MarketerWithdraw::latest()->paginate(10, ['*'], 'withdrawPage'),
        ]);
    }
}