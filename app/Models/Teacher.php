<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacherID',
        'name',
        'email',
        'phoneNumber',
        'address',
        'DOB',
        'teacherid',
    ];

    // Add any additional relationships or methods as needed
}
