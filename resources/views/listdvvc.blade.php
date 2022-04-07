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
        <div style="height: 50%">
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
                <select name="datatype" id="datatype" class="form-control" style="width: 20%">
                    <option value="Ngày tạo">Ngày tạo</option>
                    <option value="Ngày sửa">Ngày sửa</option>
                </select>
            </div>
            <div class="" id="searchform" style="padding-top: 40px;size:20ch">
                <label style="float: left; padding-right:20px" for="topthem">Danh mục tìm</label>
                <div style="width:200px;float: left; padding-right:20px">
                    <select class="form-control" name="SearchContent" id="SearchContent">
                        <option disabled selected value> -- Cột cần tìm -- </option>
                        <option value="TenDVVC">TÊN ĐƠN VỊ VẬN CHYỂN</option>
                        <option value="TenVietTat">TÊN VIẾT TẮT</option>
                        <option value="DiaChi">ĐỊA CHỈ</option>
                        <option value="Sdt">SỐ ĐIỆN THOẠI </option>
                        <option value="GhiChu">GHI CHÚ</option>
                    </select>
                </div>
                <label for="" style="float:left; padding-right:20px">Nội dung tìm</label>

                <div class="col-md-4" style="width: 200px">
                    <input id="SearchInput" name="SearchInput" class="form-control" type="text"
                        placeholder="-- Nội dung tìm --">
                </div>
                <div style="">
                    <button onclick="return $('#searchForm').remove();" id="Delete" class="btn btn-danger">X</button>
                </div>
            </div>
        </div>
        <div class="" style="padding-bottom:40px; width:200px;">
            <a href="{{ route('themdvvcG') }}"> <button type="submit" class='btn btn-success'
                    style="float:left; padding-top:10px" id="Refresh">+ Thêm mới</button></a>
        </div>
        <div style="height: 100%; margin:20px">
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
        $('#SearchContent').selectize({
            sortField: 'text'
        });


        function selectizeA() {
            $(document).ready(function() {
                $('#SearchContent').selectize({
                    sortField: 'text'
                });
            });
            $(document).ready(function() {
                $('#SearchContent0').selectize({
                    sortField: 'text'
                });
            });
            $(document).ready(function() {
                $('#SearchContent1').selectize({
                    sortField: 'text'
                });
            });


        }

        function loaddata(from_date = ' ', to_date = ' ', date_type = ' ', search_select = ' ', search_select0 =
            ' ',
            search_select1 = ' ', search_input = ' ', search_input0 = ' ', search_input1 = ' ') {
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
                            todate: to_date,
                            datetype: date_type,
                            searchselect: search_select,
                            searchselect0: search_select0,
                            searchselect1: search_select1,
                            searchinput: search_input,
                            searchinput0: search_input0,
                            searchinput1: search_input1,
                        },
                    },
                    columns: [{
                            data: 'id',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
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
                        },
                        {
                            data: 'DiaChi',
                            name: 'diachi'
                        },
                        {
                            data: 'TrangThaiDVVC',
                            name: 'trangthaidvvc'
                        },
                        {
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
            var datetype = $('#datatype option:selected').text();
            var select = $('#SearchContent   option:selected').val();
            var select0 = $('#SearchContent0 option:selected').val();
            var select1 = $('#SearchContent1 option:selected').val();
            var input = $('#SearchInput').val();
            var input0 = $('#SearchInput0').val();
            var input1 = $('#SearchInput1').val();
            console.log(select);

            console.log(input);

            $('#table').DataTable().destroy();
            loaddata(from_date = fromdate, to_date = todate, date_type = datetype, search_select =
                select,
                search_select0 = select0, search_select1 = select1, search_input = input,
                search_input0 = input0,
                search_input1 = input1);
        })

        $('#Refresh').click(function() {

            console.log(fromdate);
            $('#table').DataTable().destroy();
            loaddata(from_date = " ", to_date = " ");
        })

        function DanhMuc(idNumber) {
            var FormDanhMuc =
                '<div class="searchForm' + idNumber +
                '" id="searchForm' + idNumber +
                '" style="padding-top: 40px;size:20ch"><label style="float: left; padding-right:20px" for="topthem">Danh mục tìm</label><div style="width:200px;float: left; padding-right:20px"><select class="form-control" id="SearchContent' +
                idNumber +
                '"><option disabled selected value>-- Cột cần tìm -- </option><option value="TenDVVC">TÊN ĐƠN VỊ VẬN CHYỂN</option><option value="TenVietTat">TÊN VIẾT TẮT</option><option value="DiaChi">ĐỊA CHỈ</option><option value="SDT">SỐ ĐIỆN THOẠI </option><option value="GhiChu">GHI CHÚ</option></select></div>'
            return FormDanhMuc;
        }

        function NoiDung(idNumber) {
            var FormNoiDung =
                '<label for="" style="float:left; padding-right:20px">Nội dung tìm</label><div class="col-md-4" style="width: 200px"><input id="SearchInput' +
                idNumber + '" name="SearchInput' + idNumber +
                '" class="form-control" type="text" placeholder="-- Nội dung tìm --"></div><div><button  onclick="Delete' +
                idNumber + '()"  id="Delete' +
                idNumber + '" class="btn btn-danger">X</button></div></div>'
            return FormNoiDung
        }

        function addAfter(idNumber) {
            $('#searchform').after(
                DanhMuc(idNumber) +
                NoiDung(idNumber))
        };
        $('#AddSearch').click(function() {
            if (count < 2) {
                addAfter(count);
                selectizeA();
                count++;
            }
        })



        function Delete() {
            count--;
            $('#searchForm').remove();
        }

        function Delete0() {
            count--;
            $('#searchForm0').remove();
        }

        function Delete1() {
            count--;
            $('#searchForm1').remove();
        }
    </script>


@endsection
