<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // DÒNG QUAN TRỌNG: Import Auth

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đăng nhập VÀ có quyền Admin (is_admin = 1)
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang quản trị.');
        }
        return $next($request);
    }
}
