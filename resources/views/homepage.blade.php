@extends('indexEX')
@section('maincontent')


    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if (session()->has('fail'))
        <div class="alert alert-danger" style="width: 500px">
            {{ session()->get('fail') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($mode == 1)
        @if ($dvvc['deleted_at'] != null)
            <div class="alert alert-danger" style="width: 500px">
                Đơn vị vận chuyển này đã bị xóa vui lòng quay lại trang trước
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <h1 style="text-align: center; color:rgb(89, 206, 226)">SỬA ĐƠN VỊ VẬN CHUYỂN</h1>
    @endif
    @if ($mode == 0)
        <h1 style="text-align: center; color:rgb(89, 206, 226)">THÊM ĐƠN VỊ VẬN CHUYỂN</h1>
    @endif
    <a href='{{ route('listdvvc') }}'><i class="fa fa-backward" aria-hidden="true"> Quay lại</i></a>
    <div style="height: 100%; background-color:white">
        @php
            $tendvvc = $dvvc != null ? $dvvc['TenDVVC'] : old('tendvvc');
            $tenviettat = $dvvc != null ? $dvvc['TenVietTat'] : old('tenviettat');
            $sdt = $dvvc != null ? $dvvc['Sdt'] : old('sdt');
            $mst = $dvvc != null ? $dvvc['MaSoThue'] : old('masothue');
            $trangthai = ($dvvc != null ? $dvvc['TrangThaiDVVC'] : old('trangthaidvvc') == 'Ngưng hợp tác') ? 'selected' : '';
            $ngayngunght = $dvvc != null ? ($dvvc['NgayNgungHopTac'] != null ? $dvvc['NgayNgungHopTac'] : old('ngayngunghoptac')) : old('ngayngunghoptac');
            $tentknh = $dvvc != null ? $dvvc['TenTaiKHoanNganHang'] : old('tentknganhang');
            $stk = $dvvc != null ? $dvvc['SoTaiKhoan'] : old('sotaikhoan');
            $tennh = $dvvc != null ? $dvvc['NganHangMoTaiKhoan'] : old('tennganhang');
            $diachi = $dvvc != null ? $dvvc['DiaChi'] : old('diachi');
            $ttlh = $dvvc != null ? $dvvc['ThongTinLienHe'] : old('ttlh');
            $ghichu = $dvvc != null ? $dvvc['GhiChu'] : old('ghichu');
            
        @endphp
        @if ($mode == 0)
            <form action="{{ route('themdvvcP') }}" method="POST">
        @endif
        @if ($mode == 1)
            <form id="editForm" action="" method="POST">
        @endif
        @csrf
        <div>
            <h3>Thông tin ĐVVC</h3>
            <div class="topthem">
                <label for="">Tên ĐVVC (*)</label>
                <input value="{{ $tendvvc }}" name="tendvvc" type="text" class="form-control" id="tendvvc"
                    placeholder="Nhập tên đvvc">

                @if ($errors->has('tendvvc'))
                    <span class="text-danger">{{ $errors->first('tendvvc') }}</span>
                @endif
            </div>
            <div class="topthem">
                <label for="">Tên viêt tắt (*)</label>
                <input value="{{ $tenviettat }}" name="tenviettat" type="text" class="form-control" id="tenviettat"
                    placeholder="Nhập viết tắt">
                @if ($errors->has('tenviettat'))
                    <span class="text-danger">{{ $errors->first('tenviettat') }}</span>
                @endif
            </div>

            <div class="topthem">
                <label for="">Số điện thoại</label>
                <input value="{{ $sdt }}" name="sdt" type="text" class="form-control" id="sdt"
                    placeholder="Nhập SDT">
                @if ($errors->has('sdt'))
                    <span class="text-danger">{{ $errors->first('sdt') }}</span>
                @endif
            </div>

            <div class="topthem">
                <label for="">Mã số thuế</label>
                <input value="{{ $mst }}" name="masothue" type="text" class="form-control" id="mst"
                    placeholder="Nhập MST">
                @if ($errors->has('masothue'))
                    <span class="text-danger">{{ $errors->first('masothue') }}</span>
                @endif
            </div>

            <div class="topthem">
                <label for="topthem">Trạng thái ĐVVC (*)</label>
                <select value="{{ $trangthai }}" name="trangthaidvvc" class="form-control" id="trangthaidvvc">
                    <option value="Còn hợp tác" {{ old('trangthaidvvc') == 'Còn hợp tác' ? 'selected' : '' }}>Còn hợp
                        tác
                    </option>
                    <option value="Ngưng hợp tác" {{ old('trangthaidvvc') == 'Ngưng hợp tác' ? 'selected' : '' }}>
                        Ngưng hợp tác
                    </option>
                </select>
                @if ($errors->has('trangthaidvvc'))
                    <span class="text-danger">{{ $errors->first('trangthaidvvc') }}</span>
                @endif
            </div>
            <div class="top">
                <div class="topthem">
                    <label for="">Ngày ngừng hợp tác</label>
                    <input value="{{ $ngayngunght }}" name="ngayngunghoptac" type="date" class="form-control"
                        id="ngayngunghoptac" placeholder="" readonly>
                    @if ($errors->has('ngayngunghoptac'))
                        <span class="text-danger">{{ $errors->first('ngayngunghoptac') }}</span>
                    @endif
                </div>
            </div>

            <div class="mid">
                <div class="topmid">
                    <label for="">Tên TK ngân hàng</label>
                    <input value="{{ $tentknh }}" name="tentknganhang" type="text" class="form-control"
                        id="tentknganhang" placeholder="Nhập tên TK ngân hàng">

                </div>

                <div class="topmid">
                    <label for="">Số tài khoản</label>
                    <input value="{{ $stk }}" name="sotaikhoan" type="text" class="form-control" id="sotaikhoan"
                        placeholder="Nhập số tài khoản">

                </div>

                <div class="topmid">
                    <label for="">Mở tại ngân hàng</label>
                    <input value="{{ $tennh }}" name="tennganhang" type="text" class="form-control"
                        id="tennganhang" placeholder="Nhập nơi mở tài khoản">
                </div>

            </div>
            <div class="topmid">
                <label for="">Địa chỉ</label>
                <textarea name="diachi" type="text" class="form-control" id="diachi"
                    placeholder="Nhập địa chỉ">{{ $diachi }}</textarea>

            </div>

            <div class="topmid">
                <label for="">Thông tin liên hệ</label>
                <textarea name="ttlh" type="text" class="form-control" id="ttlh"
                    placeholder="Nhập thông tin liên hệ">{{ $ttlh }}</textarea>

            </div>

            <div class="topmid">
                <label for="">Ghi chú</label>
                <textarea name="ghichu" type="text" class="form-control" id="ghichu"
                    placeholder="Nhập ghi chú">{{ $ghichu }}</textarea>

            </div>
        </div>
        <a href="{{ route('listdvvc') }} "><button type="button" class="btn btn-success">Quay lại</button></a>
        <button type="submit" id="btnSubmit" class="btn btn-success">Lưu</button>
        </form>
    </div>
    <script>
        var trangthaidvvc = $('#trangthaidvvc').find(':selected').val();
        layngayngunghoptac(trangthaidvvc);
        $('#trangthaidvvc').change(function() {
            trangthaidvvc = this.value;
            layngayngunghoptac(trangthaidvvc);
            console.log(trangthaidvvc);
        });

        function convertDate(month) {
            if (month < 10) {
                return '0' + month;
            } else {
                return month;
            }
        }

        function layngayngunghoptac(trangthai) {
            if (trangthai == 'Còn hợp tác') {
                $('#ngayngunghoptac').prop('readonly', true);
            } else {
                $('#ngayngunghoptac').prop('readonly', false);

                // const today = new Date();
                // var dateNow = today.getFullYear() + '-' + (convertDate(today.getMonth() + 1)) + '-' + convertDate(today
                //     .getDate());
                // $('#ngayngunghoptac').val(dateNow);
            }
        }
        $(document).ready(function() {
            $("#editForm").submit(function(e) {
                e.preventDefault();
                var tendvvc = $("#tendvvc").val();
                var tenviettat = $("#tenviettat").val();
                var mst = $("#mst").val();
                var trangthaidvvc = $("#trangthaidvvc").val();
                var ngayngunghoptac = $("#ngayngunghoptac").val();
                var sotaikhoan = $("#sotaikhoan").val();
                var tennganhang = $("#tennganhang").val();
                var diachi = $("#diachi").val();
                var ttlh = $("#ttlh").val();
                var ghichu = $("#ghichu").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{ route('updatedvvcP') }}',
                    data: {
                        id: {{ $id }},
                        tendvvc: tendvvc,
                        tenviettat: tenviettat,
                        mst: mst,
                        trangthaidvvc: trangthaidvvc,
                        ngayngunghoptac: ngayngunghoptac,
                        sotaikhoan: sotaikhoan,
                        tennganhang: tennganhang,
                        diachi: diachi,
                        ghichu: ghichu,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(data) {
                        alert('ok');
                    },
                    error: function(data) {
                        // printErrorMsg(data.error);
                    }
                });
            });

        })

        // function printErrorMsg(msg) {
        //     $(".print-error-msg").find("ul").html('');
        //     $(".print-error-msg").css('display', 'block');
        //     $.each(msg, function(key, value) {
        //         $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
        //     });
        // }
        // });
    </script>
@endsection
