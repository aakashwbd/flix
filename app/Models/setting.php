<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class setting extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        'age'=>'array',
        'image'=>'array',
        'social'=>'array',
        'help'=>'array',
        'partner_site'=>'array',
        'legal_information'=>'array',
    ];
}
