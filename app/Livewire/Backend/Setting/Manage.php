<?php

namespace App\Livewire\Backend\Setting;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;

class Manage extends Component
{
    use WithFileUploads;

    public $setting;
    
    // Properties for form fields
    public $website_name, $tagline, $refer_percentage, $min_refer, $dev_percentage;
    public $marketing_percentage, $copyright, $meta_desc, $tags;
    public $terms, $privacy, $refund, $refer, $about_1, $about_2;

    // Properties for file uploads
    public $new_logo, $new_footer_logo, $new_invoice_logo, $new_favicon, $new_og_image;

    protected $rules = [
        'website_name' => 'required|string|max:255',
        'tagline' => 'nullable|string|max:255',
        'refer_percentage' => 'nullable|numeric',
        'min_refer' => 'nullable|numeric',
        'new_logo' => 'nullable|image|max:1024', // 1MB Max
        'new_footer_logo' => 'nullable|image|max:1024',
        'new_invoice_logo' => 'nullable|image|max:1024',
        'new_favicon' => 'nullable|image|max:512',
        'new_og_image' => 'nullable|image|max:1024',
    ];

    public function mount()
    {
        $this->setting = Setting::findOrFail(1);
        $this->website_name = $this->setting->website_name;
        $this->tagline = $this->setting->tagline;
        $this->refer_percentage = $this->setting->refer_percentage;
        $this->min_refer = $this->setting->min_refer;
        $this->dev_percentage = $this->setting->dev_percentage;
        $this->marketing_percentage = $this->setting->marketing_percentage;
        $this->copyright = $this->setting->copyright;
        $this->meta_desc = $this->setting->meta_desc;
        $this->tags = $this->setting->tags;
        $this->terms = $this->setting->terms;
        $this->privacy = $this->setting->privacy;
        $this->refund = $this->setting->refund;
        $this->refer = $this->setting->refer;
        $this->about_1 = $this->setting->about_1;
        $this->about_2 = $this->setting->about_2;
    }

    private function uploadImage($file, $currentFilename, $prefix)
    {
        if ($file) {
            // Delete old file
            $oldPath = public_path('upload/images/' . $currentFilename);
            if ($currentFilename && File::exists($oldPath)) {
                File::delete($oldPath);
            }

            // Upload new file
            $filename = time() . '-' . $prefix . '-' . $file->getClientOriginalName();
            $file->storeAs('images', $filename, 'public_uploads'); // Ensure you have a 'public_uploads' disk pointing to upload/
            return $filename;
        }
        return $currentFilename;
    }

    public function update()
    {
        $this->validate();

        $this->setting->logo = $this->uploadImage($this->new_logo, $this->setting->logo, 'logo');
        $this->setting->footer_logo = $this->uploadImage($this->new_footer_logo, $this->setting->footer_logo, 'footer_logo');
        $this->setting->invoice_logo = $this->uploadImage($this->new_invoice_logo, $this->setting->invoice_logo, 'invoice_logo');
        $this->setting->favicon = $this->uploadImage($this->new_favicon, $this->setting->favicon, 'favicon');
        $this->setting->og_image = $this->uploadImage($this->new_og_image, $this->setting->og_image, 'og_image');

        $this->setting->update([
            'website_name' => $this->website_name,
            'tagline' => $this->tagline,
            'refer_percentage' => $this->refer_percentage,
            'min_refer' => $this->min_refer,
            'dev_percentage' => $this->dev_percentage,
            'marketing_percentage' => $this->marketing_percentage,
            'copyright' => $this->copyright,
            'meta_desc' => $this->meta_desc,
            'tags' => $this->tags,
            'terms' => $this->terms,
            'privacy' => $this->privacy,
            'refund' => $this->refund,
            'refer' => $this->refer,
            'about_1' => $this->about_1,
            'about_2' => $this->about_2,
        ]);

        session()->flash('success', 'Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.backend.setting.manage');
    }
}