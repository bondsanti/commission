<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <title> Register </title>
    {{-- <link rel="icon" type="image/png" href="/images/favicon.png"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</head>

<body>

    <div class="container">
        <div class="row">

            <div class="col-sm-9 col-md-6 col-lg-6 mx-auto">
                <img class="rounded mx-auto d-block" src="{{ asset('/images/vbe.png') }}" alt="" width="280">
                <div class="card border-0 shadow rounded-3">

                    <div class="card-body p-4 p-sm-5">
                        <h3>Register</h3>

                        <form action="{{ route('regis.register') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio1" value="บุคคลธรรมดา" checked>
                                    <label class="form-check-label" for="inlineRadio1">บุคคลธรรมดา</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                        id="inlineRadio2" value="นิติบุคคล">
                                    <label class="form-check-label" for="inlineRadio2">นิติบุคคล</label>
                                </div>
                            </div>

                            <div class="form-floating mb-3">

                                <input type="text" class="form-control" name="idcard" value="{{ old('idcard') }}"
                                    maxlength="13" autocomplete="off">
                                <label for="idcard">iD Card number</label>
                                <small class="text-danger mt-1">
                                    @error('idcard')
                                        {{ $message }}
                                    @enderror
                                </small>

                            </div>

                            <div class="form-floating mb-3">

                                <input type="text" class="form-control" name="name_th" value="{{ old('name_th') }}"
                                    autocomplete="off">
                                <label for="name_th">ชื่อ - นามสกุล</label>
                                <small class="text-danger mt-1">
                                    @error('name_th')
                                        {{ $message }}
                                    @enderror
                                </small>

                            </div>

                            <div class="form-floating mb-3">
                                <input type="name_eng" class="form-control" name="name_eng"
                                    value="{{ old('name_eng') }}" autocomplete="off">
                                <label for="name_eng">Name - Surname</label>
                                <small class="text-danger mt-1">
                                    @error('name_eng')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    autocomplete="off">
                                <label for="email">Email</label>
                                <small class="text-danger mt-1">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="phone" class="form-control" name="phone" value="{{ old('phone') }}"
                                    maxlength="10" autocomplete="off">
                                <label for="phone">Tel</label>
                                <small class="text-danger mt-1">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">

                                <input type="text" class="form-control" name="lineid" value="{{ old('lineid') }}"
                                    autocomplete="off">
                                <label for="lineid">LineID</label>
                                <small class="text-danger mt-1">
                                    @error('lineid')

                                <small class="text-danger mt-1">
                     

                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7"></textarea>
                                <label for="address">Address</label>
                                <small class="text-danger mt-1">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <select id="input_province" name="province_id" class="form-select">
                                    <option value="">กรุณาเลือกจังหวัด</option>
                                    @foreach ($provinces as $item)
                                        <option value="{{ $item->province_id }}">{{ $item->province }}</option>
                                    @endforeach
                                </select>
                                <label for="province_id">Province</label>
                                <small class="text-danger mt-1">
                                    @error('province_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="amphur_id" id="input_amphoe" class="form-select">
                                    <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                    @foreach ($amphoes as $item)
                                        <option value="{{ $item->amphoe_id }}">{{ $item->amphoe }}</option>
                                    @endforeach
                                </select>
                                <label for="amphur_id">Amphur</label>
                                <small class="text-danger mt-1">
                                    @error('amphur_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="district_id" id="input_tambon" class="form-select">
                                    <option value="">กรุณาเลือกแขวง/ตำบล</option>
                                    @foreach ($tambons as $item)
                                        <option value="{{ $item->tambon_id }}">{{ $item->tambon }}</option>
                                    @endforeach
                                </select>
                                <label for="district_id">District</label>
                                <small class="text-danger mt-1">
                                    @error('district_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="postcode" id="input_zipcode" autocomplete="off">
                                <label for="idcard">รหัสไปรษณีย์</label>
                                <small class="text-danger mt-1">
                                    @error('postcode')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            {{-- <div class="form-floating mb-3">
                                <select name="province_id" id="provinceSelect" class="form-select">
                                    <option value="">เลือกจังหวัด</option>
                                    @foreach ($provinces as $province)
                                        <option value="{{ $province->province_id }}">{{ $province->province_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="province_id">Province</label>
                                <small class="text-danger mt-1">
                                    @error('province_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="amphur_id" id="amphureSelect" class="form-select">
                                    <option value="">เลือกอำเภอ</option>
                                </select>
                                <label for="amphur_id">Amphur</label>
                                <small class="text-danger mt-1">
                                    @error('amphur_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <select name="district_id" id="districtSelect" class="form-select">
                                    <option value="">เลือกตำบล</option>
                                </select>
                                <label for="district_id">District</label>
                                <small class="text-danger mt-1">
                                    @error('district_id')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" name="postcode" id="postcode" autocomplete="off">
                                <label for="idcard">รหัสไปรษณีย์</label>
                                <small class="text-danger mt-1">
                                    @error('postcode')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div> --}}
                            <div class="form-floating mb-3">
                                <select name="bank_name" id="" class="form-select">
                                    <option value="">เลือก ธนาคาร</option>
                                    <option value="ธนาคาร กรุงเทพ">ธนาคาร กรุงเทพ</option>
                                    <option value="ธนาคาร กสิกรไทย">ธนาคาร กสิกรไทย</option>
                                    <option value="ธนาคาร กรุงไทย">ธนาคาร กรุงไทย</option>
                                    <option value="ธนาคาร ไทยพาณิชย์">ธนาคาร ไทยพาณิชย์</option>
                                    <option value="ธนาคาร ทหารไทยธนชาต">ธนาคาร ทหารไทยธนชาต</option>
                                    <option value="ธนาคาร กรุงศรีอยุธยา">ธนาคาร กรุงศรีอยุธยา</option>
                                    <option value="ธนาคาร เกียรตินาคินภัทร">ธนาคาร เกียรตินาคินภัทร</option>
                                    <option value="ธนาคาร UOB">ธนาคาร UOB</option>
                                    <option value="ธนาคาร ออมสิน">ธนาคาร ออมสิน</option>
                                    <option value="ธนาคาร ธกส.">ธนาคาร ธกส.</option>
                                </select>
                                <label for="bank_name">Bank</label>
                                <small class="text-danger mt-1">
                                    @error('bank_name')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="bank_account"
                                    value="{{ old('bank_account') }}" autocomplete="off">
                                <label for="address">เลขบัญชี</label>
                                <small class="text-danger mt-1">
                                    @error('bank_account')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form mb-2">
                                <label for="address">เอกสารสำเนาบัตรประชาชน</label>
                                <input class="form-control" type="file" id="file_register" name="file_register"
                                    accept="image/*">

                                <small class="text-danger mt-1">
                                    @error('file_register')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="form mb-2" id="legalEntityDocs" style="display: none;">
                                <label for="legalDocs">เอกสารการจดทะเบียนนิติบุคคล</label>
                                <input class="form-control" type="file" id="file_legal" name="file_legal">
                                <small class="text-danger mt-1" id="fileLegalError">
                                    <!-- Display validation errors here -->
                                </small>
                            </div>
                            <br>
                            <div class="d-grid">
                                <button class="btn btn-login btn-rounded text-uppercase fw-bold"
                                    type="submit">Register</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </div>
</body>

</html>

<style>
    body {
        background: linear-gradient(to left, #facd93 10%, #f9ece0 100%);
    }

    .btn-login {

        background: linear-gradient(to right, #facd93, #f79b46);
        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+,
    Safari 7+ */
        color: #fff;
        /* border: 3px solid #eee; */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const radioOption2 = document.getElementById('inlineRadio2');
    const legalEntityDocs = document.getElementById('legalEntityDocs');
    const fileLegalError = document.getElementById('fileLegalError');
    const fileRegisterContainer = document.getElementById('fileRegisterContainer');

    radioOption2.addEventListener('change', function() {
        if (radioOption2.checked) {
            legalEntityDocs.style.display = 'block';
            fileLegalError.innerText = 'The file register field is required.';
            fileRegisterContainer.style.display = 'none';
            // fileLegal.required = true;
        } else {
            legalEntityDocs.style.display = 'none';
            fileLegalError.innerText = '';
            fileRegisterContainer.style.display = 'block';
            // fileLegal.required = false;
        }
    });
</script>

<script>
    function showAmphoes() {
        let input_province = document.querySelector("#input_province");
        let url = "{{ url('/api/amphoes') }}?province_id=" + input_province.value;
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
                    option.value = item.amphoe_id;
                    input_amphoe.appendChild(option);
                }
                showTambons();
            });
    }

    function showTambons() {
        let input_province = document.querySelector("#input_province");
        let input_amphoe = document.querySelector("#input_amphoe");
        let url = "{{ url('/api/tambons') }}?province_id=" + input_province.value + "&amphoe_id=" + input_amphoe
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
                    option.value = item.tambon_id;
                    input_tambon.appendChild(option);
                }
                showZipcode(); // เรียกใช้ showZipcode เมื่อมีการเลือกอำเภอและตำบลใหม่
            });
    }

    function showZipcode() {
        let input_province = document.querySelector("#input_province");
        let input_amphoe = document.querySelector("#input_amphoe");
        let input_tambon = document.querySelector("#input_tambon");
        let url = "{{ url('/api/zipcodes') }}?province_id=" + input_province.value + "&amphoe_id=" + input_amphoe
            .value +
            "&tambon_id=" + input_tambon.value;
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
                            options += '<option value="' + amphures[i].amphur_id + '">' +
                                amphures[i].amphur_name + '</option>';
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
                            options += '<option value="' + districts[i].district_id + '">' +
                                districts[i].district_name + '</option>';
                        }
                        $('#districtSelect').html(options);
                        // $('#districtSelect').html('<option value="">เลือกตำบล</option>');
                    }
                });
            }
        });

    });
</script> --}}

<!-- เพิ่มส่วนของ SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

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
        const homeRoute = '{{ route('home') }}';

        Swal.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            html: `
            <h5>โปรดรอเจ้าหน้าที่ติดต่อกลับภายในเวลา 1-2 วัน</h5>
            <h5>ขอบคุณค่ะ</h5>
        `,

            onClose: () => {
                // หน่วงเวลา 20 วินาทีก่อน redirect
                setTimeout(() => {
                    window.location.href = homeRoute;
                }, 20000);
            }
        }).then((result) => {
            if (result.dismiss !== Swal.DismissReason.cancel) {
                // Redirect to home page immediately
                window.location.href = homeRoute;
            }
        });
    </script>
@endif
