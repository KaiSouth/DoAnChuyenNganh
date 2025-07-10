<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class QuanLyAuthCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|array  $roles  Role or roles to check
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!session()->has('manage_id')) {
            return redirect()->route('authCustom.login.form')
                ->with('error', 'Bạn cần đăng nhập để tiếp tục.');
        }

        if (empty($roles)) {
            return $next($request);
        }

        if (!$this->checkUserRoles($request, $roles)) {
            return redirect()->route('authCustom.login.form')
                ->with('error', 'Không có quyền thực hiện chức năng này');
        }

        return $next($request);
    }

    /**
     * Check if the user has any of the required roles
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $roles
     * @return bool
     */
    protected function checkUserRoles(Request $request, array $roles): bool
    {
        $userRole = session()->get('role');

        // If user has no role, deny access
        if (!$userRole) {
            return false;
        }

        // Convert roles to array if string
        $requiredRoles = array_map('strtolower', $roles);
        $userRole = strtolower($userRole);

        // Check if user's role matches any of the required roles
        foreach ($requiredRoles as $role) {
            // Handle special case for multiple roles with pipe operator
            if (str_contains($role, '|')) {
                $orRoles = array_map('trim', explode('|', $role));
                if (in_array($userRole, $orRoles)) {
                    return true;
                }
                continue;
            }

            // Handle special case for wildcard
            if ($role === '*') {
                return true;
            }

            // Direct role match
            if ($userRole === $role) {
                return true;
            }
        }

        return false;
    }
}
