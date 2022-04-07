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
        $dvvc = "";
        return view('homepage', compact('mode', 'dvvc'));
    }

    function adddvvc(Request $req)
    {
        $user = Auth::user();
        $alldvvc = DonViVanChuyen::all();
        $messerror = $req->validate([

            'tenviettat' => 'required',
            'tendvvc' => 'required',
        ], [
            'tendvvc.required' => 'Tên DVVC không được bỏ trống',

            'tenviettat.required' => 'Tên viết tắt không được bỏ trống'
        ]);

        if ($req->tendvvc == $req->tenviettat) {
            return redirect()->back()->withErrors('Tên DVVC không được trùng với tên viết tắt');
        }
        foreach ($alldvvc as $var) {
            if($var->TenDVVC == $req->tendvvc&& $var->deleted_at!=null){
                return redirect()->back()->withErrors('Tên dvvc này đã tồn tại hoặc đã bị xóa');
            }
            else if ($var->TenDVVC == $req->tendvvc&& $var->deleted_at==null) {
                return redirect()->back()->withErrors('Tên dvvc này đã tồn tại');
            }
        }
        
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
        $dvvc->updated_at = null;
        $dvvc->userupdateid = null;
        $dvvc->save();
        session()->flash('success', 'Thêm thành công');
        return redirect()->back();
    }
    //Lấy đơn vị vận chuyển
    public function getalldvvc(Request $req)
    {

        if (true) {
            if ($req->searchselect != null || $req->searchselect != null || $req->searchselect != null) {
                $query = $req->searchinput != null ? [$req->searchselect, 'LIKE', '%' . $req->searchinput . '%'] : ['deleted_at',  null];
                $query1 = $req->searchselect0 != null ? [$req->searchselect0, 'LIKE', '%' . $req->searchinput0 . '%'] : ['deleted_at', null];
                $query2 = $req->searchselect1 != null ? [$req->searchselect1, 'LIKE', '%' . $req->searchinput1 . '%'] : ['deleted_at', null];

                $query3 = $req->fromdate != null && $req->todate != null && $req->datetype == 'Ngày tạo' ? ['created_at', '>=', $req->fromdate] : ['deleted_at', null];
                $query4 = $req->fromdate != null && $req->todate != null && $req->datetype == 'Ngày tạo' ? ['created_at', '<=', $req->todate] : ['deleted_at', null];
                $query5 = $req->fromdate != null && $req->todate == null && $req->datetype == 'Ngày tạo' ? ['created_at', '>=', $req->fromdate] : ['deleted_at', null];
                $query6 = $req->fromdate != null && $req->todate == null && $req->datetype == 'Ngày tạo' ? ['created_at', '<=', $req->fromdate] : ['deleted_at', null];

                $query7 = $req->fromdate != null && $req->todate != null && $req->datetype == 'Ngày sửa' ? ['updated_at', '>=', $req->fromdate] : ['deleted_at', null];
                $query8 = $req->fromdate != null && $req->todate != null && $req->datetype == 'Ngày sửa' ? ['updated_at', '<=', $req->todate] : ['deleted_at', null];
                $query9 = $req->fromdate != null && $req->todate == null && $req->datetype == 'Ngày sửa' ? ['updated_at', '>=', $req->fromdate] : ['deleted_at', null];
                $query10 = $req->fromdate != null && $req->todate == null && $req->datetype == 'Ngày sửa' ? ['updated_at', '<=', $req->fromdate] : ['deleted_at', null];
                $alldvvc = DonViVanChuyen::where([
                    $query, $query1, $query2, $query3, $query4, $query5, $query6, $query7, $query8, $query9, $query10
                ])->get();
            } else
            if ($req->datetype == 'Ngày tạo' && $req->fromdate != null && $req->todate != null) {
                if ($req->fromdate != null && $req->todate != null) {
                    $alldvvc = DonViVanChuyen::whereBetween('created_at', array($req->fromdate, $req->todate))->get();
                } else if ($req->fromdate != null && $req->todate == null) {

                    $alldvvc = DonViVanChuyen::where('created_at', '>=', $req->fromdate)->get();
                } else if ($req->fromdate == null && $req->todate != null) {

                    $alldvvc = DonViVanChuyen::where('created_at', '<=', $req->todate)->get();;
                }
            } else if ($req->datetype == 'Ngày sửa') {
                if ($req->fromdate != null && $req->todate != null) {
                    $alldvvc = DonViVanChuyen::whereBetween('updated_at', array($req->fromdate, $req->todate))->get();
                } else if ($req->fromdate != null && $req->todate == null) {

                    $alldvvc = DonViVanChuyen::where('updated_at', '>=', $req->fromdate)->get();
                } else if ($req->fromdate == null && $req->todate != null) {

                    $alldvvc = DonViVanChuyen::where('updated_at', '<=', $req->todate)->get();;
                }
            } else {
                $alldvvc = DonViVanChuyen::all();
                $a = 0;
            }

            return Datatables::of($alldvvc)->editColumn('TenDVVC', function ($alldvvc) {
                $tentknh = $alldvvc->TenTaiKHoanNganHang == null ? $alldvvc->TenTaiKHoanNganHang : "<span style='color:red;text-align:center'>X</span>";;
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
                $userUpdate = User::select('name')->find($alldvvc->userupdateid);
                $dateCreate = $alldvvc->created_at->format('d-m-y');
                $dateUpdate = $alldvvc->updated_at == null ? " " : $alldvvc->updated_at->format('d-m-y');
                return $alldvvc->TrangThaiDVVC . '<br>' . $user['name'] . "/" . $dateCreate . "<br>" . $userUpdate['name'] . "/." . $dateUpdate;
            })->editColumn('MaSoThue', function ($alldvvc) {
                $sdt = $alldvvc->Sdt == null ? $alldvvc->Sdt : "<span style='color:red;text-align:center'>X</span>";
                $motainganhang = $alldvvc->NganHangMoTaiKhoan == null ? $alldvvc->NganHangMoTaiKhoan : "<span style='color:red;text-align:center'>X</span>";
                $user = User::select('name')->find($alldvvc->userid);
                return $alldvvc->MaSoThue;
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
        $id = $req->id;
        return view('homepage', compact('dvvc', 'mode', 'id'));
    }

    public function updatedvvc(Request $req)
    {
        $user = Auth::user();
        $messerror = $req->validate([       
           'tendvvc' => 'required',
            'tenviettat' => 'required',
        ], [
            'tendvvc.required' => 'Tên DVVC không được bỏ trống',
            'tenviettat.required' => 'Tên viết tắt không được bỏ trống'
        ]);
        $dvvc = DonViVanChuyen::find($req->id);

        $dvvc->TenDVVC = $req->tendvvc;
        $dvvc->TenVietTat = $req->tenviettat;
        $dvvc->Sdt = $req->sdt;
        $dvvc->MaSoThue = $req->masothue;
        $dvvc->TrangThaiDVVC = $req->trangthaidvvc;
        $dvvc->NgayNgungHopTac = $req->ngayngunghoptac;
        $dvvc->TenTaiKHoanNganHang = $req->tentknganhang;
        $dvvc->SoTaiKhoan = $req->sotaikhoan;
        $dvvc->NganHangMoTaiKhoan = $req->tennganhang;
        $dvvc->DiaChi = $req->diachi;
        $dvvc->ThongTinLienHe = $req->ttlh;
        $dvvc->GhiChu = $req->ghichu;
        $dvvc->userupdateid = $user->id;
        $dvvc->save();
        session()->flash('fail', 'Sửa thành công');
        return redirect()->route('listdvvc');
    }
    // Search  Date

}
