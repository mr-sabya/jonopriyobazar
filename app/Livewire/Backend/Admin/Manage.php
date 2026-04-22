<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Admin;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Manage extends Component
{
    public $userId; // For Mount
    public $name, $email, $phone, $password, $password_confirmation;
    public $selectedRoles = [];
    public $isEditMode = false;

    public function mount($userId = null)
    {
        if ($userId) {
            $this->userId = $userId;
            $this->isEditMode = true;
            $user = Admin::findOrFail($userId);
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->selectedRoles = $user->getRoleNames()->toArray();
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|max:50',
            'email' => [
                'required', 'email', 'max:100',
                $this->isEditMode ? Rule::unique('admins')->ignore($this->userId) : 'unique:admins',
            ],
            'phone' => [
                'required', 'max:100',
                $this->isEditMode ? Rule::unique('admins')->ignore($this->userId) : 'unique:admins',
            ],
            'password' => $this->isEditMode ? 'nullable|min:6|confirmed' : 'required|min:6|confirmed',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->isEditMode) {
            $user = Admin::find($this->userId);
            $user->update($data);
            $user->syncRoles($this->selectedRoles);
            session()->flash('success', 'Admin updated successfully.');
        } else {
            $user = Admin::create($data);
            $user->assignRole($this->selectedRoles);
            session()->flash('success', 'Admin created successfully.');
        }

        return $this->redirect(route('admin.admins.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.backend.admin.manage', [
            'roles' => Role::all()
        ]);
    }
}