<?php

namespace App\Http\Transformers;

trait BuildsLinks {

    public function showLink($route, $id)
    {
        return '<a href="' . route($route, ['id' => $id]) . '" class="btn btn-primary btn-sm">View</a>';
    }

}