<?php

namespace App\Models;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = [];

    public function getHourlyRateInPoundsAttribute()
    {
        return number_format($this->hourly_rate / 100, 2, '.', '');
    }

    public function setHourlyRateAttribute($value)
    {
        if (is_int($value)) {
            $this->attributes['hourly_rate'] = $value;
        } else if (is_double($value)) {
            $this->attributes['hourly_rate'] = $this->floatCurrencyToInt($value);
        } else if (is_string($value)) {
            $this->attributes['hourly_rate'] = $this->stringCurrencyToInt($value);
        } else {
            $this->attributes['hourly_rate'] = 0;
        }
    }

    private function stringCurrencyToInt($value)
    {
        if (ctype_digit($value)) {
            return (int) $value * 100;
        }

        return (int) (((float) $value) * 100);
    }
    
    private function floatCurrencyToInt($value)
    {
        return (int) (round($value, 2) * 100);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('date_from', 'date_to')
            ->withTimestamps();
            // ->as('bettername')
    }
}
