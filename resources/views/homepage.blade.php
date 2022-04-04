@extends('indexEX')
@section('maincontent')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }} <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button></li>
                    
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
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
    <h1 style="text-align: center; color:rgb(89, 206, 226)">THÊM ĐƠN VỊ VẬN CHUYỂN</h1>
    <a><i class="fa fa-backward" aria-hidden="true"> Quay lại</i></a>
    <div>
        <form action="{{ route('themdvvcp') }}" method="POST">
            @csrf
            <div>
                <h3>Thông tin ĐVVC</h3>
                <div class="topthem">
                    <label for="">Tên ĐVVC</label>
                    <input name="tendvvc" type="text" class="form-control" placeholder="Nhập tên đvvc">
                </div>
                <div class="topthem">
                    <label for="">Tên viêt tắt</label>
                    <input name="tenviettat" type="text" class="form-control" id="" placeholder="Nhập viết tắt">
                </div>

                <div class="topthem">
                    <label for="">Số điện thoại</label>
                    <input name="sdt" type="text" class="form-control" id="" placeholder="Nhập SDT">
                </div>

                <div class="topthem">
                    <label for="">Mã số thuế</label>
                    <input name="masothue" type="number" class="form-control" id="" placeholder="Nhập MST">
                </div>

                <div class="topthem">
                    <label for="topthem">Trạng thái ĐVVC</label>
                    <select name="trangthaidvvc" class="form-control">
                        <option value="Còn hợp tác">Còn hợp tác</option>
                        <option value="Ngưng hợp tác">Ngưng hợp tác</option>
                    </select>
                </div>

                <div class="topthem">
                    <label for="">Ngày ngừng hợp tác</label>

                    <input name="ngayngunghoptac" type="date" class="form-control" id="" placeholder="" readonly>
                </div>

                <div class="topmid">
                    <label for="">Tên TK ngân hàng</label>
                    <input name="tentknganhang" type="text" class="form-control" id=""
                        placeholder="Nhập tên TK ngân hàng">
                </div>

                <div class="topmid">
                    <label for="">Số tài khoản</label>
                    <input name="sotaikhoan" type="number" class="form-control" id="" placeholder="Nhập số tài khoản">
                </div>

                <div class="topmid">
                    <label for="">Mở tại ngân hàng</label>
                    <input name="tennganhang" type="text" class="form-control" id="" placeholder="Nhập nơi mở tài khoản">
                </div>

                <div class="topmid">
                    <label for="">Địa chỉ</label>
                    <textarea name="diachi" type="text" class="form-control" id="" placeholder="Nhập địa chỉ"></textarea>
                </div>

                <div class="topmid">
                    <label for="">Thông tin liên hệ</label>
                    <textarea name="thongtinlienhe" type="text" class="form-control" id=""
                        placeholder="Nhập thông tin liên hệ"></textarea>
                </div>

                <div class="topmid">
                    <label for="">Ghi chú</label>
                    <textarea name="ghichu" type="text" class="form-control" id="" placeholder="Nhập ghi chú"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-success">lưu</button>
        </form>
    </div>
@endsection
