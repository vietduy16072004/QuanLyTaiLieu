<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaiLieu;
use App\Models\Khoa;
use App\Models\MonHoc;
use App\Models\LoaiTaiLieu; // <--- Import thêm Loại
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Lấy danh sách cho bộ lọc
        $dsKhoa = Khoa::all();
        $dsMonHoc = MonHoc::all();
        $dsLoai = LoaiTaiLieu::all(); // <--- Lấy danh sách loại

        // 2. Query Tài liệu
        $query = TaiLieu::with(['nguoiDang', 'loaiTaiLieu', 'khoa', 'monHoc']);

        // --- CÁC BỘ LỌC ---
        if ($request->filled('tu_khoa')) {
            $query->where('tieu_de', 'like', '%' . $request->tu_khoa . '%');
        }
        if ($request->filled('ma_loai')) { // Lọc theo Loại
            $query->where('ma_loai', $request->ma_loai);
        }
        if ($request->filled('ma_khoa')) {
            $query->where('ma_khoa', $request->ma_khoa);
        }
        if ($request->filled('ma_mon')) {
            $query->where('ma_mon', $request->ma_mon);
        }

        $dsTaiLieu = $query->orderBy('ngay_tao', 'desc')->get();

        // 3. Thống kê & Yêu thích
        $thongKe = null;
        $chartLabels = [];
        $chartValues = [];
        $daThich = [];

        if (Auth::check()) {
            $daThich = Auth::user()->taiLieuYeuThich->pluck('ma_tai_lieu')->toArray();

            if (Auth::user()->vai_tro !== 'sinh_vien') {
                $thongKe = [
                    'tong_tai_lieu' => TaiLieu::count(),
                    'tong_nguoi_dung' => \App\Models\NguoiDung::count(),
                    'tong_khoa' => Khoa::count(),
                ];

                $chartData = DB::table('tai_lieu')
                    ->join('khoa', 'tai_lieu.ma_khoa', '=', 'khoa.ma_khoa')
                    ->select('khoa.ten_khoa', DB::raw('count(*) as total'))
                    ->groupBy('khoa.ten_khoa')
                    ->get();

                $chartLabels = $chartData->pluck('ten_khoa');
                $chartValues = $chartData->pluck('total');
            }
        }

        // Truyền thêm $dsLoai sang View
        return view('home', compact('dsTaiLieu', 'dsKhoa', 'dsMonHoc', 'dsLoai', 'daThich', 'thongKe', 'chartLabels', 'chartValues'));
    }

    public function show($id)
    {
        // Tìm tài liệu theo mã, nếu không thấy sẽ báo lỗi 404
        $taiLieu = TaiLieu::with(['nguoiDang', 'loaiTaiLieu', 'khoa', 'monHoc'])
                    ->where('ma_tai_lieu', $id)
                    ->firstOrFail();

        // Kiểm tra đã thích hay chưa (nếu đã đăng nhập)
        $daThich = false;
        if (Auth::check()) {
            $daThich = Auth::user()->taiLieuYeuThich->contains('ma_tai_lieu', $id);
        }

        // Trả về view chi tiết
        return view('tailieu.detail', compact('taiLieu', 'daThich'));
    }
}