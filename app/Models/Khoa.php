<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Khoa extends Model
{
    protected $table = 'khoa'; // Tên bảng trong DB
    protected $primaryKey = 'ma_khoa'; // Khóa chính là ma_khoa
    public $incrementing = false; // Khóa chính KHÔNG tự tăng
    protected $keyType = 'string'; // Khóa chính là chuỗi
    protected $fillable = ['ma_khoa', 'ten_khoa'];

    // Quan hệ: Một Khoa có nhiều Sinh viên/Giảng viên
    public function nguoiDung() {
        return $this->hasMany(NguoiDung::class, 'ma_khoa', 'ma_khoa');
    }
}