<?php
declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait ScopesTrait
 *
 * @package App\Traits
 */
trait ScopesTrait
{
    /**
     * @param $query
     * @param $statuses
     * @return mixed
     */
    public function scopeByStatus(Builder $query, $statuses): Builder
    {
        return $query->with('category', 'tags', 'user', 'band')->where('status', $statuses);
    }

    /**
     * @param Builder $query
     * @param string $search
     * @return Builder
     */
    public function scopeBySearchQuery(Builder $query, string $search): Builder
    {
        return $query->with('category', 'user')
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orderBy('id', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->with('category', 'user')
            ->whereIn('status', ['active', 'draft'])
            ->groupBy('id')
            ->orderBy('id', 'desc');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeGetMonthlyItems(Builder $query): Builder
    {
        $startDate = date('Y-m-1');
        $endDate = date('Y-m-t');

        return $query->where('published_at', '>=', $startDate)
                     ->where('published_at', '<=', $endDate);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeByBandSlug(Builder $query, string $slug): Builder
    {
        return $query->whereHas('band', function ($query) use ($slug) {
            $query->where('slug', '=', $slug);
        });
    }
}
