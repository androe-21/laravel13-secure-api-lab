<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        // Check if the user is an admin
        if ($user->role !== 'admin') {
            return response()->json([
                'message' => 'Forbidden. Admin access only.',
            ], 403);
        }

        // Allow admin to continue
        return $next($request);
    }
}
