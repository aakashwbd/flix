<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $casts=[
        'reports'=>'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reported_user(){
        return $this->belongsTo(User::class);
    }
}
