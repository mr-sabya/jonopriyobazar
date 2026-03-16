<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'website_name',
        'tagline',
        'logo',
        'footer_logo',
        'favicon',
        'copyright',
        'refer_percentage',
        'min_refer',
        'dev_percentage',
        'marketing_percentage',
        'invoice_logo',
        'meta_desc',
        'tags',
        'og_image',
        'terms',
        'privacy',
        'refund',
        'refer',
        'about_1',
        'about_2',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'refer_percentage' => 'double',
        'dev_percentage' => 'double',
        'marketing_percentage' => 'double',
        'min_refer' => 'integer',
    ];

    /**
     * Accessor for Main Logo URL
     * Usage: $setting->logo_url
     */
    public function getLogoUrlAttribute()
    {
        return $this->logo ? url('upload/images/setting/' . $this->logo) : url('upload/no_image.jpg');
    }

    /**
     * Accessor for Footer Logo URL
     */
    public function getFooterLogoUrlAttribute()
    {
        return $this->footer_logo ? url('upload/images/setting/' . $this->footer_logo) : $this->logo_url;
    }

    /**
     * Accessor for Favicon URL
     */
    public function getFaviconUrlAttribute()
    {
        return $this->favicon ? url('upload/images/setting/' . $this->favicon) : url('favicon.ico');
    }

    /**
     * Accessor for Invoice Logo URL
     */
    public function getInvoiceLogoUrlAttribute()
    {
        return $this->invoice_logo ? url('upload/images/setting/' . $this->invoice_logo) : $this->logo_url;
    }

    /**
     * Accessor for OG (Social Media) Image URL
     */
    public function getOgImageUrlAttribute()
    {
        return $this->og_image ? url('upload/images/setting/' . $this->og_image) : $this->logo_url;
    }
}
