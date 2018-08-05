<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = [];

    public function getHourlyRateInPoundsAttribute()
    {
        return number_format($this->hourly_rate / 100, 2);
    }
}
