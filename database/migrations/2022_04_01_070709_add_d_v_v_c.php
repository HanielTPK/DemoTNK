<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDVVC extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DonViVanChuyen', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('TenDVVC');
            $table->string('TenVietTat');
            $table->integer('Sdt')->nullale();
            $table->integer('MaSoThue')->nullale();
            $table->String('TrangThaiDVVC');
            $table->date('NgayNgungHopTac')->nullale();
            $table->String('TenTaiKHoanNganHang')->nullale();
            $table->integer('SoTaiKhoan')->nullale();
            $table->String('NganHangMoTaiKhoan')->nullale();
            $table->String('DiaChi')->nullale();
            $table->longText('ThongTinLienHe')->nullale();
            $table->longText('GhiChu')->nullale();
            $table->rememberToken();
            $table->softDeletes();
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
        //
    }
}
