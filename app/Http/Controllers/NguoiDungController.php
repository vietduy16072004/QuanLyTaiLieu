<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Models\Khoa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class NguoiDungController extends Controller
{
    // Hàm kiểm tra quyền Admin (Private)
    private function checkAdmin() {
        if (Auth::user()->vai_tro !== 'quan_tri') {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }
    }

    // 1. Danh sách người dùng
    public function index()
    {
        $this->checkAdmin();
        // Lấy danh sách, trừ tài khoản admin đang đăng nhập
        $dsNguoiDung = NguoiDung::with('khoa')
                        ->where('ma_nguoi_dung', '!=', Auth::user()->ma_nguoi_dung)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        return view('nguoidung.index', compact('dsNguoiDung'));
    }

    // 2. Form thêm mới
    public function create()
    {
        $this->checkAdmin();
        $dsKhoa = Khoa::all();
        return view('nguoidung.create', compact('dsKhoa'));
    }

    // 3. Xử lý lưu người dùng mới
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'ma_nguoi_dung' => 'required|unique:nguoi_dung,ma_nguoi_dung',
            'ho_ten' => 'required',
            'email' => 'required|email|unique:nguoi_dung,email',
            'password' => 'required|min:6',
            'vai_tro' => 'required', // Bắt buộc chọn vai trò
            'ma_khoa' => 'required'
        ]);

        $user = new NguoiDung();
        $user->ma_nguoi_dung = $request->ma_nguoi_dung;
        $user->ho_ten = $request->ho_ten;
        $user->email = $request->email;
        $user->mat_khau = Hash::make($request->password);
        $user->vai_tro = $request->vai_tro; // Lưu vai trò từ Combobox (sinh_vien/giang_vien)
        $user->ma_khoa = $request->ma_khoa;
        $user->save();

        return redirect()->route('nguoidung.index')->with('success', 'Thêm người dùng thành công!');
    }

    // 4. Form sửa
    public function edit($id)
    {
        $this->checkAdmin();
        $user = NguoiDung::findOrFail($id);
        $dsKhoa = Khoa::all();
        return view('nguoidung.edit', compact('user', 'dsKhoa'));
    }

    // 5. Xử lý cập nhật
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $user = NguoiDung::findOrFail($id);

        $request->validate([
            'ho_ten' => 'required',
            // Email phải là duy nhất nhưng trừ chính user này ra
            'email' => 'required|email|unique:nguoi_dung,email,'.$id.',ma_nguoi_dung',
            'vai_tro' => 'required',
            'ma_khoa' => 'required'
        ]);

        $user->ho_ten = $request->ho_ten;
        $user->email = $request->email;
        $user->vai_tro = $request->vai_tro;
        $user->ma_khoa = $request->ma_khoa;

        // Nếu có nhập mật khẩu mới thì mới đổi, không thì giữ nguyên
        if ($request->filled('password')) {
            $user->mat_khau = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('nguoidung.index')->with('success', 'Cập nhật thông tin thành công!');
    }

    // 6. Xóa người dùng
    public function destroy($id)
    {
        $this->checkAdmin();
        $user = NguoiDung::findOrFail($id);
        $user->delete();
        return redirect()->route('nguoidung.index')->with('success', 'Đã xóa người dùng!');
    }
}