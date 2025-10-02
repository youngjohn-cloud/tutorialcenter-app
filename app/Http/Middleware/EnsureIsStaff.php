<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsStaff
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        // Check if authenticated user is a staff
        if (!$user || !($user instanceof \App\Models\Staff)) {
            return response()->json([
                'message' => 'Unauthorized. Staff access only.'
            ], 403);
        }

        return $next($request); // ✅ Pass request to controller
    }
}
