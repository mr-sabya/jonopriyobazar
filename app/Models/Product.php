<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

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
