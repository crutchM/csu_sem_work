<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',
        'author_id',
        'illustrator_id',
        'redactor_id'
    ];
}
