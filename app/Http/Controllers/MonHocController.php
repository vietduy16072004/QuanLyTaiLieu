<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonHoc;
use Illuminate\Support\Facades\Auth;

class MonHocController extends Controller
{
    // Kiểm tra quyền Admin
    private function checkAdmin() {
        if (Auth::user()->vai_tro !== 'quan_tri') {
            abort(403, 'Bạn không có quyền truy cập!');
        }
    }

    // 1. Danh sách
    public function index()
    {
        $this->checkAdmin();
        $dsMonHoc = MonHoc::orderBy('ma_mon', 'asc')->get();
        return view('monhoc.index', compact('dsMonHoc'));
    }

    // 2. Form Thêm
    public function create()
    {
        $this->checkAdmin();
        return view('monhoc.create');
    }

    // 3. Xử lý Lưu
    public function store(Request $request)
    {
        $this->checkAdmin();
        $request->validate([
            'ma_mon' => 'required|unique:mon_hoc,ma_mon|max:10',
            'ten_mon' => 'required|max:100'
        ], [
            'ma_mon.unique' => 'Mã môn này đã tồn tại!',
        ]);

        $mon = new MonHoc();
        $mon->ma_mon = strtoupper($request->ma_mon);
        $mon->ten_mon = $request->ten_mon;
        $mon->save();

        return redirect()->route('monhoc.index')->with('success', 'Thêm môn học thành công!');
    }

    // 4. Form Sửa
    public function edit($id)
    {
        $this->checkAdmin();
        $monHoc = MonHoc::findOrFail($id);
        return view('monhoc.edit', compact('monHoc'));
    }

    // 5. Xử lý Cập nhật
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $mon = MonHoc::findOrFail($id);
        
        $request->validate(['ten_mon' => 'required|max:100']);
        
        $mon->ten_mon = $request->ten_mon;
        $mon->save();

        return redirect()->route('monhoc.index')->with('success', 'Cập nhật thành công!');
    }

    // 6. Xóa
    public function destroy($id)
    {
        $this->checkAdmin();
        $mon = MonHoc::findOrFail($id);
        $mon->delete();
        return redirect()->route('monhoc.index')->with('success', 'Đã xóa môn học!');
    }
}