<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_In_Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'shift_id',
        'date',
        'position_in_shift',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
