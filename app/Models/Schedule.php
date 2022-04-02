<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'is_public'
    ];

    public function user_in_schedule()
    {
        return $this->hasMany(User_In_Schedule::class);
    }

    public function preference()
    {
        return $this->hasMany(User_In_Schedule::class);
    }

    public function shift_in_schedule()
    {
        return $this->hasMany(Shift_In_Schedule::class);
    }
}
