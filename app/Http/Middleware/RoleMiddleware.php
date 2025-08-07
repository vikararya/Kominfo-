<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Tambahkan facade Auth

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Gunakan Auth::check() daripada auth()->check()
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        // Gunakan Auth::user() untuk mendapatkan user yang sedang login
        $userRole = Auth::user()->role ?? null; // Pastikan tidak null

        // Jika role yang diberikan berupa array, periksa apakah user termasuk dalamnya
        if (strpos($role, '|') !== false) {
            $allowedRoles = explode('|', $role);
            if (!in_array($userRole, $allowedRoles)) {
                abort(403, 'Unauthorized');
            }
        }
        // Jika hanya satu role
        elseif ($userRole !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
