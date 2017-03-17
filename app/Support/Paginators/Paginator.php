<?php

namespace App\Support\Paginators;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class Paginator
{
    protected $request;
    protected $perPage;
    protected $items;

    public function __construct(Request $request, $perPage, $items)
    {
        $this->request = $request;
        $this->perPage = $perPage;
        $this->items = $items;
    }

    public function makePaginator()
    {
        $page = $this->request->get('page', LengthAwarePaginator::resolveCurrentPage());
        $perPage = 4;
        $offSet = ($page * $perPage) - $perPage;
        $items = $this->items->slice($offSet, $perPage)->all();

        $links = new LengthAwarePaginator($this->items, count($this->items), $perPage);

        return $links;
    }
}
