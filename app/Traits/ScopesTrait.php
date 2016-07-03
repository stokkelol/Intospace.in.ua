<?php

namespace App\Traits;

trait ScopesTrait
{
    public function scopeByStatus($query, $statuses)
    {
        return $query->with('category', 'user')->where('status', $statuses);
    }

    public function scopeBySearchQuery($query, $search)
    {
        return $query->with('category', 'user')
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('excerpt', 'like', '%'.$search.'%')
                    ->orderBy('id', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->with('category', 'user')
            ->whereIn('status', ['active', 'draft'])
            ->groupBy('id')
            ->orderBy('id', 'desc');
    }
}
