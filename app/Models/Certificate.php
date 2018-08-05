<?php

namespace App\Models;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

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
}
