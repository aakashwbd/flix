<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class favourite extends Model
{

    use HasFactory;
    protected $guarded=[];

    public function favourite_user(){
        return $this->belongsTo(User::class);
    }


}
