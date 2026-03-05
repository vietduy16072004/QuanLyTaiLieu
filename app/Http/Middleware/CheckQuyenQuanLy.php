<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- QUAN TRỌNG: Phải có dòng này mới dùng được Auth

class CheckQuyenQuanLy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Nếu chưa đăng nhập -> Đẩy về trang login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Nếu là Sinh viên -> Chặn lại, đẩy về trang chủ kèm thông báo lỗi
        if (Auth::user()->vai_tro == 'sinh_vien') {
            return redirect()->route('home')->with('error', 'Bạn không có quyền thực hiện chức năng quản lý!');
        }

        // 3. Nếu là Giảng viên hoặc Admin -> Cho phép đi tiếp
        return $next($request);
    }
}