<?php

namespace App\Support\CustomCollections;

use Illuminate\Support\Collection;

class CollectionByIds
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function find($idsColl)
    {
        $models = new Collection;
        $ids = explode(',', $idsColl);
        foreach($ids as $id)
        {
            $models->push($this->model->find($id));
        }
        return $models;
    }
}
