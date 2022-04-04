<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DonViVanChuyen;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class DonViVanChuyenController extends Controller
{
    // Thêm đơn vị vận chuyển
    //Chưa xét đã xóa
    function themdvvc(Request $req)
    {
        $user=Auth::user();
        $alldvvc = DonViVanChuyen::all();
        $req->validate([
            'sdt' => 'numeric|min:9',
            'masothue' => 'numeric',
            'tendvvc' => 'required',
            'tenviettat' => 'required',

        ], [
            'sdt.numeric' => 'Số điện thoại phải là số',
            'sdt.min' => 'Số điện thoại phải có ít nhất 10 số',
            'password.required' => 'Vui lòng nhập mật khẩu'
        ]);

        if ($req->tendvvc == $req->tenviettat) {
            return redirect()->back()->withErrors('Tên DVVC không được trùng với tên viết tắt');
        }
        foreach ($alldvvc as $var) {
            if ($var->TenDVVC == $req->tendvvc) {
                return redirect()->back()->withErrors('Tên dvvc này đã tồn tại');
            }
        }
        if($req->masothue)
        $dvvc = new DonViVanChuyen;
        $dvvc->TenDVVC = $req->tendvvc;
        $dvvc->TenVietTat = $req->tenviettat;
        $dvvc->SDT = $req->sdt;
        $dvvc->MaSoThue = $req->masothue;
        $dvvc->TrangThaiDVVC = $req->trangthaidvvc;
        $dvvc->NgayNgungHopTac = $req->ngayngunghoptac;
        $dvvc->TenTaiKHoanNganHang = $req->tentknganhang;
        $dvvc->SoTaiKhoan = $req->sotaikhoan;
        $dvvc->NganHangMoTaiKhoan = $req->tennganhang;
        $dvvc->DiaChi = $req->diachi;
        $dvvc->ThongTinLienHe = $req->thongtinlienhe;
        $dvvc->GhiChu = $req->ghichu;
        $dvvc->userid=$user->id;
        $dvvc->save();
        session()->flash('success', 'Thêm thành công');
        return redirect()->back();
    }
    //Lấy đơn vị vận chuyển
    public function getalldvvc()
    {
        $alldvvc = DonViVanChuyen::all();
        return Datatables::of($alldvvc)->editColumn('TenDVVC', function ($alldvvc) {
            $tentknh=$alldvvc->TenTaiKHoanNganHang==null?$alldvvc->TenTaiKHoanNganHang:"<span style='color:red;text-align:center'>X</span>";

            $sdt=$alldvvc->Sdt==null?$alldvvc->Sdt:"<span style='color:red;text-align:center'>X</span>";

            $motainganhang=$alldvvc->NganHangMoTaiKhoan==null?$alldvvc->NganHangMoTaiKhoan:"<span style='color:red;text-align:center'>X</span>";

            $masothue=$alldvvc->MaSoThue==null?$alldvvc->MaSoThue:"<span style='color:red;text-align:center'>X</span>";

            $diachi=$alldvvc->DiaChi==null?$alldvvc->TenTaiKHoanNganHang:" ";

            $ttlienhe=$alldvvc->ThongTinLienHe==null?$alldvvc->ThongTinLienHe:" ";

            $ghichu=$alldvvc->GhiChu==null?$alldvvc->GhiChu:" ";

            return $alldvvc->TenDVVC.'<br>'.$tentknh;
        })->editColumn('TenVietTat',function($alldvvc){
            $sotknh=$alldvvc->SoTaiKhoan!=null?$alldvvc->SoTaiKhoan:'<span style="color:red;text-align:center">X</span>';
            return $alldvvc->TenVietTat.'<br>'.$sotknh;
        })->editColumn('DiaChi',function($alldvvc){
            return $alldvvc->DiaChi.'<br>'.$alldvvc->ThongTinLienHe.'<br>'.$alldvvc->GhiChu;
        })
            ->addColumn('action',function($alldvvc){
           return     ' <a href="" <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a  onclick="return confirm('."'Bạn có chắc muốn xóa'".')" href='.route('deletedvvcp',['id'=>$alldvvc->id]).' <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            })
            ->rawColumns(['action', 'checkbox', 'TenDVVC','TenVietTat','DiaChi'])->make(true);
    }
    //Xoa

    public function deletedvvc(Request $req)
    {
        $dvvc=DonViVanChuyen::find($req->id)->delete();
      
        return redirect()->back();
    }
    public function update(Request $req)
    {
    
    }

}
