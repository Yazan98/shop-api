<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'api/v1/users',
        'api/v1/categories',
        'api/v1/shops/*',
        'api/v1/shops',
        'api/v1/items/*',
        'api/v1/items',
        'api/v1/users/otp/refresh',
        'api/v1/users/otp/verify',
        'api/v1/users/login',
        'api/v1/users/reset/answer',
    ];
}
