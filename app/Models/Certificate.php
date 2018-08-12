<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Instructor;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];

    protected $dates = ['expiry_date'];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function getDownloadFileNameAttribute()
    {
        $filename = "{$this->name}." . File::extension($this->file);

        return preg_replace('/[^a-z0-9\.]/', '', strtolower($filename));
    }

    public function getHasExpiredAttribute()
    {
        if (is_null($this->expiry_date)) {
            return false;
        }

        if (Carbon::now() > $this->expiry_date) {
            return true;
        }

        return false;
    }
}
