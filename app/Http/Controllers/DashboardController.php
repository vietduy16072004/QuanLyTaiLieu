<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TaiLieu;
use App\Models\NguoiDung; 
use App\Models\MonHoc;
use App\Models\Khoa;
use App\Models\LoaiTaiLieu;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Thống kê số lượng
        $totalTaiLieu   = TaiLieu::count();
        
        // Đếm từ bảng NguoiDung
        $totalNguoiDung = NguoiDung::count(); 
        
        $totalMonHoc    = MonHoc::count();
        $totalKhoa      = Khoa::count();

        // 2. Lấy 5 tài liệu mới nhất
        $recentDocs = TaiLieu::with(['nguoiDang', 'loaiTaiLieu'])
                             ->orderBy('ngay_tao', 'desc')
                             ->take(5)
                             ->get();

        // 3. Dữ liệu biểu đồ tròn (Theo loại)
        $statsByLoai = TaiLieu::select('ma_loai', DB::raw('count(*) as total'))
                              ->groupBy('ma_loai')
                              ->get();

        $chartLabels = [];
        $chartData   = [];

        foreach ($statsByLoai as $stat) {
            $loai = LoaiTaiLieu::find($stat->ma_loai);
            $chartLabels[] = $loai ? $loai->ten_loai : 'Khác'; 
            $chartData[]   = $stat->total;
        }

        // 4. Dữ liệu biểu đồ cột (Theo tháng trong năm nay)
        $uploadsByMonth = TaiLieu::select(DB::raw('MONTH(ngay_tao) as month'), DB::raw('count(*) as total'))
                                 ->whereYear('ngay_tao', date('Y'))
                                 ->groupBy('month')
                                 ->pluck('total', 'month')
                                 ->toArray();

        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $uploadsByMonth[$i] ?? 0;
        }

        return view('dashboard.index', compact(
            'totalTaiLieu', 
            'totalNguoiDung', 
            'totalMonHoc', 
            'totalKhoa', 
            'recentDocs', 
            'chartLabels', 
            'chartData',
            'monthlyData'
        ));
    }
}