<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'courseName',
        'maxPoints',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically generate a unique courseID when creating a new course
        static::creating(function ($course) {
            $course->courseID = strtoupper(Str::random(8));  // Example: C2K9TQ8P
        });
    }
}
