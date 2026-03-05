<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNguoiDungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nguoi_dung', function (Blueprint $table) {
            $table->string('ma_nguoi_dung', 20)->primary(); // Mã SV/GV làm ID
            $table->string('ho_ten', 100);
            $table->string('email', 100)->unique();
            $table->string('mat_khau');
            $table->enum('vai_tro', ['sinh_vien', 'giang_vien', 'quan_tri'])->default('sinh_vien');
            
            // Khóa ngoại liên kết với bảng Khoa
            $table->string('ma_khoa', 10)->nullable();
            $table->foreign('ma_khoa')->references('ma_khoa')->on('khoa')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nguoi_dung');
    }
}
