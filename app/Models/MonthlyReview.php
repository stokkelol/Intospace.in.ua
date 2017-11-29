<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Entity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MonthlyReview
 * @package App\Models
 */
class MonthlyReview extends Entity
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
