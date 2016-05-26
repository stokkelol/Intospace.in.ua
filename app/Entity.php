<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public function scopeByStatus($query, $statuses)
    {
        return $query->where('status', $statuses);
    }
}
