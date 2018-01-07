<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

/**
 * Class VerifyCsrfToken
 *
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'telegram/*'
    ];

    public function handle($request, Closure $next)
    {
        if ('testing' !== app()->environment()) {
            return parent::handle($request, $next);
        }

        return $next($request);
    }
}
