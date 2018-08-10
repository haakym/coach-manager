<?php

namespace App\Models;

use App\Models\Certificate;
use App\Models\CourseInstructor;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = [];

    protected $appends = ['hourly_rate_in_pounds'];

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
            ->using(CourseInstructor::class)
            ->withPivot('date_from', 'date_to')
            ->withTimestamps();
            // ->as('bettername')
    }

    public function scopeCoaches($query)
    {
        return $query->where('type', 'coach');
    }

    public function scopeVolunteers($query)
    {
        return $query->where('type', 'volunteer');
    }
}
