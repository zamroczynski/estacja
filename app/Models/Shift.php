<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'stop',
        'duration',
        'number_of_employees'
    ];

    public function preference()
    {
        return $this->hasMany(Preference::class);
    }

    public function shift_in_schedule()
    {
        return $this->hasMany(Shift_In_Schedule::class);
    }

    public function user_in_schedule()
    {
        return $this->hasMany(User_In_Schedule::class);
    }
}
