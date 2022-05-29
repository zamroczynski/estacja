<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'start',
        'end',
        'public',
        'priority',
        'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

}
