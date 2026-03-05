<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Khoa;
use Illuminate\Support\Facades\Auth;

class KhoaController extends Controller
{
    // Hàm kiểm tra quyền Admin
    private function checkAdmin() {
        if (Auth::user()->vai_tro !== 'quan_tri') {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }
    }

    // 1. Danh sách Khoa
    public function index()
    {
        $this->checkAdmin();
        $dsKhoa = Khoa::orderBy('ma_khoa', 'asc')->get();
        return view('khoa.index', compact('dsKhoa'));
    }

    // 2. Form Thêm mới
    public function create()
    {
        $this->checkAdmin();
        return view('khoa.create');
    }

    // 3. Xử lý Lưu
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'ma_khoa' => 'required|unique:khoa,ma_khoa|max:10', // Mã khoa là khóa chính, không trùng
            'ten_khoa' => 'required|max:100'
        ], [
            'ma_khoa.unique' => 'Mã khoa này đã tồn tại!',
            'ma_khoa.required' => 'Vui lòng nhập mã khoa.',
            'ten_khoa.required' => 'Vui lòng nhập tên khoa.'
        ]);

        $khoa = new Khoa();
        $khoa->ma_khoa = strtoupper($request->ma_khoa); // Tự động viết hoa mã
        $khoa->ten_khoa = $request->ten_khoa;
        $khoa->save();

        return redirect()->route('khoa.index')->with('success', 'Thêm khoa mới thành công!');
    }

    // 4. Form Sửa
    public function edit($id)
    {
        $this->checkAdmin();
        $khoa = Khoa::findOrFail($id);
        return view('khoa.edit', compact('khoa'));
    }

    // 5. Xử lý Cập nhật
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $khoa = Khoa::findOrFail($id);

        $request->validate([
            'ten_khoa' => 'required|max:100'
        ]);

        // Không cho sửa mã khoa (vì là khóa chính và liên kết nhiều bảng)
        $khoa->ten_khoa = $request->ten_khoa;
        $khoa->save();

        return redirect()->route('khoa.index')->with('success', 'Cập nhật tên khoa thành công!');
    }

    // 6. Xóa Khoa
    public function destroy($id)
    {
        $this->checkAdmin();
        $khoa = Khoa::findOrFail($id);

        if($khoa->nguoiDung()->count() > 0) {
             return redirect()->route('khoa.index')->with('error', 'Không thể xóa! Có người dùng thuộc khoa này.');
        }

        $khoa->delete();
        return redirect()->route('khoa.index')->with('success', 'Đã xóa khoa!');
    }
}