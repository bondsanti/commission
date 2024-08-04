@extends('layouts.loged')
@section('title', 'Add Sale')

@push('css')
    <link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
    <link href="/assets/plugins/ion-rangeslider/css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="/assets/plugins/ion-rangeslider/css/ion.rangeSlider.skinNice.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
    <link href="/assets/plugins/password-indicator/css/password-indicator.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-combobox/css/bootstrap-combobox.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
    <link href="/assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container">
        <div class="row ">
            <div class="col-lg-10 offset-1 ">
                {{ Form::open(['route' => ['users.store'], 'method' => 'post', 'files' => true]) }}
                {!! Form::hidden('sub_id', '0', ['id' => 'sub_id']) !!}
                <div class="tab-content shadow-sm" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div>

                            {{--  --}}
                            <div class="form-group row">
                                {{ Form::label('ประเภทบุคคล', 'ประเภทบุคคล :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                <select name="regis_type" id="regis_type" class="form-control col-md-7">
                                    <option value="">เลือก ประเภทบุคคล</option>
                                    @foreach ($member as $member)
                                        <option value="{{ $member->regis_type }}">
                                            {{ $member->regis_type }}
                                        </option>
                                    @endforeach


                                </select>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('ชื่อ - นามสกุล', 'ชื่อ - นามสกุล :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::input('text', 'name_th', '', ['class' => 'form-control col-md-7', 'required' => true, ' data-size' => '10', 'data-live-search' => 'true']) }}
                            </div>

                            <div class="form-group row">
                                {{ Form::label('Name - Surname', 'Name - Surname :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::input('text', 'name_eng', '', ['class' => 'form-control col-md-7']) }}
                            </div>

                            <div class="form-group row">
                                {{ Form::label('Email', 'Email', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::input('email', 'email', '', ['class' => 'form-control col-md-7']) }}
                            </div>

                            <div class="form-group row">
                                {{ Form::label('เบอร์โทรศัพท์', 'เบอร์โทรศัพท์', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::input('number', 'phone', '', ['class' => 'form-control col-md-7', 'minlength' => 10, 'maxlenght' => 10, 'required' => true, 'oninput' => 'validatePhoneNumber(this)']) }}
                            </div>
                            <div class="form-group row">
                                <label for="lineid" class="col-md-3 offset-md-1 col-form-label">LineID</label>
                                <input type="text" class="form-control col-md-7" name="lineid"
                                    value="{{ old('lineid') }}" autocomplete="off">
                            </div>
                            <div class="form-group row">
                                {{ Form::label('เลขบัตรประชาชน', 'เลขบัตรประชาชน', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::input('number', 'idcard', '', ['class' => 'form-control col-md-7', 'minlength' => 13, 'maxlenght' => 13, 'oninput' => 'validateIdCard(this)']) }}
                            </div>
                            <div class="form-group row">
                                {{ Form::label('Companies', 'Companies', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::select('company_id', $companies, '', ['class' => 'form-control col-md-7 selectpicker', 'data-size' => '10', 'data-live-search' => 'true']) }}
                            </div>

                            <div class="form-group row">
                                {{ Form::label('Type Agent', 'Type Agent', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::select('team_id', $teams, '', ['class' => 'form-control col-md-7 selectpicker', 'id' => 'team_id', 'data-size' => '10', 'data-live-search' => 'true']) }}
                            </div>
                            @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport')
                                <div class="form-group row">
                                    {{ Form::label('Team', 'Team', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                    <select name="agent_by" id="agent_by" class="form-control col-md-7 selectpicker"
                                        required>
                                        <option value="">Team</option>
                                        @foreach ($adminagents as $adminagent)
                                            <option value="{{ $adminagent->user_id }}">{{ $adminagent->name_th }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @elseif (Auth::user()->role()->name == 'AdminAgent')
                                <input name="agent_by" type="hidden" value="{{ Auth::user()->id }}">
                            @endif

                            @foreach ($subTeam as $key => $item)
                                <div class="form-group sub_team row d-none sub_team_{{ $key }}">
                                    {{ Form::label('sub team', 'sub team', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                    {{ Form::select('sub_team_id', $item, '0', ['class' => 'form-control col-md-7 selectpicker sub_team_id', 'id' => 'sub_team_id', 'data-size' => '10', 'data-live-search' => 'true']) }}
                                </div>
                            @endforeach
                            <div class="form-group row">
                                {{ Form::label('Position', 'Position', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::select('position_id', $roles, '', ['class' => 'form-control col-md-7 selectpicker', 'data-size' => '10', 'data-live-search' => 'true']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('ที่อยู่', 'ที่อยู่', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}

                            <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7"></textarea>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('จังหวัด', 'จังหวัด', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select id="input_province" name="province_id" class="form-control col-md-7">
                                <option value="">กรุณาเลือกจังหวัด</option>
                                @foreach ($provinces as $item)
                                    <option value="{{ $item->province_id }}">{{ $item->province }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('อำเภอ', 'อำเภอ', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="amphur_id" id="input_amphoe" class="form-control col-md-7">
                                <option value="">กรุณาเลือกเขต/อำเภอ</option>
                                @foreach ($amphoes as $item)
                                    <option value="{{ $item->amphoe_id }}">{{ $item->amphoe }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('ตำบล', 'ตำบล', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="district_id" id="input_tambon" class="form-control col-md-7">
                                <option value="">กรุณาเลือกแขวง/ตำบล</option>
                                @foreach ($tambons as $item)
                                    <option value="{{ $item->tambon_id }}">{{ $item->tambon }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            {{ Form::label('รหัสไปรษณีย์', 'รหัสไปรษณีย์', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <input class="form-control col-md-7" name="postcode" id="input_zipcode" autocomplete="off">
                        </div>
                        <div class="form-group row">
                            {{ Form::label('ธนาคาร', 'ธนาคาร', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="bank_name" id="" class="form-control col-md-7">
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
                        </div>
                        <div class="form-group row">
                            {{ Form::label('เลขบัญชี', 'เลขบัญชี', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('text', 'bank_account', '', ['class' => 'form-control col-md-7', 'minlength' => 10, 'maxlenght' => 10, 'required' => true, 'oninput' => 'validatePhoneNumber(this)']) }}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="recipient-name" class="col-md-3 offset-md-1 col-form-label">เอกสารสำเนาบัตรประชาชน
                            :</label>
                            <input type="file" name="file_register" id="file_register">
                    </div>
                    <div class="form-group row" id="legalEntityDocs"
                        style="{{ $member->regis_type == 'นิติบุคคล' ? '' : 'display: none;' }}">
                        <label for="recipient-name" class="col-md-3 offset-md-1 col-form-label">เอกสารจดทะเบียนนิติบุคคล
                            :</label>
                            <input type="file" name="file_legal" id="file_legal">
                    </div>
                    <div class="form-group row">
                        <label for="recipient-name" class="col-md-3 offset-md-1 col-form-label">เอกสารสัญญา
                            :</label>
                            <input type="file" name="file_contract" id="file_contract">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" row justify-content-center w-100">
        {{ Form::submit('Save', ['class' => 'btn btn-primary my-3 ', 'style' => 'width:100px;']) }}
    </div>
    </div>
    </div>
    {{ Form::close() }}
    </div>

@endsection


@push('scripts')
    <script src="/assets/plugins/jquery-migrate/jquery-migrate.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
    <script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="/assets/plugins/password-indicator/js/password-indicator.js"></script>
    <script src="/assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
    <script src="/assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/assets/plugins/tag-it/js/tag-it.min.js"></script>
    <script src="/assets/plugins/moment/moment.js"></script>
    <script src="/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/plugins/bootstrap-show-password/bootstrap-show-password.js"></script>
    <script src="/assets/plugins/bootstrap-colorpalette/js/bootstrap-colorpalette.js"></script>
    <script src="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.js"></script>
    <script src="/assets/plugins/clipboard/dist/clipboard.min.js"></script>
    <script src="/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

    <script src="/assets/js/demo/form-plugins.demo.js"></script>
    <script>
        document.getElementById('regis_type').addEventListener('change', function() {
            var legalEntityDocs = document.getElementById('legalEntityDocs');
            if (this.value === 'นิติบุคคล') {
                legalEntityDocs.style.display = 'block';
            } else {
                legalEntityDocs.style.display = 'none';
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
        function validatePostcode(input) {
            const value = input.value;
            if (value.length === 5 && /^[0-9]+$/.test(value)) {
                input.setCustomValidity('');
            } else {
                input.setCustomValidity('กรุณากรอกเลขไปรษณีย์ 5 ตัวเลข');
            }
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#team_id').change((e) => {
                let index = e.target.value - 1
                $(`.sub_team`).addClass('d-none')
                $(`.sub_team_${index}`).removeClass('d-none')
                // axios.get(`/api/users/teams/${e.target.value}`).then((res)=>{
                //     $('#sub_team_id').empty('')
                //     var text = '';
                //     for (let index = 0; index < res.data.length; index++) {

                //         text += `<option value="${res.data[index].id}">${res.data[index].name}</option>`;
                //     }
                //     $('#sub_team_id').append(text)
                // })
            })
            $('.sub_team_id').change(e => {
                $('#sub_id').val(e.target.value);
            })
            FormPlugins.init();
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
@endpush
