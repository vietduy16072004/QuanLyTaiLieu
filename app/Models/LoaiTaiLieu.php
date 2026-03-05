<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiTaiLieu extends Model
{
    protected $table = 'loai_tai_lieu';
    protected $primaryKey = 'ma_loai';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['ma_loai', 'ten_loai'];

    // Quan hệ: Một loại có nhiều tài liệu
    public function taiLieu() {
        return $this->hasMany(TaiLieu::class, 'ma_loai', 'ma_loai');
    }
}