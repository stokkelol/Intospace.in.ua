<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class Search
{
    public function searchByQueryWithPublishedAt($table, $query)
    {
        return DB::table($table)->where('title', 'like', '%'.$query.'%')->groupBy('published_at')->orderBy('published_at', 'desc')->get();
    }

    public function searchByQuery($table, $query)
    {
        return DB::table($table)->with('posts', 'user')->where('title', 'like', '%'.$query.'%')->groupBy('title')->orderBy('title', 'desc')->get();
    }
}
