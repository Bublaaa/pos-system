<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'menu_id',
        'quantity',
        'user_name',
        'kind',
        'image',
        'size',
        'temprature'
    ];
}