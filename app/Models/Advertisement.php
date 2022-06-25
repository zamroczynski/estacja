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

    public static function getUserAd()
    {
        return Advertisement::where("public", "=", TRUE)
        ->orderBy('priority', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public static function getAdminAd()
    {
        return Advertisement::orderBy('created_at', 'desc')->paginate(15);
    }
}
