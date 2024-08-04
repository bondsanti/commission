@extends('layouts.loged')
@section('title', 'รายชื่อสมัคร Agent')
@push('css')
    <!-- เพิ่มไฟล์ CSS และ JavaScript ของ Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
@endpush
@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-10">

                <div class="card">
                    <div class="card-header">Detail</div>
                    <div class="card-body">
                        <div class="modal-body">
                            <form action="{{ route('regis.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">ชื่อ - นามสกุล
                                        :</label>
                                    <input type="text" class="form-control" name="name_th" value="{{ $member->name_th }}"
                                        autocomplete="off">
                                    <input type="hidden" class="form-control" name="code" value="{{ $member->code }}"
                                        autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Name - Surname
                                        :</label>
                                    <input type="text" class="form-control" name="name_eng"
                                        value="{{ $member->name_eng }}"autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">เบอร์
                                        :</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ $member->phone }}"autocomplete="off">
                                </div>
                                <div class="form-group">

                                    <label for="lineID" class="col-form-label">LineID :</label>
                                    <input type="text" class="form-control" name="lineid" value="{{ $member->lineid }}"
                                        autocomplete="off">


                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">อีเมล์
                                        :</label>
                                    <input type="text" class="form-control" name="email"
                                        value="{{ $member->email }}"autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">เลขบัตรประชาชน :</label>
                                    <input type="text" class="form-control" name="idcard" value="{{ $member->idcard }}"
                                        maxlength="13" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">ที่อยู่:</label>
                                    <textarea class="form-control" name="address">{{ $member->address }}</textarea>
                                </div>
                                <div class="form-group">

                                    <label for="province_id" class="col-form-label">จังหวัด
                                        :</label>
                                    <select name="province_id" id="input_province" class="form-control">

                                        @foreach ($provinces as $item)
                                            <option value="{{ $item->province_id }}"
                                                {{ $item->province_id == $member->province_id ? 'selected' : '' }}>
                                                {{ $item->province }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="amphur_id" class="col-form-label">อำเภอ
                                        :</label>
                                    <select name="amphur_id" id="input_amphoe" class="form-control">

                                        @foreach ($amphoes as $amphure)
                                            <option value="{{ $amphure->amphoe_id }}"
                                                {{ $amphure->amphoe_id == $member->amphur_id ? 'selected' : '' }}>
                                                {{ $amphure->amphoe }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="form-group">
                                    <label for="district_id" class="col-form-label">ตำบล
                                        :</label>
                                    <select name="district_id" id="input_tambon"class="form-control">

                                        @foreach ($tambons as $district)
                                            <option value="{{ $district->tambon_id }}"
                                                {{ $district->tambon_id == $member->district_id ? 'selected' : '' }}>
                                                {{ $district->tambon }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="idcard" class="col-form-label">รหัสไปรษณี
                                        :</label>
                                    <input class="form-control" name="postcode" id="input_zipcode" autocomplete="off"
                                        value="{{ $member->postcode }}">
                                    {{-- <input class="form-control" class="form-control" name="postcode" id="input_zipcode"
                                        value="{{ $member->postcode }}" autocomplete="off"> --}}
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">ธนาคาร
                                        :</label>
                                    <select name="bank_name" id="" class="form-control">
                                        <option value="ธนาคาร กรุงเทพ"
                                            {{ 'ธนาคาร กรุงเทพ' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร กรุงเทพ</option>
                                        <option value="ธนาคาร กสิกรไทย"
                                            {{ 'ธนาคาร กสิกรไทย' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร กสิกรไทย</option>
                                        <option value="ธนาคาร กรุงไทย"
                                            {{ 'ธนาคาร กรุงไทย' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร กรุงไทย</option>
                                        <option value="ธนาคาร ไทยพาณิชย์"
                                            {{ 'ธนาคาร ไทยพาณิชย์' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร ไทยพาณิชย์</option>
                                        <option value="ธนาคาร ทหารไทยธนชาต"
                                            {{ 'ธนาคาร ทหารไทยธนชาต' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร ทหารไทยธนชาต</option>
                                        <option value="ธนาคาร กรุงศรีอยุธยา"
                                            {{ 'ธนาคาร กรุงศรีอยุธยา' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร กรุงศรีอยุธยา</option>
                                        <option value="ธนาคาร เกียรตินาคินภัทร"
                                            {{ 'ธนาคาร เกียรตินาคินภัทร' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร เกียรตินาคินภัทร</option>
                                        <option value="ธนาคาร UOB"
                                            {{ 'ธนาคาร UOB' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร UOB</option>
                                        <option value="ธนาคาร ออมสิน"
                                            {{ 'ธนาคาร ออมสิน' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร ออมสิน</option>
                                        <option value="ธนาคาร ธกส."
                                            {{ 'ธนาคาร ธกส.' == $member->bank_name ? 'selected' : '' }}>
                                            ธนาคาร ธกส.</option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">เลขบัญชี
                                        :</label>
                                    <input type="text" class="form-control" name="bank_account"
                                        value="{{ $member->bank_account }}" autocomplete="off">
                                </div>
                                @if ($member->regis_type == 'บุคคลธรรมดา')
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">เอกสารสำเนาบัตรประชาชน
                                            :</label>
                                        @if ($member->file_register)
                                            <a class="btn btn-primary fancybox" data-type="iframe"
                                                href="{{ $member->file_register }}" target="_blank"
                                                role="button">ดูเอกสาร</a>
                                        @else
                                            <input type="file" name="file_register" id="file_register">
                                        @endif

                                    </div>
                                @endif
                                @if ($member->regis_type == 'นิติบุคคล')
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">เอกสารสำเนาบัตรประชาชน
                                            :</label>
                                        @if ($member->file_register)
                                            <a class="btn btn-primary fancybox" data-type="iframe"
                                                href="{{ $member->file_register }}" target="_blank"
                                                role="button">ดูเอกสาร</a>
                                        @else
                                            <input type="file" name="file_register" id="file_register">
                                        @endif

                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">เอกสารจดทะเบียนนิติบุคคล
                                            :</label>
                                        @if ($member->file_legal)
                                            <a class="btn btn-primary fancybox" data-type="iframe"
                                                href="{{ $member->file_legal }}" target="_blank"
                                                role="button">ดูเอกสาร</a>
                                        @else
                                            <input type="file" name="file_legal" id="file_legal">
                                        @endif
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">เอกสารสัญญา :</label>
                                    @if ($member->file_contract)
                                        <a class="btn btn-primary fancybox" data-type="iframe"
                                            href="{{ $member->file_contract }}" target="_blank"
                                            role="button">ดูเอกสาร</a>
                                    @else
                                        <input type="file" name="file_contract" id="file_contract">
                                    @endif
                                </div>
                                <div class="modal-footer justify-content-center">

                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                <input type="hidden" class="form-control" name="id" value="{{ $member->id }}"
                                    autocomplete="off">
                            </form>

                        </div>

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
@endpush
