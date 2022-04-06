@extends('indexEX')
@section('maincontent')
    @if (session()->has('fail'))
        <div class="alert alert-success" role="alert" style="width: 500px">
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

    <h1 style="text-align: center; color:rgb(89, 206, 226)">DANH SÁCH ĐƠN VỊ VẬN CHUYỂN</h1>
    <div style="background-color: white;height:100%; border-top-color: red ">
        <div style="height: 40%">
            <a href="{{ url()->previous() }}"><i class="fa fa-backward" aria-hidden="true"> Quay lại</i></a><br>
            <div style="float: right">

                <button type="submit" class='btn btn-success' style="float: right; margin: 5px" id="Search">Tìm
                    kiếm</button>

                <button type="submit" class='btn btn-success' style="float: right; margin: 5px" id="Refresh">Tất cả</button>

                <button type="submit" class='btn btn-success' style="float: right;  margin: 5px" id="AddSearch">+</button>

            </div>
            <div style="width: 60%; margin:10px">
                <div style="float: right">
                    <span>Đến ngày</span>

                    <input class="form-control" style=" " type="date" id="todate"><br>
                </div>
                <div style="float: right; ">
                    <span>Từ ngày</span>

                    <input class="form-control" style="" type="date" id="fromdate">
                </div>

            </div>

            <div class="date-search">
                <select name="" class="form-control" style="width: 20%">
                    <option value="Còn hợp tác">Ngày tạo</option>
                    <option value="Ngưng hợp tác">Ngày sửa</option>
                </select>
            </div>
            <div class="" id="searchForm" style="padding-top: 40px;size:20ch">
                <label style="float: left; padding-right:20px" for="topthem">Danh mục tìm</label>
                <div style="width:200px;float: left; padding-right:20px">
                    <select class="form-control" id="SearchContent">
                        <option disabled selected value> -- Cột cần tìm -- </option>
                        <option value="TenDVVC">TÊN ĐƠN VỊ VẬN CHYỂN</option>
                        <option value="TenVietTat">TÊN VIẾT TẮT</option>
                        <option value="DiaChi">ĐỊA CHỈ</option>
                        <option value="SDT">SỐ ĐIỆN THOẠI </option>
                        <option value="GhiChu">GHI CHÚ</option>
                    </select>
                </div>
                <label for="" style="float:left; padding-right:20px">Nội dung tìm</label>

                <div class="col-md-4" style="width: 200px">
                    <input class="form-control" type="text" placeholder="-- Nội dung tìm --">
                </div>
                <div style="">
                    <a href=""><button class="btn btn-danger">X</button></a>
                </div>
            </div>

            <div>
                <a href="{{ route('themdvvcG') }}"> <button type="submit" class='btn btn-success' style="float:left; padding-top:10px"
                        id="Refresh">Thêm</button></a>
            </div>

        </div>
        <div style="height: 100%; margin:10px">
            <table class="table" id="table">
                <thead class="thead-info" style="background-color:cornflowerblue">
                    <tr>
                        <th scope="col">
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
                            TRẠNG THÁI ID VẬN CHUYỂN/<BR>NGƯỜI TẠO/ SỬA/<br> NGÀY TẠO/ SỬA
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
        var count = 0
        loaddata();
        $(document).ready(function() {
            $('#SearchContent').selectize({
                sortField: 'text'
            });
        });

        function selectizeA() {
            $(document).ready(function() {
                $('#SearchContent0').selectize({
                    sortField: 'text'
                });
            });

        }

        function loaddata(from_date = ' ', to_date = ' ') {
            $(document).ready(function() {
                $('#table').DataTable({
                    info: false,
                    processing: true,
                    serverSide: true,
                    ordering: false,
                    searching: false,
                    lengthMenu: [20, 40, 60, 80, 100],
                    ajax: {
                        url: '{{ route('getdata') }}',
                        data: {
                            fromdate: from_date,
                            todate: to_date
                        },
                    },
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
        }
        $('#Search').click(function() {
            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();
            console.log(fromdate);
            $('#table').DataTable().destroy();
            loaddata(from_date = fromdate, to_date = todate);
        })

        var FormDanhMuc =
            '<br><div class="" id="searchForm" style="padding-top: 40px;size:20ch"><label style="float: left; padding-right:20px" for="topthem">Danh mục tìm</label><div style="width:200px;float: left; padding-right:20px"><select class="form-control" id="SearchContent' +
            count +
            '"><option disabled selected value>-- Cột cần tìm -- </option><option value="TenDVVC">TÊN ĐƠN VỊ VẬN CHYỂN</option><option value="TenVietTat">TÊN VIẾT TẮT</option><option value="DiaChi">ĐỊA CHỈ</option><option value="SDT">SỐ ĐIỆN THOẠI </option><option value="GhiChu">GHI CHÚ</option></select></div>'

        function addAfter(idNumber) {
            $('#searchForm').after(
                FormDanhMuc +
                '<label for="" style="float:left; padding-right:20px">Nội dung tìm</label><div class="col-md-4" style="width: 200px"><input class="form-control" type="text" placeholder="-- Nội dung tìm --"></div><div><a href=""><button class="btn btn-danger">X</button></a></div></div>'
            )
        };
        $('#AddSearch').click(function() {

            console.log(FormDanhMuc);
            if (count < 2) {

                addAfter();
                selectizeA();
                count++;
            }

        })
    </script>


@endsection
