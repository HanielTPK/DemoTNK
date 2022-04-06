<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DonViVanChuyen;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;


class DonViVanChuyenController extends Controller
{
    // Add
    //Chưa xét đã xóa
    public function addView()
    {
        $mode = 0;
        $dvvc="";
        return view('homepage', compact('mode','dvvc'));
    }

    function adddvvc(Request $req)
    {
        $user = Auth::user();
        $alldvvc = DonViVanChuyen::all();
        $messerror = $req->validate([
            'sdt' => 'numeric|min:9',
            'masothue' => 'numeric',
            'tendvvc' => 'required',
            'tenviettat' => 'required',

        ], [
            'tendvvc.required'=>'Tên DVVC không được bỏ trống',
            'sdt.numeric' => 'Số điện thoại phải là số',
            'sdt.min' => 'Số điện thoại phải có ít nhất 10 số',
            'masothue.numeric' => 'Mã số thuế phải là số',
            'tenviettat.required' => 'Tên viết tắt không được bỏ trống'
        ]);

        if ($req->tendvvc == $req->tenviettat) {
            return redirect()->back()->withErrors('Tên DVVC không được trùng với tên viết tắt');
        }
        foreach ($alldvvc as $var) {
            if ($var->TenDVVC == $req->tendvvc) {
                return redirect()->back()->withErrors('Tên dvvc này đã tồn tại');
            }
        }
        if ($req->masothue)
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
        $dvvc->userid = $user->id;
        $dvvc->save();
        session()->flash('success', 'Thêm thành công');
        return redirect()->back();
    }
    //Lấy đơn vị vận chuyển
    public function getalldvvc(Request $req)
    {

        if (true) {
            if ($req->fromdate != null && $req->todate != null) {
                $alldvvc = DonViVanChuyen::whereBetween('created_at', array($req->fromdate, $req->todate))->get();
            } else if ($req->fromdate != null && $req->todate == null) {

                $alldvvc = DonViVanChuyen::where('created_at', '>=', $req->fromdate)->get();
            } else if ($req->fromdate == null && $req->todate != null) {

                $alldvvc = DonViVanChuyen::where('created_at', '<=', $req->todate)->get();;
            } else {
                $alldvvc = DonViVanChuyen::all();
            }

            return Datatables::of($alldvvc)->editColumn('TenDVVC', function ($alldvvc) {
                $tentknh = $alldvvc->TenTaiKHoanNganHang == null ? $alldvvc->TenTaiKHoanNganHang : "<span style='color:red;text-align:center'>X</span>";

                $sdt = $alldvvc->Sdt == null ? $alldvvc->Sdt : "<span style='color:red;text-align:center'>X</span>";

                $motainganhang = $alldvvc->NganHangMoTaiKhoan == null ? $alldvvc->NganHangMoTaiKhoan : "<span style='color:red;text-align:center'>X</span>";

                $masothue = $alldvvc->MaSoThue == null ? $alldvvc->MaSoThue : "<span style='color:red;text-align:center'>X</span>";

                $diachi = $alldvvc->DiaChi == null ? $alldvvc->TenTaiKHoanNganHang : " ";

                $ttlienhe = $alldvvc->ThongTinLienHe == null ? $alldvvc->ThongTinLienHe : " ";

                $ghichu = $alldvvc->GhiChu == null ? $alldvvc->GhiChu : " ";

                return $alldvvc->TenDVVC . '<br>' . $tentknh;
            })->editColumn('TenVietTat', function ($alldvvc) {
                $sotknh = $alldvvc->SoTaiKhoan != null ? $alldvvc->SoTaiKhoan : '<span style="color:red;text-align:center">X</span>';
                return $alldvvc->TenVietTat . '<br>' . $sotknh;
            })->editColumn('DiaChi', function ($alldvvc) {
                return $alldvvc->DiaChi . '<br>' . $alldvvc->ThongTinLienHe . '<br>' . $alldvvc->GhiChu;
            })->editColumn('TrangThaiDVVC', function ($alldvvc) {

                $user = User::select('name')->find($alldvvc->userid);

                return $alldvvc->TrangThaiDVVC . '<br>' . $user['name'] . '<br>' . $alldvvc->created_at->format('d-M-y');
            })
                ->addColumn('action', function ($alldvvc) {
                    return     ' <a href=' . route('updatedvvcG', ['id' => $alldvvc->id]) . ' <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a  onclick="return confirm(' . "'Bạn có chắc muốn xóa'" . ')" href=' . route('deletedvvcP', ['id' => $alldvvc->id]) . ' <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                })
                ->rawColumns(['action', 'checkbox', 'TenDVVC', 'TenVietTat', 'DiaChi', 'TrangThaiDVVC'])->make(true);
        }
        return redirect()->back();
    }
    //Delete

    public function deletedvvc(Request $req)
    {
        $dvvc = DonViVanChuyen::find($req->id)->delete();

        return redirect()->back();
    }
    // Edit
    public function updateView(Request $req)
    {
        $dvvc = DonViVanChuyen::find($req->id);
        $mode = 1;
        $id=$req->id;
        return view('homepage', compact('dvvc', 'mode','id'));
    }

    public function updatedvvc(Request $req)
    {
        $messerror = $req->validate([
            'sdt' => 'numeric|min:9',
            'masothue' => 'numeric',
            'tendvvc' => 'required',
            'tenviettat' => 'required',

        ], [
            'tendvvc.required'=>'Tên DVVC không được bỏ trống',
            'sdt.numeric' => 'Số điện thoại phải là số',
            'sdt.min' => 'Số điện thoại phải có ít nhất 10 số',
            'masothue.numeric' => 'Mã số thuế phải là số',
            'tenviettat.required' => 'Tên viết tắt không được bỏ trống'
        ]);
        $dvvc=DonViVanChuyen::find($req->id);
        
        $dvvc->TenDVVC=$req->tendvvc;
        $dvvc->TenVietTat=$req->tenviettat;
        $dvvc->Sdt=$req->sdt;
        $dvvc->MaSoThue=$req->masothue;
        $dvvc->TrangThaiDVVC=$req->trangthaidvvc;
        $dvvc->NgayNgungHopTac=$req->ngayngunghoptac;
        $dvvc->TenTaiKHoanNganHang=$req->tentknganhang;
        $dvvc->SoTaiKhoan=$req->sotaikhoan;
        $dvvc->NganHangMoTaiKhoan=$req->tennganhang;
        $dvvc->DiaChi=$req->diachi;
        $dvvc->ThongTinLienHe=$req->ttlh;
        $dvvc->GhiChu=$req->ghichu;
        $dvvc->save();
        session()->flash('fail', 'Sửa thành công');
        return redirect()->route('listdvvc');

    }
    // Search  Date

}
