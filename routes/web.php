<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Models\NguoiDung;
use App\Http\Controllers\TaiLieuController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Đây là nơi khai báo các đường dẫn cho dự án của bạn.
|
*/

// Trang chủ (Ai cũng vào được)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Đăng nhập / Đăng ký
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route xem chi tiết tài liệu (nhận vào mã tài liệu)
Route::get('/chi-tiet-tai-lieu/{ma_tai_lieu}', [HomeController::class, 'show'])->name('tailieu.detail');

// ==========================================
// 2. ROUTE CÔNG KHAI CHO NGƯỜI ĐÃ ĐĂNG NHẬP
// (Sinh viên, Giảng viên, Admin đều vào được)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // Tải tài liệu (Sinh viên cần tải tài liệu nên để ở đây)
    Route::get('/tai-lieu/tai-ve/{id}', [TaiLieuController::class, 'download'])->name('tailieu.download');

    // --- HỒ SƠ CÁ NHÂN ---
    Route::get('/ho-so', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::post('/ho-so/cap-nhat', [App\Http\Controllers\ProfileController::class, 'updateInfo'])->name('profile.updateInfo');
    Route::post('/ho-so/doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.changePassword');
    
    // --- YÊU THÍCH TÀI LIỆU ---
    Route::get('/tai-lieu/yeu-thich/{id}', [TaiLieuController::class, 'toggleFavorite'])->name('tailieu.favorite');
    // Route xem danh sách yêu thích
    Route::get('/tai-lieu/tu-yeu-thich', [TaiLieuController::class, 'danhSachYeuThich'])->name('tailieu.ds_yeuthich');
    // Route quản lý tài liệu của người dùng
    Route::get('/tai-lieu/quan-ly', [TaiLieuController::class, 'quanLyTaiLieu'])->name('tailieu.quanly');
});


// ==========================================
// 3. ROUTE QUẢN LÝ (CÓ BẢO VỆ)
// (Chỉ Giảng viên và Admin mới vào được. Sinh viên vào sẽ bị chặn)
// ==========================================
Route::middleware(['auth', 'quan_ly'])->group(function () {

    // --- Chức năng Thêm mới ---
    // Hiển thị form upload
    Route::get('/tai-lieu/them', [TaiLieuController::class, 'create'])->name('tailieu.create');
    // Xử lý lưu file
    Route::post('/tai-lieu/luu', [TaiLieuController::class, 'store'])->name('tailieu.store');

    // --- Chức năng Sửa ---
    // Hiển thị form Sửa
    Route::get('/tai-lieu/sua/{id}', [TaiLieuController::class, 'edit'])->name('tailieu.edit');
    // Xử lý cập nhật
    Route::post('/tai-lieu/sua/{id}', [TaiLieuController::class, 'update'])->name('tailieu.update');

    // --- Chức năng Xóa ---
    Route::delete('/tai-lieu/xoa/{id}', [TaiLieuController::class, 'destroy'])->name('tailieu.destroy');

    // --- QUẢN LÝ NGƯỜI DÙNG (ADMIN) ---
    Route::get('/nguoi-dung', [App\Http\Controllers\NguoiDungController::class, 'index'])->name('nguoidung.index');
    Route::get('/nguoi-dung/them', [App\Http\Controllers\NguoiDungController::class, 'create'])->name('nguoidung.create');
    Route::post('/nguoi-dung/luu', [App\Http\Controllers\NguoiDungController::class, 'store'])->name('nguoidung.store');
    Route::get('/nguoi-dung/sua/{id}', [App\Http\Controllers\NguoiDungController::class, 'edit'])->name('nguoidung.edit');
    Route::post('/nguoi-dung/cap-nhat/{id}', [App\Http\Controllers\NguoiDungController::class, 'update'])->name('nguoidung.update');
    Route::delete('/nguoi-dung/xoa/{id}', [App\Http\Controllers\NguoiDungController::class, 'destroy'])->name('nguoidung.destroy');

    // --- QUẢN LÝ KHOA (ADMIN) ---
    Route::get('/khoa', [App\Http\Controllers\KhoaController::class, 'index'])->name('khoa.index');
    Route::get('/khoa/them', [App\Http\Controllers\KhoaController::class, 'create'])->name('khoa.create');
    Route::post('/khoa/luu', [App\Http\Controllers\KhoaController::class, 'store'])->name('khoa.store');
    Route::get('/khoa/sua/{id}', [App\Http\Controllers\KhoaController::class, 'edit'])->name('khoa.edit');
    Route::post('/khoa/cap-nhat/{id}', [App\Http\Controllers\KhoaController::class, 'update'])->name('khoa.update');
    Route::post('/khoa/xoa/{id}', [App\Http\Controllers\KhoaController::class, 'destroy'])->name('khoa.destroy');

    // --- QUẢN LÝ LOẠI TÀI LIỆU (ADMIN) ---
    Route::get('/loai-tai-lieu', [App\Http\Controllers\LoaiTaiLieuController::class, 'index'])->name('loaitailieu.index');
    Route::get('/loai-tai-lieu/them', [App\Http\Controllers\LoaiTaiLieuController::class, 'create'])->name('loaitailieu.create');
    Route::post('/loai-tai-lieu/luu', [App\Http\Controllers\LoaiTaiLieuController::class, 'store'])->name('loaitailieu.store');
    Route::get('/loai-tai-lieu/sua/{id}', [App\Http\Controllers\LoaiTaiLieuController::class, 'edit'])->name('loaitailieu.edit');
    Route::post('/loai-tai-lieu/cap-nhat/{id}', [App\Http\Controllers\LoaiTaiLieuController::class, 'update'])->name('loaitailieu.update');
    Route::post('/loai-tai-lieu/xoa/{id}', [App\Http\Controllers\LoaiTaiLieuController::class, 'destroy'])->name('loaitailieu.destroy');

    // --- QUẢN LÝ MÔN HỌC ---
    Route::get('/mon-hoc', [App\Http\Controllers\MonHocController::class, 'index'])->name('monhoc.index');
    Route::get('/mon-hoc/them', [App\Http\Controllers\MonHocController::class, 'create'])->name('monhoc.create');
    Route::post('/mon-hoc/luu', [App\Http\Controllers\MonHocController::class, 'store'])->name('monhoc.store');
    Route::get('/mon-hoc/sua/{id}', [App\Http\Controllers\MonHocController::class, 'edit'])->name('monhoc.edit');
    Route::post('/mon-hoc/cap-nhat/{id}', [App\Http\Controllers\MonHocController::class, 'update'])->name('monhoc.update');
    Route::post('/mon-hoc/xoa/{id}', [App\Http\Controllers\MonHocController::class, 'destroy'])->name('monhoc.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
