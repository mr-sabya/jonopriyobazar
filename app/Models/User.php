<?php

namespace App\Models;

use DB;
use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use \Rackbeat\UIAvatars\HasAvatar;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function cartItems()
    {
        return $this->hasMany('App\Models\Cart', 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address', 'user_id');
    }

    public function refers()
    {
        return $this->hasMany('App\Models\User', 'referral_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Models\Wishlist', 'user_id');
    }

    public function applywallets()
    {
        return $this->hasMany('App\Models\CustomerWallet', 'user_id');
    }

    

    public function applyWallet($id)
    {
        $packages = $this->applywallets->where('package_id', $id)->count();

        if($packages == 1){
            return true;
        }else{
            return false;
        }
    }

    public function activePackage()
    {
        return $this->belongsTo('App\Models\Walletpackage', 'wallet_package_id');
    }

    public function userPackages()
    {
        return $this->hasMany('App\Models\CustomerWallet', 'user_id');
    }

    public function walletPurchase()
    {
        return $this->hasMany('App\Models\WalletPurchase', 'user_id');
    }

    public function walletPay()
    {
        return $this->hasMany('App\Models\Payments', 'user_id');
    }

    
    
}
