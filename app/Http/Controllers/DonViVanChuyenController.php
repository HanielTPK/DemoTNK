<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DonViVanChuyen;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Illuminate\Validation\Rule;
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
            'sdt' => 'nullable|numeric|min:10',
            'masothue' => 'nullable|numeric',
            'tendvvc' => 'unique:donvivanchuyen,TenDVVC',
            'tenviettat' => 'unique:donvivanchuyen,TenVietTat'
        ], [
            'tendvvc.required' => 'Tên ĐVVC không được bỏ trống',
            'tenviettat.required' => 'Tên viết tắt không được bỏ trống',
            'sdt.numeric' => 'Số điện thoại phải là số',
            'sdt.max' => 'Số điện phải có ít nhất 10 chữ số ',
            'masothue.numeric' => 'Mã số thuế phải là số',
            'tendvvc.unique' => 'Tên ĐVVC không được trùng',
            'tenviettat.unique' => 'Tên viết tắt không được trùng'
        ]);
        $username = $req->old('dvvc');

        // foreach ($alldvvc as $var) {
        //     if ($var->TenDVVC == $req->tendvvc && $var->deleted_at != null) {
        //         return redirect()->back()->withInput()->with('message', 'Tên ĐVVC này đã tồn tại hoặc đã bị xóa');
        //     } else if ($var->TenDVVC == $req->tendvvc && $var->deleted_at == null) {
        //         return redirect()->back()->withInput()->with('message', 'Tên ĐVVC này đã tồn tại');
        //     } else if ($var->TenVietTat == $req->tenviettat && $var->deleted_at == null) {
        //         return redirect()->back()->withInput()->with('message', 'Tên viết tắt này đã tồn tại');
        //     }
        // }
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
        $dvvc->TrangThaiSua = false;
        $dvvc->save();
        session()->flash('success', 'Thêm thành công');
        return redirect()->refresh();
    }
    //Lấy đơn vị vận chuyển
    public function getalldvvc(Request $req)
    {
        $date = new Carbon($req->todate);
        $date->addDay();
        $req->todate = $date;

        if (true) {
            if ($req->searchselect != null || $req->searchselect0 != null || $req->searchselect1 != null) {
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
                $tentknh = $alldvvc->TenTaiKHoanNganHang != null ? $alldvvc->TenTaiKHoanNganHang : "<span style='color:red;text-align:center'>X</span>";;
                $masothue = $alldvvc->MaSoThue == null ? $alldvvc->MaSoThue : "<span style='color:red;text-align:center'>X</span>";

                $diachi = $alldvvc->DiaChi == null ? $alldvvc->TenTaiKHoanNganHang : " ";

                $ttlienhe = $alldvvc->ThongTinLienHe == null ? $alldvvc->ThongTinLienHe : " ";

                $ghichu = $alldvvc->GhiChu == null ? $alldvvc->GhiChu : " ";
                return $alldvvc->TenDVVC . '<br>' . $tentknh;
            })->editColumn('TenVietTat', function ($alldvvc) {
                $userlog = Auth::user();
                $sotknh = $alldvvc->SoTaiKhoan != null ? $alldvvc->SoTaiKhoan : '<span style="color:red;text-align:center">X</span>';
                return $alldvvc->TenVietTat . '<br>' . $sotknh . "<br>" . $userlog['name'];
            })->editColumn('Sdt', function ($alldvvc) {
                $userlog = Auth::user();
                $sdt = $alldvvc->Sdt != null ? $alldvvc->Sdt : "<span style='color:red;text-align:center'>X</span>";
                $motainganhang = $alldvvc->NganHangMoTaiKhoan != null ? $alldvvc->NganHangMoTaiKhoan : "<span style='color:red;text-align:center'>X</span>";
                $user = User::select('name')->find($alldvvc->userid);
                return $sdt . '<br>' . $motainganhang . '<br>' . $userlog['email'];
            })->editColumn('DiaChi', function ($alldvvc) {
                $ttlienhe = $alldvvc->ThongTinLienHe != null ? $alldvvc->ThongTinLienHe : '<span style="color:red;text-align:center">X</span>';
                return $alldvvc->DiaChi . '<br>' . $ttlienhe . '<br>' . $alldvvc->GhiChu;
            })->editColumn('TrangThaiDVVC', function ($alldvvc) {

                $user = User::select('name')->find($alldvvc->userid);
                $userUpdate = User::select('name')->find($alldvvc->userupdateid);
                $dateCreate = $alldvvc->created_at->format('d-m-y');
                $dateUpdate = $alldvvc->updated_at == null ? " " : $alldvvc->updated_at->format('d-m-y');
                return $alldvvc->TrangThaiDVVC . '<br>' . $user['name'] . "/" . $dateCreate . "<br>" . $userUpdate['name'] . "/." . $dateUpdate;
            })->editColumn('MaSoThue', function ($alldvvc) {

                return $alldvvc->MaSoThue . '<br><span style="color:red;text-align:center">X</span>';
            })->editColumn('NgayNgungHopTac', function ($alldvvc) {
                return "<span style='color:red;text-align:center'>X</span>";
            })
                ->addColumn('action', function ($alldvvc) {
                    return     ' <a id="btnEdit"   href=' . route('updatedvvcG', ['id' => $alldvvc->id]) . ' onclick=""  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a id="btnDelete"  onclick="return confirm(' . "'Bạn có chắc muốn xóa'" . ')" href=' . route('deletedvvcP', ['id' => $alldvvc->id]) . ' <i class="fa fa-trash-o" aria-hidden="true"></i></a>';
                })
                ->rawColumns(['NgayNgungHopTac', 'MaSoThue', 'action', 'checkbox', 'TenDVVC', 'TenVietTat', 'DiaChi', 'TrangThaiDVVC', 'Sdt'])->make(true);
        }
        return redirect()->back();
    }
    //Delete

    public function deletedvvc(Request $req)
    {
        $dvvc = DonViVanChuyen::find($req->id)->delete();
        session()->flash('fail', 'Xóa thành công');
        return redirect()->back();
    }
    // EditView
    public function updateView(Request $req)
    {
        $dvvc = DonViVanChuyen::find($req->id);
        $mode = 1;
        $id = $req->id;
        return view('homepage', compact('dvvc', 'mode', 'id'));
    }
    public function changeEditState(Request $req)
    {
        $dvvc = DonViVanChuyen::find($req->id);
        $dvvc->TrangThaiSua = true;
        $dvvc->save();
        return response()->json(array('success' => true));
    }
    // Edit Process
    public function updatedvvc(Request $req)
    {
        $alldvvc = DonViVanChuyen::all();
        $user = Auth::user();
        $dvvc = DonViVanChuyen::find($req->id);
        $validator = $req->validate([

            'tenviettat' => 'required',
            'tendvvc' => 'required',
            'sdt' => 'nullable|numeric|min:10',
            'masothue' => 'nullable|numeric',
            'tendvvc' => 'unique:donvivanchuyen,TenDVVC',
            'tendvvc' => Rule::unique('donvivanchuyen')->ignore($dvvc->id, 'id'),
            'tenviettat' => 'unique:donvivanchuyen,TenVietTat',
            'tenviettat' => Rule::unique('donvivanchuyen')->ignore($dvvc->id, 'id'),
        ], [
            'tendvvc.required' => 'Tên ĐVVC không được bỏ trống',
            'tenviettat.required' => 'Tên viết tắt không được bỏ trống',
            'sdt.numeric' => 'Số điện thoại phải là số',
            'sdt.max' => 'Số điện phải có ít nhất 10 chữ số ',
            'masothue.numeric' => 'Mã số thuế phải là số',
            'tendvvc.unique' => 'Tên ĐVVC không được trùng',
            'tenviettat.unique' => 'Tên viết tắt không được trùng'
        ]);

        //  foreach ($alldvvc as $var) {
        //             if ($var->TenDVVC == $req->tendvvc && $var->deleted_at != null) {
        //                 return redirect()->back()->withInput()->with('message', 'Tên ĐVVC này đã tồn tại hoặc đã bị xóa');
        //             } else if ($var->TenDVVC == $req->tendvvc && $var->deleted_at == null && $var->id != $req->id) {
        //                 return redirect()->back()->withInput()->with('message', 'Tên ĐVVC này đã tồn tại');
        //             } else if ($var->TenVietTat == $req->tenviettat && $var->deleted_at == null && $var->id != $req->id) {
        //                 return redirect()->back()->withInput()->with('message', 'Tên viết tắt này đã tồn tại');
        //             }
        //         }

        if (empty(DonViVanChuyen::find($req->id))) {
            session()->flash('fail', 'Sửa ko thành công');
            return redirect()->route('listdvvc');
        }
        // if ($validator->fails()) {
        //     return response()->json(array(
        //         'success' => false,
        //         'errors' => $validator->getMessageBag()->toArray()

        //     ), 400); // 400 being the HTTP code for an invalid request.
        // }
        if ($validator->fails()) {
            return response()->json(array('edit_errors' => $validator->getMessageBag()->toArray()));
        }
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
        $dvvc->TrangThaiSua = false;
        $dvvc->save();
        session()->flash('success', 'Sửa thành công');
        return response()->json($validator);
    }
}
