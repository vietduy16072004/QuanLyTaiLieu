<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaMonToTaiLieuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tai_lieu', function (Blueprint $table) {
            // Thêm cột ma_mon, cho phép null (để các tài liệu cũ không bị lỗi)
            $table->string('ma_mon', 10)->nullable()->after('ma_loai');

            // Tạo khóa ngoại
            $table->foreign('ma_mon')->references('ma_mon')->on('mon_hoc')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tai_lieu', function (Blueprint $table) {
            //
        });
    }
}
