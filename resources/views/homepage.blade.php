@extends('indexEX')
@section('maincontent')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button></li>
                @endforeach
            </ul>
        </div>
    @endif
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
        <h1 style="text-align: center; color:rgb(89, 206, 226)">SỬA ĐƠN VỊ VẬN CHUYỂN</h1>
    @endif
    @if ($mode == 0)
        <h1 style="text-align: center; color:rgb(89, 206, 226)">THÊM ĐƠN VỊ VẬN CHUYỂN</h1>
    @endif
    <a href='javascript:history.back()'><i class="fa fa-backward" aria-hidden="true"> Quay lại</i></a>
    <div style="height: 100%; background-color:white">
        @php
            $tendvvc = $dvvc != null ? $dvvc['TenDVVC'] : '';
            $tenviettat = $dvvc != null ? $dvvc['TenVietTat'] : '';
            $sdt = $dvvc != null ? $dvvc['Sdt'] : '';
            $mst = $dvvc != null ? $dvvc['MaSoThue'] : '';
            $trangthai = $dvvc != null ? $dvvc['TrangThaiDVVC'] : '';
            $ngayngunght = $dvvc != null ? $dvvc['NgayNgungHopTac'] : '';
            $tentknh = $dvvc != null ? $dvvc['TenTaiKHoanNganHang'] : '';
            $stk = $dvvc != null ? $dvvc['SoTaiKhoan'] : '';
            $tennh = $dvvc != null ? $dvvc['NganHangMoTaiKhoan'] : '';
            $diachi = $dvvc != null ? $dvvc['DiaChi'] : '';
            $ttlh = $dvvc != null ? $dvvc['ThongTinLienHe'] : '';
            $ghichu = $dvvc != null ? $dvvc['GhiChu'] : '';
            
        @endphp
        @if ($mode == 0)
            <form action="{{ route('themdvvcP') }}" method="POST">
        @endif
        @if ($mode == 1)
            <form action="{{ route('updatedvvcP', ['id' => $id]) }}" method="POST">
        @endif
        @csrf
        <div>
            <h3>Thông tin ĐVVC</h3>
            <div class="topthem">
                <label for="">Tên ĐVVC (*)</label>
                <input value="{{ $tendvvc }}" name="tendvvc" type="text" class="form-control"
                    placeholder="Nhập tên đvvc">
            </div>
            <div class="topthem">
                <label for="">Tên viêt tắt (*)</label>
                <input value="{{ $tenviettat }}" name="tenviettat" type="text" class="form-control" id=""
                    placeholder="Nhập viết tắt">
            </div>

            <div class="topthem">
                <label for="">Số điện thoại</label>
                <input value="{{ $sdt }}" name="sdt" type="number" class="form-control" id=""
                    placeholder="Nhập SDT">
            </div>
            {{-- @error('sdt')
                <span style="color: red">{{$message}}</span>
                 @enderror --}}
            <div class="topthem">
                <label for="">Mã số thuế</label>
                <input value="{{ $mst }}" name="masothue" type="number" class="form-control" id=""
                    placeholder="Nhập MST">
            </div>

            <div class="topthem">
                <label for="topthem">Trạng thái ĐVVC (*)</label>
                <select value="{{ $trangthai }}" name="trangthaidvvc" class="form-control" id="trangthaidvvc">
                    <option value="Còn hợp tác">Còn hợp tác</option>
                    <option value="Ngưng hợp tác">Ngưng hợp tác</option>
                </select>
            </div>

            <div class="topthem">
                <label for="">Ngày ngừng hợp tác</label>

                <input value="{{ $ngayngunght }}" name="ngayngunghoptac" type="date" class="form-control"
                    id="ngayngunghoptac" placeholder="" readonly>
            </div>

            <div class="topmid">
                <label for="">Tên TK ngân hàng</label>
                <input value="{{ $tentknh }}" name="tentknganhang" type="text" class="form-control" id=""
                    placeholder="Nhập tên TK ngân hàng">
            </div>

            <div class="topmid">
                <label for="">Số tài khoản</label>
                <input value="{{ $stk }}" name="sotaikhoan" type="number" class="form-control" id=""
                    placeholder="Nhập số tài khoản">
            </div>

            <div class="topmid">
                <label for="">Mở tại ngân hàng</label>
                <input value="{{ $tennh }}" name="tennganhang" type="text" class="form-control" id=""
                    placeholder="Nhập nơi mở tài khoản">
            </div>

            <div class="topmid">
                <label for="">Địa chỉ</label>
                <textarea name="diachi" type="text" class="form-control" id=""
                    placeholder="Nhập địa chỉ">{{ $diachi }}</textarea>
            </div>

            <div class="topmid">
                <label for="">Thông tin liên hệ</label>
                <textarea name="ttlh" type="text" class="form-control" id=""
                    placeholder="Nhập thông tin liên hệ">{{ $ttlh }}</textarea>
            </div>

            <div class="topmid">
                <label for="">Ghi chú</label>
                <textarea name="ghichu" type="text" class="form-control" id=""
                    placeholder="Nhập ghi chú">{{ $ghichu }}</textarea>
            </div>
        </div>
        <a href='javascript:history.back()'><button type="button" class="btn btn-success">Quay lại</button></a>
        <button type="submit" class="btn btn-success">Lưu</button>
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
    </script>
@endsection
