<?php
declare(strict_types=1);

namespace App\Support\Statuses;

/**
 * Class StatusChanger
 *
 * @package App\Support\Statuses
 */
class StatusChanger
{
    /**
     * @var
     */
    protected $model;

    /**
     * StatusChanger constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     */
    public function setStatus($id, $status)
    {
        $model = $this->model->find($id);
        $model->status = $status;
        $model->save();
        flash()->message("{$model->title} sent to $status!");

        return $model;
    }
}
