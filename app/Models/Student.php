<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'dateOfBirth',
        'email',
        'address',
        'phoneNumber',
        // 'classID', // Uncomment if you're using this field
    ];
}
