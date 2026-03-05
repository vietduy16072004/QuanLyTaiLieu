<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonHoc extends Model
{
    protected $table = 'mon_hoc';
    protected $primaryKey = 'ma_mon';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['ma_mon', 'ten_mon'];
}