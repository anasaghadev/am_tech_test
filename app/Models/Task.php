<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'tags',
        'due_date',
        'status',
        'user_id'
    ];
}
