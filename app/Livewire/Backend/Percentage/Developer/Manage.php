<?php

namespace App\Livewire\Backend\Percentage\Developer;

use Livewire\Component;
use App\Models\DeveloperWithdraw;
use App\Models\DeveloperPercentage;
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
        'method' => 'required|string|max:100',
    ];

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        $this->totalEarning = DeveloperPercentage::sum('amount');
        $this->totalWithdraw = DeveloperWithdraw::sum('amount');
        $this->balance = $this->totalEarning - $this->totalWithdraw;
    }

    public function store()
    {
        $this->validate();

        DeveloperWithdraw::create([
            'date' => $this->date,
            'amount' => $this->amount,
            'method' => $this->method,
        ]);

        $this->reset(['date', 'amount', 'method']);
        $this->calculateStats();
        
        $this->dispatch('close-modal');
        session()->flash('success', 'Withdrawal has been completed successfully.');
    }

    public function deleteWithdraw($id)
    {
        $withdraw = DeveloperWithdraw::findOrFail($id);
        $withdraw->delete();

        $this->calculateStats();
        session()->flash('success', 'Withdrawal record deleted and balance updated.');
    }

    public function render()
    {
        return view('livewire.backend.percentage.developer.manage', [
            'percentages' => DeveloperPercentage::with('order')->latest()->paginate(10, ['*'], 'earnPage'),
            'withdraws' => DeveloperWithdraw::latest()->paginate(10, ['*'], 'withdrawPage'),
        ]);
    }
}