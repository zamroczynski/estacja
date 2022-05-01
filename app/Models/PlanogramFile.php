<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanogramFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'planogram_id',
    ];

    public function planogram()
    {
        return $this->belongsTo(Planogram::class);
    }
}
