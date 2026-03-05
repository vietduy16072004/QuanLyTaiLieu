<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;

class ProfileController extends Controller
{
    // 1. Hiển thị trang hồ sơ
    public function index()
    {
        $user = Auth::user(); // Lấy thông tin người đang đăng nhập
        return view('profile', compact('user'));
    }

    // 2. Cập nhật thông tin cơ bản (Trừ ID, Khoa, Vai trò)
    public function updateInfo(Request $request)
    {
        $user = NguoiDung::find(Auth::id());

        $request->validate([
            'ho_ten' => 'required|string|max:255',
            // Email phải unique nhưng trừ chính user này ra
            'email' => 'required|email|unique:nguoi_dung,email,'.$user->ma_nguoi_dung.',ma_nguoi_dung',
        ]);

        $user->ho_ten = $request->ho_ten;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }

    // 3. Đổi mật khẩu
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // confirmed: yêu cầu nhập lại khớp nhau
        ], [
            'new_password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.'
        ]);

        // Kiểm tra mật khẩu cũ có đúng không
        if (!Hash::check($request->current_password, Auth::user()->mat_khau)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng!']);
        }

        // Cập nhật mật khẩu mới
        $user = NguoiDung::find(Auth::id());
        $user->mat_khau = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công!');
    }
}