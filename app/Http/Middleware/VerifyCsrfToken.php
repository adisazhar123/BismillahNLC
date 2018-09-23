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
        '/peserta/finish-exam', '/peserta/reset-answer', '/peserta/submit-answer-status', '/peserta/submit-answer'
    ];
}
