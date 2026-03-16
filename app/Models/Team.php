<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'designation',
        'image',
        'status', // Added status for visibility control
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Accessor for Team Member Image URL
     * Usage in Blade: {{ $member->image_url }}
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/images/team/' . $this->image) : url('upload/no_image.jpg');
    }

    /**
     * Scope a query to only include active team members.
     * Usage: Team::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    /**
     * Scope a query to sort team members by the latest added.
     */
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('id', 'DESC');
    }
}
