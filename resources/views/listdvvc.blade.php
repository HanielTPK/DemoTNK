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
                <button type="button" class='btn btn-success' style="float: right; margin: 5px" id="Refresh">Tất cả</button>
                <button type="button" class='btn btn-success' style="float: right; margin: 5px" id="Search">Tìm
                    kiếm</button>



                <button type="button" class='btn btn-success' style="float: right;  margin: 5px" id="AddSearch">+</button>

            </div>

            <div style="width: 60%; margin:10px">
                <div style="float: right">
                    <span>Đến ngày</span>

                    <input onchange="onChangeDateTo()" value="" class="form-control" style=" " type="date" id="todate"><br>
                </div>
                <div style="float: right; ">
                    <span>Từ ngày</span>

                    <input onchange="onChangeDateFrom()" class="form-control" style="" type="date" id="fromdate">
                </div>

            </div>
            <div class="date-search" id="date-search" style="padding-left:20px">
                <select onchange="onChangeDateType()" name="datatype" id="datatype" class="form-control"
                    style="width: 20%">
                    <option value="Ngày tạo">Ngày tạo</option>
                    <option value="Ngày sửa">Ngày sửa</option>
                </select>
            </div>

        </div>
        <div class="" style="padding-top:20px;padding-bottom:40px;padding-left:20px; width:200px;">
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
                            TÊN VIẾT TẮT/<br>SỐ TK NH/<br>TK ĐĂNG NHẬP
                        </th>
                        <th>
                            SỐ ĐIỆN THOẠI/<BR> MỞ TẠI NGÂN HÀNG/<br> NGƯỜI DÙNG TK ĐĂNG NHẬP
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
        var countStorage = 0;
        loaddata();
        // Load History Fillter
        $("#fromdate").val(window.localStorage.getItem('DateFrom'));

        $("#todate").val(window.localStorage.getItem('DateTo'));

        $(document).ready(function() {
            $("#SearchInput0").val(window.localStorage.getItem('SearchInput0'));

            $("#SearchInput1").val(window.localStorage.getItem('SearchInput1'));

            $("#SearchInput2").val(window.localStorage.getItem('SearchInput2'));

            if (window.localStorage.getItem('DateType') != null) {
                $("#datatype").val(window.localStorage.getItem('DateType')).change();
            }

            if (window.localStorage.getItem('SearchContent0') != null) {
                $("#SearchContent0").val(window.localStorage.getItem('SearchContent0')).change();
            }

            if (window.localStorage.getItem('SearchContent1') != null) {
                $("#SearchContent1").val(window.localStorage.getItem('SearchContent1')).change();
            }

            if (window.localStorage.getItem('SearchContent2') != null) {
                $("#SearchContent2").val(window.localStorage.getItem('SearchContent2')).change();
            }
        })



        //Selecize
        $('#SearchContent').selectize({
            sortField: 'text'
        });





        //Add Selectize
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
        //Load DataTable
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
                            data: 'Sdt',
                            name: 'sdt'
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
        //Fill Data
        $('#Search').click(function() {
            var fromdate = $('#fromdate').val();
            var todate = $('#todate').val();
            var datetype = $('#datatype option:selected').text();
            var select = $('#SearchContent2   option:selected').val();
            var select0 = $('#SearchContent0 option:selected').val();
            var select1 = $('#SearchContent1 option:selected').val();
            var input = $('#SearchInput2').val();
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
        //Refresh data
        $('#Refresh').click(function() {
            location.reload();

            window.localStorage.clear()
        })

        function DanhMuc(idNumber) {
            var FormDanhMuc =
                '<div class="searchForm' + idNumber +
                '" id="searchForm' + idNumber +
                '" style="padding-top: 40px;size:20ch"><label style="float: left; padding-right:20px" for="topthem">Danh mục tìm</label><div style="width:200px;float: left; padding-right:20px"><select class="form-control" onchange="onChange' +
                idNumber + '()" id="SearchContent' +
                idNumber +
                '"><option disabled selected value>-- Cột cần tìm -- </option><option value="TenDVVC">TÊN ĐƠN VỊ VẬN CHYỂN</option><option value="TenVietTat">TÊN VIẾT TẮT</option><option value="DiaChi">ĐỊA CHỈ</option><option value="SDT">SỐ ĐIỆN THOẠI </option><option value="GhiChu">GHI CHÚ</option></select></div>'
            return FormDanhMuc;
        }

        function NoiDung(idNumber) {
            var FormNoiDung =
                '<label for="" style="float:left; padding-right:20px">Nội dung tìm</label><div class="col-md-4" style="width: 200px"><input onchange="onChangeInput' +
                idNumber + '()"  id="SearchInput' +
                idNumber + '" name="SearchInput' + idNumber +
                '" class="form-control" type="text" placeholder="-- Nội dung tìm --"></div><div><button  onclick="Delete' +
                idNumber + '()"  id="Delete' +
                idNumber + '" class="btn btn-danger">X</button></div></div>'
            return FormNoiDung
        }

        function addAfter(idNumber) {
            $('#date-search').after(
                DanhMuc(idNumber) +
                NoiDung(idNumber))
        };

        //Add fillter bar click event
        $('#AddSearch').click(function() {
            console.log($('#SearchInput2').val());
            var arrCheck = [0, 1, 2];
            if (count < 3) {
                console.log($("#SearchContent" + count).length);
                if ($("#SearchContent" + count).length == 0) {
                    addAfter(count);
                    selectizeA();
                    count++;
                } else {
                    arrCheck.forEach(element => {
                        if ($("#SearchContent" + element).length == 0) {
                            addAfter(element);
                            selectizeA();
                            count++;
                            return;
                        }
                    });
                }

            }
            window.localStorage.setItem('FillterCount', count);
        })

        //Add 1 Fillter bar
        function addFillterBar() {
            for (var i = 0; count < 3; count++) {}
            if (count < 3) {
                addAfter(count);
                selectizeA();
                count++;
            }
        }
        // Add fillter bar from localstorage
        console.log(parseInt(window.localStorage.getItem('FillterCount')));
        for (let index = 0; index < parseInt(window.localStorage.getItem('FillterCount')); index++) {
            if (index <= 3) {
                addAfter(index);
                selectizeA();
                count++;
            }

        }

        function Delete0() {
            count--;
            $('#searchForm0').remove();
            window.localStorage.setItem('FillterCount', count);
        }

        function Delete1() {
            count--;
            $('#searchForm1').remove();
            window.localStorage.setItem('FillterCount', count);
        }

        function Delete2() {
            count--;
            $('#searchForm2').remove();
            window.localStorage.setItem('FillterCount', count);
        }
        //Onchange fillterbar event
        function onChangeDateType() {

            window.localStorage.setItem('DateType', $('#date-search option:selected').text());

        }

        function onChangeDateFrom() {

            window.localStorage.setItem('DateFrom', $('#fromdate').val());

        }

        function onChangeDateTo() {

            window.localStorage.setItem('DateTo', $('#todate ').val());

        }

        function onChange0() {

            window.localStorage.setItem('SearchContent0', $('#SearchContent0 option:selected').val());

        }

        function onChange0() {

            window.localStorage.setItem('SearchContent0', $('#SearchContent0 option:selected').val());

        }

        function onChange1() {

            window.localStorage.setItem('SearchContent1', $('#SearchContent1 option:selected').val());

        }

        function onChange2() {

            window.localStorage.setItem('SearchContent2', $('#SearchContent2 option:selected').val());

        }

        function onChangeInput0() {

            window.localStorage.setItem('SearchInput0', $('#SearchInput0').val());

        }

        function onChangeInput1() {

            window.localStorage.setItem('SearchInput1', $('#SearchInput1').val());

        }

        function onChangeInput2() {

            window.localStorage.setItem('SearchInput2', $('#SearchInput2').val());

        }
    </script>


@endsection
