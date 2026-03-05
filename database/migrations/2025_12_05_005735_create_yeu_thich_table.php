<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYeuThichTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yeu_thich', function (Blueprint $table) {
            $table->id();
            
            $table->string('ma_nguoi_dung', 20);
            $table->foreign('ma_nguoi_dung')->references('ma_nguoi_dung')->on('nguoi_dung')->onDelete('cascade');

            $table->string('ma_tai_lieu', 20);
            $table->foreign('ma_tai_lieu')->references('ma_tai_lieu')->on('tai_lieu')->onDelete('cascade');

            $table->timestamp('ngay_them')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yeu_thich');
    }
}
