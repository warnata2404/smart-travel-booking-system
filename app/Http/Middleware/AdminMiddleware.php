<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): Response $next
     */
    public function handle(
        Request $request,
        Closure $next,
    ): Response {
        $user = $request->user();

        if (
            $user === null ||
            $user->role !== UserRole::ADMIN
        ) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
