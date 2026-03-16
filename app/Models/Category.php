<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'image',
        'p_id',
        'is_home',
        'added_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_home' => 'boolean',
        'p_id' => 'integer',
    ];

    /**
     * Relationship: Get the Parent Category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'p_id', 'id');
    }

    /**
     * Relationship: Get Subcategories
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'p_id', 'id');
    }

    /**
     * Alias for subcategories (keeping your existing method name)
     */
    public function sub()
    {
        return $this->subcategories();
    }

    /**
     * Relationship: Products in this category
     * Note: This assumes a pivot table category_product exists
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /**
     * Accessor for Category Image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/images/category/' . $this->image) : url('upload/no_image.jpg');
    }

    /**
     * Accessor for Category Icon URL
     */
    public function getIconUrlAttribute()
    {
        return $this->icon ? url('upload/images/category/icon/' . $this->icon) : url('upload/no_icon.png');
    }

    /**
     * Scope: Only Main Categories (Top Level)
     */
    public function scopeMain($query)
    {
        return $query->where('p_id', 0);
    }

    /**
     * Scope: Only categories marked for Home Screen
     */
    public function scopeHome($query)
    {
        return $query->where('is_home', true);
    }
}
