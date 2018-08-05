<?php

namespace App\Models;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];

    protected $dates = ['expiry_date'];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
