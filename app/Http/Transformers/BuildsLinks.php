<?php

namespace App\Http\Transformers;

trait BuildsLinks {

    public function showLink($route, $id)
    {
        return '<a href="' . route($route, ['id' => $id]) . '" class="btn btn-primary btn-sm" role="button" aria-pressed="true" style="margin: 1px;">View</a>';
    }

    public function editLink($route, $id)
    {
        return '<a href="' . route($route, ['id' => $id]) . '" class="btn btn-primary btn-sm" role="button" aria-pressed="true" style="margin: 1px;">Edit</a>';
    }

}
