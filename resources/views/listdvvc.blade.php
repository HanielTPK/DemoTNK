@extends('indexEX')
@section('maincontent')
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
    <div style="background-color: white">
        <h1 style="text-align: center; color:rgb(89, 206, 226)">DANH MỤC ĐƠN VỊ VẬN CHUYỂN</h1>
    <a><i class="fa fa-backward" aria-hidden="true"> Quay lại</i></a><br>
    <div class="">
        <select name="" class="form-control" style="width: 20%">
            <option value="Còn hợp tác">Ngày tạo</option>
            <option value="Ngưng hợp tác">Ngày sửa</option>
        </select>
    </div>

    <div>
<span>Từ ngày</span>

<input class="form-control" style="width: 20%; " type="date">

<span>Đến ngày</span>

<input class="form-control" style="width: 20%; " type="date">
    </div>
 <div>
    <button type="submit" class='btn btn-success' style="float: right" ></button></div>
    <div>
        <table class="table" id="table">
            <thead class="thead-info">
                <tr>
                    <th scope="col" >
                        STT
                    </th scope="col">
                    
                    <th scope="col">
                        TÊN ĐẦY ĐỦ/<br>TÊN TK NGÂN HÀNG
                    </th>
                    <th scope="col">
                        TÊN VIẾT TẮT/<br>SỐ TK MH/<br>TK ĐĂNG NHẬP
                    </th>
                    <th scope="col">
                        MÃ SỐ THUẾ/<br>SDT NGƯỜI DÙNG TK
                    </th>

                    <th scope="col">
                        QUYỀN TK DN
                    </th>
                    <th scope="col"> 
                        ĐỊA CHỈ/<br>THÔNG TIN/<BR>GHI CHÚ
                    </th>
                    <th scope="col">
                        TRẠNG THÁI ID VẬN CHUYỂN/<BR>ID NGƯỜI TẠO/ <BR>NGƯỜI TẠO/ SỬA/<br> NGÀY TẠO/ SỬA
                    </th>
                    <th scope="col">
                        CHỨC NĂNG
                    </th>
                </tr>
            </thead>
        </table>
    </div>
    </div>
    
    <script>
        $(function() {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                lengthMenu: [20, 40, 60, 80, 100],
                ajax: "{{ url('list/data') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'TenDVVC',
                        name: 'tendvvc'
                    },
                    {
                        data: 'TenVietTat',
                        name: 'tenviettat'
                    },
                    {
                        data: 'MaSoThue',
                        name: 'masothue'
                    },
                    {
                        data: 'NgayNgungHopTac',
                        name: 'ngayngunghoptac'
                    }, {
                        data: 'DiaChi',
                        name: 'diachi'
                    },
                    {
                        data: 'TrangThaiDVVC',
                        name: 'trangthaidvvc'
                    }, {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });
            $('#table').DataTable().ajax.reload();
        })
    </script>


@endsection
