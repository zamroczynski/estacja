<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift_In_Schedule extends Model
{
    use HasFactory;


    protected $fillable = [
        'shift_id',
        'schedule_id',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
