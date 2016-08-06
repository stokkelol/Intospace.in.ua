<?php

namespace App\Support\Statuses;

class StatusChanger
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function setStatus($id, $status)
    {
        $model = $this->model->find($id);
        $model->status = $status;
        $model->save();
        flash()->message("{$model->title} sent to $status!");

        return $model;
    }
}
