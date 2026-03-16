<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'image',
        'n_id_front',
        'n_id_back',
        'affiliate_code',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Automatically hashes password in Laravel 10+
    ];

    /**
     * Accessor for Agent Profile Image
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? url('upload/agents/' . $this->image) : url('upload/no_image.jpg');
    }

    /**
     * Accessor for NID Front Image
     */
    public function getNidFrontUrlAttribute()
    {
        return $this->n_id_front ? url('upload/agents/nid/' . $this->n_id_front) : null;
    }

    /**
     * Accessor for NID Back Image
     */
    public function getNidBackUrlAttribute()
    {
        return $this->n_id_back ? url('upload/agents/nid/' . $this->n_id_back) : null;
    }

    /**
     * Relationship: An agent might have many referred users
     */
    public function referredUsers()
    {
        return $this->hasMany(User::class, 'refer_by_agent_code', 'affiliate_code');
    }
}
