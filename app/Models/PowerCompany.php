<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PowerCompany extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'type',
        'logo',
    ];

    /**
     * Relationship: A power company can have many electricity bill orders.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'company_id');
    }

    /**
     * Accessor for Company Logo URL
     * Usage in Blade: {{ $company->logo_url }}
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? url('upload/images/company/' . $this->logo) : url('upload/no_logo.png');
    }

    /**
     * Scope a query to filter by type (e.g., Prepaid/Postpaid)
     * Usage: PowerCompany::whereType('Prepaid')->get();
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
