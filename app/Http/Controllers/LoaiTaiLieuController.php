<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoaiTaiLieu;
use Illuminate\Support\Facades\Auth;

class LoaiTaiLieuController extends Controller
{
    // Hàm kiểm tra quyền Admin
    private function checkAdmin() {
        if (Auth::user()->vai_tro !== 'quan_tri') {
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }
    }

    // 1. Danh sách Loại
    public function index()
    {
        $this->checkAdmin();
        // Lấy danh sách và đếm số lượng tài liệu thuộc loại đó
        $dsLoai = LoaiTaiLieu::withCount('taiLieu')->orderBy('ma_loai', 'asc')->get();
        return view('loaitailieu.index', compact('dsLoai'));
    }

    // 2. Form Thêm mới
    public function create()
    {
        $this->checkAdmin();
        return view('loaitailieu.create');
    }

    // 3. Xử lý Lưu
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'ma_loai' => 'required|unique:loai_tai_lieu,ma_loai|max:10', 
            'ten_loai' => 'required|max:100'
        ], [
            'ma_loai.unique' => 'Mã loại này đã tồn tại!',
            'ma_loai.required' => 'Vui lòng nhập mã loại.',
            'ten_loai.required' => 'Vui lòng nhập tên loại.'
        ]);

        $loai = new LoaiTaiLieu();
        $loai->ma_loai = strtoupper($request->ma_loai); // Tự động viết hoa
        $loai->ten_loai = $request->ten_loai;
        $loai->save();

        return redirect()->route('loaitailieu.index')->with('success', 'Thêm loại tài liệu thành công!');
    }

    // 4. Form Sửa
    public function edit($id)
    {
        $this->checkAdmin();
        $loai = LoaiTaiLieu::findOrFail($id);
        return view('loaitailieu.edit', compact('loai'));
    }

    // 5. Xử lý Cập nhật
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $loai = LoaiTaiLieu::findOrFail($id);

        $request->validate([
            'ten_loai' => 'required|max:100'
        ]);

        $loai->ten_loai = $request->ten_loai;
        $loai->save();

        return redirect()->route('loaitailieu.index')->with('success', 'Cập nhật thành công!');
    }

    // 6. Xóa
    public function destroy($id)
    {
        $this->checkAdmin();
        $loai = LoaiTaiLieu::findOrFail($id);

        if($loai->tai_lieu_count > 0) { // Biến này có được nhờ withCount ở hàm index
             return redirect()->route('loaitailieu.index')->with('error', 'Không thể xóa! Có tài liệu đang thuộc loại này.');
        }

        $loai->delete();
        return redirect()->route('loaitailieu.index')->with('success', 'Đã xóa loại tài liệu!');
    }
}