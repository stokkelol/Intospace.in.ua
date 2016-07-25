<?php

namespace App\Traits;

trait ScopesTrait
{
    public function scopeByStatus($query, $statuses)
    {
        return $query->with('category', 'tags', 'user', 'band')->where('status', $statuses);
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

    public function scopeGetMonthlyItems($query)
    {
        $startDate = date('Y-m-1');
        $endDate = date('Y-m-t');

        return $query->where('published_at', '>=', $startDate)
                    ->where('published_at', '<=', $endDate);
    }
}
