<?php

namespace App\Livewire\Backend\DeliveryStatus;

use App\Models\DeliveryStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class Manage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Properties
    public $name, $slug, $hidden_id;
    public $search = '';
    public $isEditMode = false;

    // Validation Rules
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('delivery_statuses', 'slug')->ignore($this->hidden_id),
            ],
        ];
    }

    /**
     * Auto-generate slug when name is updated
     */
    public function updatedName($value)
    {
        $this->slug = Str::slug($value);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->hidden_id = null;
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
        $status = DeliveryStatus::findOrFail($id);
        
        $this->hidden_id = $status->id;
        $this->name = $status->name;
        $this->slug = $status->slug;
        $this->isEditMode = true;

        $this->dispatch('open-modal');
    }

    public function save()
    {
        $this->validate();

        DeliveryStatus::updateOrCreate(
            ['id' => $this->hidden_id],
            [
                'name' => $this->name,
                'slug' => $this->slug,
            ]
        );

        $this->dispatch('close-modal');
        session()->flash('success', $this->isEditMode ? 'Status updated successfully' : 'New Status added successfully');
        $this->resetFields();
    }

    public function delete($id)
    {
        DeliveryStatus::findOrFail($id)->delete();
        session()->flash('success', 'Status deleted successfully');
    }

    public function render()
    {
        $statuses = DeliveryStatus::where('name', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.backend.delivery-status.manage', [
            'statuses' => $statuses
        ]);
    }
}