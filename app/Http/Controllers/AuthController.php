<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NguoiDung;
use App\Models\Khoa; 

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin() {
        return view('login');
    }

    
    // Xử lý đăng nhập
    public function login(Request $request) {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Lấy thông tin user vừa đăng nhập
            $user = Auth::user(); 

            // --- ĐOẠN CODE QUAN TRỌNG NHẤT ---
            // Tìm trong bảng 'sessions', xóa tất cả dòng nào là của user này
            // NHƯNG CHỪA LẠI dòng session hiện tại (vừa tạo xong)
            DB::table('sessions')
                ->where('user_id', $user->ma_nguoi_dung) // Cột user_id trong bảng sessions
                ->where('id', '!=', Session::getId())    // Khác ID phiên hiện tại
                ->update(['is_kicked' => 1]);
            // ---------------------------------

            return redirect()->intended('/'); 
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    // Đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home'); 
    }

    // 1. Hiển thị form Đăng ký
    public function showRegister() {
        // Lấy danh sách khoa để sinh viên chọn
        $dsKhoa = Khoa::all();
        return view('register', compact('dsKhoa'));
    }

    // 2. Xử lý Đăng ký thành viên mới
    public function register(Request $request) {
        // Validate dữ liệu đầu vào
        $request->validate([
            'ma_nguoi_dung' => 'required|unique:nguoi_dung,ma_nguoi_dung', // Mã SV không được trùng
            'ho_ten'        => 'required',
            'email'         => 'required|email|unique:nguoi_dung,email', // Email không được trùng
            'password'      => 'required|min:6|confirmed', // confirmed: bắt buộc phải có trường password_confirmation khớp nhau
            'ma_khoa'       => 'required'
        ], [
            'ma_nguoi_dung.unique' => 'Mã sinh viên này đã tồn tại!',
            'email.unique'         => 'Email này đã được đăng ký!',
            'password.confirmed'   => 'Mật khẩu nhập lại không khớp!',
        ]);

        // Tạo người dùng mới
        $user = new NguoiDung();
        $user->ma_nguoi_dung = $request->ma_nguoi_dung; // Dùng Mã SV làm ID
        $user->ho_ten        = $request->ho_ten;
        $user->email         = $request->email;
        $user->mat_khau      = Hash::make($request->password); // Mã hóa mật khẩu
        $user->ma_khoa       = $request->ma_khoa;

        // --- Mặc định là SINH VIÊN ---
        $user->vai_tro       = 'sinh_vien'; 

        $user->save();

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }
}