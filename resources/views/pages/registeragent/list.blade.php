@extends('layouts.loged')
@section('title', 'รายชื่อสมัคร Agent')
@push('css')
    <!-- เพิ่มไฟล์ CSS และ JavaScript ของ Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
    <!-- CSS CDN for DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.10/css/jquery.dataTables.min.css">
    <!-- jQuery CDN (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- JavaScript CDN for DataTables -->
    <script src="https://cdn.datatables.net/1.11.10/js/jquery.dataTables.min.js"></script>
    <style>
        .pointer {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">รายชื่อสมัคร Agent </div>
                    <div class="card-body">
                        <table id="tb1" class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th width="1%">No.</th>
                                    <th class="text-center">ประเภท</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th class="text-center">เอกสารแนบ</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">วันที่สมัคร</th>
                                    <th width="5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $member->regis_type }}</td>
                                        <td>{{ $member->name_th }}</td>
                                        <td>@if ($member->file_register )
                                            <img class="pointer" src="{{ asset('images/card_user.svg')}}" alt="ไฟล์บัตรประชาชน" width="25px"  data-toggle="tooltip" data-placement="top" title="ไฟล์บัตรประชาชน">
                                            @endif
                                            @if ($member->file_legal)
                                            <img class="pointer" src="{{ asset('images/niti.svg')}}" alt="ไฟล์นิติบุคคล" width="25px" data-toggle="tooltip" data-placement="top" title="ไฟล์นิติบุคคล">
                                            @endif
                                            @if ($member->file_contract)
                                            <img class="pointer" src="{{ asset('images/contract.svg')}}" alt="ไฟล์สัญญา" width="25px" data-toggle="tooltip" data-placement="top" title="ไฟล์สัญญา">
                                            @endif
                                        </td>
                                        <td>{{ $member->status == 0 ? 'Pending' : 'Appove' }}</td>

                                        <td>{{ $member->created_at }}</td>

                                        <td>
                                            <div class="dropdown">
                                                <i class="dropdown-toggle fas fa-ellipsis-h pointer-cursor" type="button"
                                                    data-toggle="dropdown" aria-expanded="false">

                                                </i>
                                                <div class="dropdown-menu">
                                                    {{-- <a href="" class="dropdown-item" data-toggle="modal"
                                                        data-target="#detailModal{{$member->id}}">Detail</a> --}}
                                                    <a href="{{ route('regis.edit', ['id' => $member->id]) }}"
                                                        class="dropdown-item">Detail</a>

                                                    @if ($member->status == 0)
                                                        <a href="" class="dropdown-item" data-toggle="modal"
                                                            data-target="#appoveModal{{ $member->id }}">Appove</a>

                                                        <a href="" class="dropdown-item" data-toggle="modal"
                                                            data-target="#rejectModal{{ $member->id }}">Reject</a>

                                                        <div class="dropdown-divider"></div>

                                                        {{ Form::open(['route' => ['regis.del', $member->id], 'method' => 'delete']) }}
                                                        {{ Form::submit('Remove', ['class' => 'dropdown-item']) }}
                                                        {{ Form::close() }}
                                                    @endif
                                                </div>
                                            </div>

                                        </td>

                                    </tr>
                                    <!-- Modal -->
                                    {{-- <div class="modal fade" id="detailModal{{$member->id}}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel">รายละเอียด</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('regis.update')}}" method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ชื่อสกุล TH :</label>
                                                                <input type="text" class="form-control" name="name_th" value="{{$member->name_th}}"  autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ชื่อ-สกุล ENG :</label>
                                                                <input type="text" class="form-control" name="name_eng" value="{{$member->name_eng}}"autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เบอร์ :</label>
                                                                <input type="text" class="form-control" name="phone" value="{{$member->phone}}"autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">อีเมล์ :</label>
                                                                <input type="text" class="form-control" name="email" value="{{$member->email}}"autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เลขบัตรประชาชน :</label>
                                                                <input type="text" class="form-control" name="idcard" value="{{$member->idcard}}" maxlength="13" autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">จังหวัด :</label>
                                                                <select name="province_id" id="provinceSelect" class="form-control">

                                                                    @foreach ($provinces as $province)
                                                                    <option value="{{ $province->province_id }}" {{ $province->province_id == $member->province_id ? 'selected' : '' }}>
                                                                        {{ $province->province_name }}
                                                                    </option>
                                                                    @endforeach                                                              
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">อำเภอ :</label>
                                                                <select name="amphur_id" id="amphureSelect" class="form-control">

                                                                    @foreach ($amphures as $amphure)
                                                                    <option value="{{ $amphure->amphur_id }}" {{ $amphure->amphur_id == $member->amphur_id ? 'selected' : '' }}>
                                                                        {{ $amphure->amphur_name }}
                                                                    </option>
                                                                    @endforeach                                                              
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ตำบล :</label>
                                                                <select name="district_id" id="districtSelect"class="form-control">

                                                                    @foreach ($districts as $district)
                                                                    <option value="{{ $district->district_id }}" {{ $district->district_id == $member->district_id ? 'selected' : '' }}>
                                                                        {{ $district->district_name }}
                                                                    </option>
                                                                    @endforeach                                                              
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="message-text" class="col-form-label">ที่อยู่:</label>
                                                                <textarea class="form-control" name="address">{{$member->address}}</textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">รหัสไปรษณี :</label>
                                                                <input type="text" class="form-control" name="postcode" value="{{$member->postcode}}" autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">ธนาคาร :</label>
                                                                <select name="bank_name" id="" class="form-control">
                                                                    <option value="ธนาคาร กรุงเทพ" {{ "ธนาคาร กรุงเทพ" == $member->bank_name ? 'selected' : '' }}>ธนาคาร กรุงเทพ</option>
                                                                    <option value="ธนาคาร กสิกรไทย" {{ "ธนาคาร กสิกรไทย" == $member->bank_name ? 'selected' : '' }}>ธนาคาร กสิกรไทย</option>
                                                                    <option value="ธนาคาร กรุงไทย" {{ "ธนาคาร กรุงไทย" == $member->bank_name ? 'selected' : '' }}>ธนาคาร กรุงไทย</option>
                                                                    <option value="ธนาคาร ไทยพาณิชย์" {{ "ธนาคาร ไทยพาณิชย์" == $member->bank_name ? 'selected' : '' }}>ธนาคาร ไทยพาณิชย์</option>
                                                                    <option value="ธนาคาร ทหารไทยธนชาต" {{ "ธนาคาร ทหารไทยธนชาต" == $member->bank_name ? 'selected' : '' }}>ธนาคาร ทหารไทยธนชาต</option>
                                                                    <option value="ธนาคาร กรุงศรีอยุธยา" {{ "ธนาคาร กรุงศรีอยุธยา" == $member->bank_name ? 'selected' : '' }}>ธนาคาร กรุงศรีอยุธยา</option>
                                                                    <option value="ธนาคาร เกียรตินาคินภัทร" {{ "ธนาคาร เกียรตินาคินภัทร" == $member->bank_name ? 'selected' : '' }}>ธนาคาร เกียรตินาคินภัทร</option>
                                
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เลขบัญชี :</label>
                                                                <input type="text" class="form-control" name="bank_account" value="{{$member->bank_account}}" autocomplete="off">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เอกสารสำเนาบัตรประชาชน :</label>
                                                                @if ($member->file_register)
                                                                <a class="btn btn-primary" href="{{$member->file_register}}" role="button" target="_blank">ดูเอกสาร</a> 
                                                                <a class="btn btn-primary fancybox"data-type="iframe" href="{{$member->file_register}}" role="button">ดูเอกสาร</a> 
                                                                @endif
                                                               
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เอกสารจดทะเบียนนิติบุคคล :</label>
                                                                @if ($member->file_legal)
                                                                <a class="btn btn-primary" href="{{$member->file_legal}}" role="button" target="_blank">ดูเอกสาร</a> 
                                                                @endif
                                                            </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="id" value="{{$member->id}}" autocomplete="off">
                                                </form>
                                                </div>
                                            </div>
                                        </div>   --}}
                                    @if ($member->status == 0)
                                        <div class="modal fade" id="appoveModal{{ $member->id }}" tabindex="-1"
                                            aria-labelledby="appoveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel">Appove
                                                            คุณ{{ $member->name_th }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('insert.agent') }}" method="post"
                                                            enctype="multipart/form-data" onsubmit="disableButton();">
                                                            @csrf
                                                    <div class="modal-body">
                                                        
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">เลือกทีม
                                                                    :</label>

                                                                <select name="team_id" id="team_id" class="form-control">
                                                                    @foreach ($teams as $team)
                                                                        <option value="{{ $team->id }}">
                                                                            {{ $team->name }}</option>
                                                                    @endforeach



                                                                </select>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            id="approveButton">Appove</button>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="id"
                                                        value="{{ $member->id }}" autocomplete="off">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="rejectModal{{ $member->id }}" tabindex="-1"
                                            aria-labelledby="appoveModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="detailModalLabel">Reject
                                                            คุณ{{ $member->name_th }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <form action="{{ route('regis.reject') }}" method="post"
                                                            enctype="multipart/form-data">
                                                            @csrf


                                                            <h3 class="text-danger"> คุณต้องการปฏิเสธใช่หรือไม่?</h3>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Reject</button>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="id"
                                                        value="{{ $member->id }}" autocomplete="off">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>






@endsection

@push('scripts')
    <!-- เพิ่มส่วนของ SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
        // ฟังก์ชันที่ใช้ปิดใช้งานปุ่ม
        function disableButton() {
            var approveButton = document.getElementById('approveButton');
            approveButton.disabled = true; // ปิดใช้งานปุ่ม
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#tb1').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".fancybox").fancybox();

        });
    </script>


    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                text: 'กรุณาลองใหม่',
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        </script>
    @endif
    <script>
        function showAmphoes() {
            let input_province = document.querySelector("#input_province");
            let url = "{{ url('/api/amphoes') }}?province_code=" + input_province.value;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    let input_amphoe = document.querySelector("#input_amphoe");
                    input_amphoe.innerHTML = '<option value="">กรุณาเลือกเขต/อำเภอ</option>';
                    for (let item of result) {
                        let option = document.createElement("option");
                        option.text = item.amphoe;
                        option.value = item.amphoe_code;
                        input_amphoe.appendChild(option);
                    }
                    showTambons();
                });
        }

        function showTambons() {
            let input_province = document.querySelector("#input_province");
            let input_amphoe = document.querySelector("#input_amphoe");
            let url = "{{ url('/api/tambons') }}?province_code=" + input_province.value + "&amphoe_code=" + input_amphoe
                .value;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    let input_tambon = document.querySelector("#input_tambon");
                    input_tambon.innerHTML = '<option value="">กรุณาเลือกแขวง/ตำบล</option>';
                    for (let item of result) {
                        let option = document.createElement("option");
                        option.text = item.tambon;
                        option.value = item.tambon_code;
                        input_tambon.appendChild(option);
                    }
                    showZipcode(); // เรียกใช้ showZipcode เมื่อมีการเลือกอำเภอและตำบลใหม่
                });
        }

        function showZipcode() {
            let input_province = document.querySelector("#input_province");
            let input_amphoe = document.querySelector("#input_amphoe");
            let input_tambon = document.querySelector("#input_tambon");
            let url = "{{ url('/api/zipcodes') }}?province_code=" + input_province.value + "&amphoe_code=" + input_amphoe
                .value +
                "&tambon_code=" + input_tambon.value;
            console.log(url);
            fetch(url)
                .then(response => response.json())
                .then(result => {
                    console.log(result);
                    let input_zipcode = document.querySelector("#input_zipcode");
                    input_zipcode.value = result[0].zipcode; // แสดง zipcode ที่ได้รับจาก API
                });
        }

        // EVENTS
        document.querySelector('#input_province').addEventListener('change', (event) => {
            showAmphoes();
        });
        document.querySelector('#input_amphoe').addEventListener('change', (event) => {
            showTambons();
        });
        document.querySelector('#input_tambon').addEventListener('change', (event) => {
            showZipcode();
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

         
            $('#provinceSelect').on('change', function() {
                var provinceId = $(this).val();
                //console.log(provinceId);
                if (provinceId) {
                    $.ajax({
                        url: '/get-amphures/' + provinceId,
                        type: 'GET',
                        success: function(data) {
                        //console.log(data.amphures.amphur_name);
                        var amphures = data.amphures;
                        var options = '<option value="">เลือกอำเภอ</option>';
                        for (let i = 0; i < amphures.length; i++) {
                            options += '<option value="' + amphures[i].amphur_id + '">' + amphures[i].amphur_name + '</option>';
                        }
                        $('#amphureSelect').html(options);
                        // $('#districtSelect').html('<option value="">เลือกตำบล</option>');
                        }
                    });
                }
            });
    
            $('#amphureSelect').on('change', function() {
                var amphureId = $(this).val();
                //console.log(amphureId);
                if (amphureId) {
                    $.ajax({
                        url: '/get-districts/' + amphureId,
                        type: 'GET',
                        success: function(data) {
                        //console.log(data.districts.district_name);
                        var districts = data.districts;
                        var options = '<option value="">เลือกตำบล</option>';
                        for (let i = 0; i < districts.length; i++) {
                            options += '<option value="' + districts[i].district_id + '">' + districts[i].district_name + '</option>';
                        }
                        $('#districtSelect').html(options);
                        // $('#districtSelect').html('<option value="">เลือกตำบล</option>');
                        }
                    });
                }
            });
        });
    </script> --}}
@endpush
