<?php
declare(strict_types=1);

namespace App\Support\CustomCollections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class CollectionByIds
 *
 * @package App\Support\CustomCollections
 */
class CollectionByIds
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CollectionByIds constructor.
     * @param $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $idsColl
     * @return Collection
     */
    public function find($idsColl): Collection
    {
        $models = new Collection;

        foreach (explode(',', $idsColl) as $id) {
            $models->push($this->model->find($id));
        }

        return $models;
    }
}
