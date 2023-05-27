<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function get_latest_account(){
        $latest_account = Account::where('user_id',$this->id)->latest()->first();
        return $latest_account;
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function transactions()
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }
    public function from_transfers()
    {
        return $this->hasManyThrough(Transfer::class, Account::class,'user_id','from');
    }

    public function to_transfers()
    {
        return $this->hasManyThrough(Transfer::class, Account::class,'user_id','to');
    }



    public function is_exist_account($country){
        $is_exist = Account::where('user_id',$this->id)->where('country',$country)->first();
        if($is_exist){
            return true;
        }
        return false;
    }

}
