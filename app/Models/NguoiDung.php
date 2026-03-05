<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Kế thừa từ class xác thực
use Illuminate\Notifications\Notifiable;

class NguoiDung extends Authenticatable
{
    use Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'ma_nguoi_dung';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'ma_nguoi_dung', 'ho_ten', 'email', 'mat_khau', 'vai_tro', 'ma_khoa'
    ];

    protected $hidden = [
        'mat_khau', // Ẩn mật khẩu khi query
    ];

    // Chỉ định tên cột password là 'mat_khau' để Laravel hiểu
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function getAuthPasswordName()
    {
        return 'mat_khau';
    }

    // Quan hệ với Khoa
    public function khoa() {
        return $this->belongsTo(Khoa::class, 'ma_khoa', 'ma_khoa');
    }

    // Quan hệ nhiều-nhiều: Người dùng yêu thích nhiều tài liệu
    public function taiLieuYeuThich() {
        // tham số: Model đích, tên bảng trung gian, khóa ngoại 1, khóa ngoại 2
        return $this->belongsToMany(TaiLieu::class, 'yeu_thich', 'ma_nguoi_dung', 'ma_tai_lieu');
    }
}