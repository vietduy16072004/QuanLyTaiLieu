<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaiLieu extends Model
{
    protected $table = 'tai_lieu';
    protected $primaryKey = 'ma_tai_lieu';
    public $incrementing = false;
    protected $keyType = 'string';

    // --- THÊM 2 DÒNG NÀY ĐỂ KHỚP VỚI DATABASE CỦA BẠN ---
    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';
    // ----------------------------------------------------

    protected $fillable = [
        'ma_tai_lieu', 'tieu_de', 'mo_ta', 'duong_dan_file', 
        'ma_nguoi_dang', 'ma_khoa', 'ma_loai', 'ma_mon'
    ];

    // Quan hệ: Tài liệu thuộc về 1 Người đăng
    public function nguoiDang() {
        return $this->belongsTo(NguoiDung::class, 'ma_nguoi_dang', 'ma_nguoi_dung');
    }

    // Quan hệ: Tài liệu thuộc về 1 Loại
    public function loaiTaiLieu() {
        return $this->belongsTo(LoaiTaiLieu::class, 'ma_loai', 'ma_loai');
    }

    // --- THÊM ĐOẠN NÀY VÀO ---
    // Quan hệ: Tài liệu thuộc về 1 Khoa
    public function khoa() {
        return $this->belongsTo(Khoa::class, 'ma_khoa', 'ma_khoa');
    }

    // Quan hệ: Tài liệu thuộc về Môn học
    public function monHoc() {
        return $this->belongsTo(MonHoc::class, 'ma_mon', 'ma_mon');
    }
}