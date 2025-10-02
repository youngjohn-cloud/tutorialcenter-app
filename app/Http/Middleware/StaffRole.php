<?php 
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user || !($user instanceof \App\Models\Staff)) {
            return response()->json([
                'message' => 'Unauthorized. Staff access only.'
            ], 403);
        }

        // Check if staff has one of the required roles
        if (!in_array($user->staff_role, $roles)) {
            return response()->json([
                'message' => 'Forbidden. This action requires role(s): ' . implode(', ', $roles)
            ], 403);
        }

        return $next($request);
    }
}
