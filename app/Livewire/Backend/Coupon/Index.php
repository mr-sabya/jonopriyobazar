<?php

namespace App\Livewire\Backend\Coupon;

use App\Models\Cupon as Coupon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Index extends Component
{
    use WithPagination;

    // Table State
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortDirection = 'desc';

    // Form Properties
    public $couponId, $code, $amount, $expire_date, $limit = 0;
    public $isEditMode = false;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'code' => ['required', 'string', 'max:255', Rule::unique('cupons', 'code')->ignore($this->couponId)],
            'amount' => 'required|numeric',
            'expire_date' => 'required|date',
            'limit' => 'required|integer|min:0',
        ];
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetFields()
    {
        $this->reset(['code', 'amount', 'expire_date', 'limit', 'couponId', 'isEditMode']);
        $this->resetErrorBag();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->dispatch('openCouponModal');
    }

    public function edit($id)
    {
        $this->resetFields();
        $this->isEditMode = true;
        $this->couponId = $id;

        $coupon = Coupon::findOrFail($id);
        $this->code = $coupon->code;
        $this->amount = $coupon->amount;
        $this->expire_date = $coupon->expire_date;
        $this->limit = $coupon->limit;

        $this->dispatch('openCouponModal');
    }

    public function save()
    {
        $this->validate();

        $data = [
            'code' => strtoupper($this->code),
            'amount' => $this->amount,
            'expire_date' => $this->expire_date,
            'limit' => $this->limit,
        ];

        Coupon::updateOrCreate(['id' => $this->couponId], $data);

        $this->dispatch('closeCouponModal');
        $this->resetFields();
        session()->flash('success', $this->isEditMode ? 'Coupon updated successfully.' : 'New coupon created successfully.');
    }

    public function delete($id)
    {
        Coupon::destroy($id);
        session()->flash('success', 'Coupon deleted successfully.');
    }

    public function render()
    {
        $coupons = Coupon::where('code', 'like', '%' . $this->search . '%')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.backend.coupon.index', compact('coupons'));
    }
}