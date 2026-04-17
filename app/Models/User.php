<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'username',
        'phone',
        'is_varified',
        'code',
        'address',
        'affiliate_code',
        'ref_code',
        'referral_id',
        'is_percentage',
        'agent_code',
        'agent_id',
        'wallet_request',
        'request_date',
        'n_id_front',
        'n_id_back',
        'wallet_package_id',
        'is_wallet',
        'wallet_balance',
        'is_hold',
        'is_expired',
        'ref_balance',
        'point',
        'image',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_varified' => 'boolean',
        'is_percentage' => 'boolean',
        'is_wallet' => 'boolean',
        'is_hold' => 'boolean',
        'is_expired' => 'boolean',
        'status' => 'integer',
        'wallet_balance' => 'double',
        'ref_balance' => 'double',
        'point' => 'integer',
        'request_date' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class, 'user_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * Self-referencing relationship: Users referred by this user.
     */
    public function refers(): HasMany
    {
        return $this->hasMany(User::class, 'referral_id');
    }

    /**
     * The user who referred this user.
     */
    public function referrer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'referral_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'user_id');
    }

    public function applywallets(): HasMany
    {
        return $this->hasMany(CustomerWallet::class, 'user_id');
    }

    public function activePackage(): BelongsTo
    {
        return $this->belongsTo(Walletpackage::class, 'wallet_package_id');
    }

    public function walletPurchase(): HasMany
    {
        return $this->hasMany(WalletPurchase::class, 'user_id');
    }

    public function walletPay(): HasMany
    {
        return $this->hasMany(Payments::class, 'user_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Accessor for Profile Image URL.
     */
    public function getImageUrlAttribute()
    {
        $path = 'upload/images/user/' . $this->image;
        if (!empty($this->image) && File::exists(public_path($path))) {
            return asset($path);
        }
        return asset('assets/backend/images/demo-user.png');
    }

    /**
     * Accessor for NID Front Image.
     */
    public function getNidFrontUrlAttribute()
    {
        return $this->n_id_front ? asset('upload/images/user/nid/' . $this->n_id_front) : null;
    }

    /**
     * Accessor for NID Back Image.
     */
    public function getNidBackUrlAttribute()
    {
        return $this->n_id_back ? asset('upload/images/user/nid/' . $this->n_id_back) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers & Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user has already applied for a specific wallet package.
     */
    public function applyWallet($packageId)
    {
        return $this->applywallets()->where('package_id', $packageId)->exists();
    }

    /**
     * Scope: Only active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('is_hold', false);
    }

    /**
     * Scope: Only verified users.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_varified', true);
    }
}
