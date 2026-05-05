<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string ...$roles  Allowed roles, e.g. admin,guru,siswa
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $currentRole = session('admin_role');

        if (empty($currentRole)) {
            return redirect()->route('login');
        }

        // When roles passed like 'guru,siswa', Laravel will pass as single string if not variadic.
        // Using variadic captures role list whether provided as multiple or comma-separated.
        $allowed = [];
        foreach ($roles as $r) {
            foreach (explode(',', $r) as $piece) {
                $piece = trim($piece);
                if ($piece !== '') {
                    $allowed[] = $piece;
                }
            }
        }

        if (!in_array($currentRole, $allowed, true)) {
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}

