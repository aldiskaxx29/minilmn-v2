<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'description',
        'question',
        'answer',
        'status'
    ];
}
