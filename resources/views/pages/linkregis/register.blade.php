<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
        href="{{ asset('fonts/material-design-iconic-font/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .text-danger {
            color: red
        }

        /* จัดรูปแบบสำหรับปุ่มเปลี่ยนภาษา */
        .language-switcher {
            position: relative;
            display: inline-block;
        }

        .lang-dropdown-button {
            background-color: orange;
            /* สีส้มสำหรับปุ่ม */
            color: white;
            padding: 10px;
            width: 50px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            /* สี่เหลี่ยมมน */
        }

        /* จัดรูปแบบสำหรับเนื้อหา dropdown */
        .lang-dropdown-content {
            display: none;
            position: absolute;
            background-color: orange;
            /* สีส้มสำหรับเมนู dropdown */
            min-width: 50px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .lang-dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        /* แสดงเมนู dropdown เมื่อปุ่มถูกคลิก */
        .lang-dropdown-button:focus+.lang-dropdown-content {
            display: block;
        }

        /* จัดรูปแบบสำหรับลิงก์เมื่อ mouse over */
        .lang-dropdown-content a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>

    </script>
    <title>Register</title>
</head>

<body>
    <div class="wrapper" style="background-image: url('{{ asset('/images/register2.jpg') }}')">


        <div class="inner">

            {{-- <div class="language-switcher text-right">
                <button id="lang-dropdown" class="lang-dropdown-button">EN</button>
                <div id="lang-dropdown-content" class="lang-dropdown-content">
                    <a href="#" data-lang="en">EN</a>
                    <a href="#" data-lang="th">TH</a>
                </div>
            </div> --}}

            <form action="{{ route('regis.registeam') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h3>Registration Form
                    <!-- ตัวเลือกเปลี่ยนภาษา -->

                </h3>

                <div class="form-group">
                    <div class="form-wrapper">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            value="บุคคลธรรมดา" checked
                            {{ old('inlineRadioOptions') == 'บุคคลธรรมดา' ? 'checked' : '' }}>
                        <label class="form-check-label" for="inlineRadio1">บุคคลธรรมดา</label>

                    </div>
                    <div class="form-wrapper">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            value="นิติบุคคล">
                        <label class="form-check-label" for="inlineRadio2"
                            {{ old('inlineRadioOptions') == 'นิติบุคคล' ? 'checked' : '' }}>นิติบุคคล</label>
                    </div>
                    <div class="form-wrapper">
                        <label for="code">รหัสผู้แนะนำ</label>
                        <input type="text" name="id" value="{{ $users->id }}" class="form-control text-red"
                            readonly>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-wrapper">
                        <label for=""><span class="text-danger">*</span> ชื่อ - นามสกุล</label>
                        <input type="text" class="form-control" name="name_th" value="{{ old('name_th') }}"
                            autocomplete="off">
                        <small class="text-danger mt-1">
                            @error('name_th')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                    <div class="form-wrapper">
                        <label for=""><span class="text-danger">*</span> Name - Surname</label>
                        <input type="name_eng" class="form-control" name="name_eng" value="{{ old('name_eng') }}"
                            autocomplete="off">
                        <small class="text-danger mt-1">
                            @error('name_eng')
                                {{ $message }}
                            @enderror
                        </small>
                    </div>
                </div>
                <div class="form-wrapper">
                    <label for=""><span class="text-danger">*</span> iD Card number</label>
                    <input type="text" class="form-control" name="idcard" value="{{ old('idcard') }}"
                        maxlength="13" autocomplete="off" oninput="validateIdCard(this)">
                    <small class="text-danger mt-1">
                        @error('idcard')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for=""><span class="text-danger">*</span> Email</label>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                        autocomplete="off">
                    <span class="text-danger"> กรุณากรอก Email ที่สามารถใช้งานได้
                        เนื่องจากระบบจะส่งข้อมูลการเข้าใช้งานระบบไปยัง Email ของผู้สมัคร</span>
                    <br>
                    <small class="text-danger mt-1">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for=""><span class="text-danger">*</span> Tel</label>
                    <input type="number" class="form-control" name="phone" value="{{ old('phone') }}"
                        maxlength="10" autocomplete="off" oninput="validatePhoneNumber(this)">
                    <small class="text-danger mt-1">
                        @error('phone')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">

                    <label for=""><span class="text-danger">*</span> Line ID</label>
                    <input type="test" class="form-control" name="lineid" value="{{ old('lineid') }}"
                        autocomplete="off">
                    <small class="text-danger mt-1">
                        @error('lineid')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for=""><span class="text-danger">*</span> Address</label>
                    <input type="address" class="form-control" name="address" value="{{ old('address') }}"
                        autocomplete="off">
                    <small class="text-danger mt-1">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="province_id"><span class="text-danger">*</span> จังหวัด</label>
                    <select id="input_province" name="province_id" class="form-select">
                        <option value="">กรุณาเลือกจังหวัด</option>
                        @foreach ($provinces as $item)
                            <option value="{{ $item->province_id }}">{{ $item->province }}</option>
                        @endforeach
                    </select>
                    {{-- <select name="province_id" id="provinceSelect" class="form-select">
                        <option value="">เลือกจังหวัด</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->province_id }}">{{ $province->province_name }}</option>
                        @endforeach
                    </select> --}}
                    <small class="text-danger mt-1">
                        @error('province_id')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="amphur_id"><span class="text-danger">*</span> อำเภอ</label>
                    <select name="amphur_id" id="input_amphoe" class="form-select">
                        <option value="">กรุณาเลือกเขต/อำเภอ</option>
                        @foreach ($amphoes as $item)
                            <option value="{{ $item->amphoe_id }}">{{ $item->amphoe }}</option>
                        @endforeach
                    </select>
                    {{-- <select name="amphur_id" id="amphureSelect" class="form-select">
                        <option value="">เลือกอำเภอ</option>
                    </select> --}}
                    <small class="text-danger mt-1">
                        @error('amphur_id')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="district_id"><span class="text-danger">*</span> ตำบล/แขวง</label>
                    <select name="district_id" id="input_tambon" class="form-select">
                        <option value="">กรุณาเลือกแขวง/ตำบล</option>
                        @foreach ($tambons as $item)
                            <option value="{{ $item->tambon_id }}">{{ $item->tambon }}</option>
                        @endforeach
                    </select>
                    {{-- <select name="district_id" id="districtSelect" class="form-select">
                        <option value="">เลือกตำบล/แขวง</option>
                    </select> --}}
                    <small class="text-danger mt-1">
                        @error('district_id')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="idcard"><span class="text-danger">*</span> รหัสไปรษณีย์</label>
                    <input class="form-control" name="postcode" id="input_zipcode" autocomplete="off">
                    {{-- <input type="text" class="form-control" name="postcode" value="{{ old('postcode') }}"
                        autocomplete="off"> --}}
                    {{-- <small class="text-danger mt-1">
                        @error('postcode')
                            {{ $message }}
                        @enderror
                    </small> --}}
                </div>
                <div class="form-wrapper">
                    <label for="bank_name"><span class="text-danger">*</span> Bank</label>
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
                    <small class="text-danger mt-1">
                        @error('bank_name')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="address"><span class="text-danger">*</span> เลขบัญชี</label>
                    <input type="number" class="form-control" name="bank_account"
                        value="{{ old('bank_account') }}" autocomplete="off">
                    <small class="text-danger mt-1">
                        @error('bank_account')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper">
                    <label for="address"><span class="text-danger">*</span> เอกสารสำเนาบัตรประชาชน</label>
                    <input type="file" id="file_register" name="file_register">
                    <small class="text-danger mt-1">
                        @error('file_register')
                            {{ $message }}
                        @enderror
                    </small>
                </div>
                <div class="form-wrapper" id="legalEntityDocs" style="display: none;">
                    <label for="legalDocs"><span class="text-danger">*</span> เอกสารการจดทะเบียนนิติบุคคล</label>
                    <input class="" type="file" id="file_legal" name="file_legal">
                    <small class="text-danger mt-1" id="fileLegalError">
                        <!-- Display validation errors here -->
                    </small>
                </div>
                <button type="submit">Register Now</button>
            </form>

        </div>
    </div>
</body>



</html>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
<script>
        function validateIdCard(input) {
            const value = input.value;
            // ตรวจสอบว่าความยาวเท่ากับ 13 และเป็นตัวเลขเท่านั้น
            if (value.length === 13 && /^[0-9]+$/.test(value)) {
                input.setCustomValidity('');
            } else {
                input.setCustomValidity('กรุณากรอกเลขบัตรประชาชน 13 ตัวเลข');
            }
        }
</script>

<script>
    function validatePhoneNumber(input) {
        const value = input.value;
        // ตรวจสอบว่าความยาวเท่ากับ 10 และเป็นตัวเลขเท่านั้น
        if (value.length === 10 && /^[0-9]+$/.test(value)) {
            input.setCustomValidity('');
        } else {
            input.setCustomValidity('กรุณากรอกเบอร์โทรศัพท์ 10 ตัวเลข');
        }
    }
</script>
<script>
    const radioOption1 = document.getElementById('inlineRadio1');
    const radioOption2 = document.getElementById('inlineRadio2');
    const legalEntityDocs = document.getElementById('legalEntityDocs');
    const fileLegalError = document.getElementById('fileLegalError');
    const file_register = document.getElementById('file_register');
    const file_legal = document.getElementById('file_legal');

    radioOption1.addEventListener('change', function() {
        if (radioOption1.checked) {
            legalEntityDocs.style.display = 'none';
            fileLegalError.innerText = '';
            file_register.required = true;
            file_legal.required = false;
        }
    });

    radioOption2.addEventListener('change', function() {
        if (radioOption2.checked) {
            legalEntityDocs.style.display = 'block';
            fileLegalError.innerText = 'The file register field is required.';
            file_register.required = false;
            file_legal.required = true;
        }
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
