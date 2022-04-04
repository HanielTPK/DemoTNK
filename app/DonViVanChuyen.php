<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class DonViVanChuyen extends Model
{
    protected $table='donvivanchuyen';
    protected $fillable=['TenDVVC','TenVietTat','Sdt','MaSoThue','TrangThaiDVVC','NgayNgungHopTac','TenTaiKhoanNganHang','SoTaiKhoan','NganHangMoTaiKhoan','DiaChi','ThongTinLienHe','GhiChu'];
    use SoftDeletes;
}
