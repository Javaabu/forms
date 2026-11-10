<?php

namespace Javaabu\Forms\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OverrideFormsDefaults
{
    /**
     * Handle the incoming request.
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $framework)
    {
        config([
            'forms.framework' => $framework,
        ]);

        return $next($request);
    }
}
