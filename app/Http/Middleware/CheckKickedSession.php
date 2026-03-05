<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckKickedSession
{
    public function handle(Request $request, Closure $next)
    {
        // Chỉ kiểm tra nếu người dùng đang đăng nhập
        if (Auth::check()) {
            $sessionId = Session::getId();
            
            // Lấy thông tin session hiện tại trong DB
            $sessionRecord = DB::table('sessions')->where('id', $sessionId)->first();

            // Nếu session tồn tại VÀ cột is_kicked = 1
            if ($sessionRecord && $sessionRecord->is_kicked) {
                
                // 1. Xóa session này khỏi DB để dọn rác
                DB::table('sessions')->where('id', $sessionId)->delete();

                // 2. Đăng xuất khỏi hệ thống
                Auth::logout();
                
                // 3. Hủy session hiện tại, tạo lại token để nhận thông báo flash
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 4. Chuyển hướng về Login kèm thông báo
                return redirect()->route('login')->with('error', 'Tài khoản của bạn đã được đăng nhập ở thiết bị khác!');
            }
        }

        return $next($request);
    }
}