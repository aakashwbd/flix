<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $appends = ['is_favourite', 'is_latest', 'is_blocked'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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

    public function favourites()
    {
        return $this->hasMany(favourite::class, 'favourite_user_id', 'id');
    }
    public function blocked()
    {
        return $this->hasMany(BlockList::class, 'block_user_id', 'id');
    }


    public function getIsFavouriteAttribute(){
        if(request()->user('sanctum')){
            return (bool)$this->favourites->where('user_id', request()->user('sanctum')['id'])->first();
        }else{
            return false;
        }
    }

    public function ad(){
        return $this->hasMany(Ad::class);
    }


    public function getIsBlockedAttribute(){
        if(request()->user('sanctum')){
            return (bool)$this->blocked->where('user_id', request()->user('sanctum')['id'])->first();
        }else{
            return false;
        }
    }

    public function getIsLatestAttribute(){
        return $this->created_at->toFormattedDateString();
    }

}
