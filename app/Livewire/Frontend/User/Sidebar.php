<?php

namespace App\Livewire\Frontend\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Sidebar extends Component
{
    use WithFileUploads;

    public $image;          // For the temporary preview
    public $current_image;  // To track the actual image name in the DB

    public function mount()
    {
        // Set the initial image from the database
        $this->current_image = Auth::user()->image;
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png,svg|max:2048',
        ]);

        $user = User::find(Auth::id());

        // 1. Delete old file
        if (!empty($user->image)) {
            $old_path = public_path('upload/profile_pic/' . $user->image);
            if (File::exists($old_path)) {
                File::delete($old_path);
            }
        }

        // 2. Process new file
        $filename = time() . '-' . rand(111, 999) . '.' . $this->image->getClientOriginalExtension();

        // Save using the custom disk we configured earlier
        $this->image->storeAs('profile_pic', $filename, 'public_uploads');

        // 3. Update Database
        $user->image = $filename;
        $user->save();

        // 4. UPDATE COMPONENT STATE IMMEDIATELY
        $this->current_image = $filename;

        // 5. Cleanup
        $this->reset('image'); // This removes the temporary preview

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Profile picture updated!']);
    }

    public function render()
    {
        return view('livewire.frontend.user.sidebar');
    }
}
