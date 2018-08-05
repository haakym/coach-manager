<?php

namespace App\Models;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = [];

    public function getHourlyRateInPoundsAttribute()
    {
        return number_format($this->hourly_rate / 100, 2);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
