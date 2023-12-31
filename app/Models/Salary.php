<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'basic_salary',
        'attendance_precentage',
        'salary',
        'additional_salary_name',
        'additional_salary',
        'month',
        'year',
    ];
}