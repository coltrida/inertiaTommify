<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function list()
    {
        return Tag::orderBy('name')->get();
    }

    public function insert($request)
    {
        Tag::create($request->all());
    }

    public function delete($idTag)
    {
        Tag::find($idTag)->delete();
    }
}
