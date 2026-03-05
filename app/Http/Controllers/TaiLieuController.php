<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\TaiLieu;
use App\Models\LoaiTaiLieu;
use App\Models\Khoa;
use App\Models\MonHoc; // <--- QUAN TRỌNG: Phải có dòng này mới dùng được Môn học

class TaiLieuController extends Controller
{
    // 1. Hiển thị form Thêm mới
    public function create()
    {
        $dsLoai = LoaiTaiLieu::all();
        $dsKhoa = Khoa::all(); 
        $dsMonHoc = MonHoc::all(); // Lấy danh sách môn học
        return view('upload', compact('dsLoai', 'dsKhoa', 'dsMonHoc'));
    }

    // 2. Xử lý Lưu tài liệu mới
    public function store(Request $request)
    {
        $rules = [
            'ma_tai_lieu' => 'required|unique:tai_lieu,ma_tai_lieu',
            'tieu_de' => 'required',
            'file_upload' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240',
        ];

        if (Auth::user()->vai_tro == 'quan_tri') {
            $rules['ma_khoa'] = 'required';
        }

        $request->validate($rules);

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $filePath = '/uploads/' . $fileName;
        }

        $taiLieu = new TaiLieu();
        $taiLieu->ma_tai_lieu = $request->ma_tai_lieu;
        $taiLieu->tieu_de = $request->tieu_de;
        $taiLieu->mo_ta = $request->mo_ta;
        $taiLieu->duong_dan_file = $filePath;
        $taiLieu->ma_loai = $request->ma_loai;
        $taiLieu->ma_mon = $request->ma_mon; // Lưu môn học
        $taiLieu->ma_nguoi_dang = Auth::user()->ma_nguoi_dung;

        if (Auth::user()->vai_tro == 'quan_tri') {
            $taiLieu->ma_khoa = $request->ma_khoa;
        } else {
            $taiLieu->ma_khoa = Auth::user()->ma_khoa;
        }

        $taiLieu->save();

        return redirect()->route('tailieu.quanly')->with('success', 'Đã thêm tài liệu thành công!');
    }

    // 3. Hiển thị form Sửa tài liệu
    public function edit($id)
    {
        $taiLieu = TaiLieu::findOrFail($id);
        $dsLoai = LoaiTaiLieu::all();
        $dsKhoa = Khoa::all();
        $dsMonHoc = MonHoc::all(); // <--- Dòng này cần import model MonHoc ở trên
        return view('edit', compact('taiLieu', 'dsLoai', 'dsKhoa', 'dsMonHoc'));
    }

    // 4. Xử lý Cập nhật tài liệu
    public function update(Request $request, $id)
    {
        $taiLieu = TaiLieu::findOrFail($id);

        $request->validate([
            'tieu_de' => 'required',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar,jpg,jpeg,png|max:10240',
        ]);

        $taiLieu->tieu_de = $request->tieu_de;
        $taiLieu->mo_ta = $request->mo_ta;
        $taiLieu->ma_loai = $request->ma_loai;
        $taiLieu->ma_mon = $request->ma_mon; // Cập nhật môn học

        if (Auth::user()->vai_tro == 'quan_tri') {
            $taiLieu->ma_khoa = $request->ma_khoa;
        }

        if ($request->hasFile('file_upload')) {
            $oldPath = public_path(ltrim($taiLieu->duong_dan_file, '/'));
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $taiLieu->duong_dan_file = '/uploads/' . $fileName;
        }

        $taiLieu->save();

        return redirect()->route('tailieu.quanly')->with('success', 'Cập nhật tài liệu thành công!');
    }

    // 5. Xử lý Tải file
    public function download($ma_tai_lieu)
    {
        $taiLieu = TaiLieu::findOrFail($ma_tai_lieu);
        $path = ltrim($taiLieu->duong_dan_file, '/');
        $filePath = public_path($path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $taiLieu->tieu_de . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
        } else {
            return back()->with('error', 'File không tồn tại trên hệ thống!');
        }
    }

    // 6. Xử lý Xóa
    public function destroy($id)
    {
        $taiLieu = TaiLieu::findOrFail($id);
        $filePath = public_path(ltrim($taiLieu->duong_dan_file, '/'));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $taiLieu->delete();
        return redirect()->route('tailieu.quanly')->with('success', 'Đã xóa tài liệu!');
    }

    // 7. Xử lý Yêu thích
    public function toggleFavorite($id)
    {
        Auth::user()->taiLieuYeuThich()->toggle($id);
        return redirect()->back()->with('success', 'Đã cập nhật danh sách yêu thích!');
    }

    // 8. Danh sách yêu thích
    public function danhSachYeuThich()
    {
        $dsTaiLieu = Auth::user()->taiLieuYeuThich()
                                 ->with(['nguoiDang', 'loaiTaiLieu', 'khoa', 'monHoc'])
                                 ->orderBy('yeu_thich.ngay_them', 'desc')
                                 ->get();

        $daThich = $dsTaiLieu->pluck('ma_tai_lieu')->toArray();

        return view('yeuthich', compact('dsTaiLieu', 'daThich'));
    }

    // 9. Quản lý tài liệu cá nhân
    public function quanLyTaiLieu()
    {
        $user = Auth::user();
        $dsTaiLieu = TaiLieu::where('ma_nguoi_dang', $user->ma_nguoi_dung)
                            ->with(['loaiTaiLieu', 'khoa', 'monHoc'])
                            ->orderBy('ngay_tao', 'desc')
                            ->get();

        return view('tailieu.quanly', compact('dsTaiLieu'));
    }
}