<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planogram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'current',
        'date_start',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planogram_file()
    {
        return $this->hasMany(PlanogramFile::class);
    }
}
