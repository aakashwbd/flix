<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockList extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function block_user(){
        return $this->belongsTo(User::class);
    }
}
