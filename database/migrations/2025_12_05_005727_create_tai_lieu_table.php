<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaiLieuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tai_lieu', function (Blueprint $table) {
            $table->string('ma_tai_lieu', 20)->primary();
            $table->string('tieu_de');
            $table->text('mo_ta')->nullable();
            $table->string('duong_dan_file');
            
            // Các khóa ngoại
            $table->string('ma_nguoi_dang', 20);
            $table->foreign('ma_nguoi_dang')->references('ma_nguoi_dung')->on('nguoi_dung')->onDelete('cascade');

            $table->string('ma_khoa', 10)->nullable();
            $table->foreign('ma_khoa')->references('ma_khoa')->on('khoa')->onDelete('set null');

            $table->string('ma_loai', 10)->nullable();
            $table->foreign('ma_loai')->references('ma_loai')->on('loai_tai_lieu')->onDelete('set null');

            // Laravel tự tạo cột created_at và updated_at -> map với ngay_tao, ngay_cap_nhat trong Model
            // Nhưng để chuẩn migration thì ta cứ dùng timestamps(), Model sẽ tự hiểu nhờ const CREATED_AT
            $table->timestamp('ngay_tao')->useCurrent();
            $table->timestamp('ngay_cap_nhat')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tai_lieu');
    }
}
