<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'quantity',
        'sale_price',
        'actual_price',
        'off',
        'is_percentage',
        'point',
        'image',
        'description',
        'added_by'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    // Accessor for the image URL
    public function getImageUrlAttribute()
    {
        // Define the relative path to the image
        $path = 'upload/images/' . $this->image;

        // Check if the image field is not empty and the file exists in the public folder
        if (!empty($this->image) && File::exists(public_path($path))) {
            return asset($path);
        }

        // Return a demo image if not found
        // Ensure you have a 'demo.png' in public/frontend/images/
        return asset('frontend/images/demo-image.png');
    }


    public function getCleanDescriptionAttribute()
    {
        $content = $this->description;

        // 1. Replace multiple <br> with one
        $content = preg_replace('/(<br\s*\/?>\s*){2,}/i', '<br>', $content);

        // 2. Remove empty paragraphs
        $content = preg_replace('/<p>\s*(<br\s*\/?>|&nbsp;)*\s*<\/p>/i', '', $content);

        // 3. Trim whitespace from start and end
        return trim($content);
    }
}
