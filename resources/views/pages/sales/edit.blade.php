@extends('layouts.loged')
@section('title', 'แก้ไข')

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
    <!-- เพิ่มไฟล์ CSS และ JavaScript ของ Fancybox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
@endpush
@section('content')
    <div class="container">
        {{-- @php
    dd($sale->regis_type);
@endphp --}}

        <div class="row">
            {{ Form::model($sale, ['route' => ['users.update', $sale->id], 'method' => 'put', 'files' => true, 'class' => 'w-100']) }}
            {!! Form::hidden('sub_id', $sale->sub_team_id, ['id' => 'sub_id']) !!}

            <div class="col-lg-10 offset-1 ">

                <div class="tab-content shadow-sm" id="nav-tabContent">

                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


                        @include('pages.sales.card')

                        <div class="form-group row">
                            {{ Form::label('Code', 'Code', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::label('Code', $sale->code, ['class' => 'col-md-7  col-form-label pl-0']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('ประเภทบุคคล', 'ประเภทบุคคล :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="regis_type" id="regis_type" class="form-control col-md-7">
                                <option value="">เลือก ประเภทบุคคล</option>
                                @foreach ($member as $member)
                                    <option value="{{ $member->regis_type }}"
                                        {{ $member->regis_type == $sale->regis_type ? 'selected' : '' }}>
                                        {{ $member->regis_type }}
                                    </option>
                                @endforeach


                            </select>
                        </div>

                        <div class="form-group row">
                            {{ Form::label('ชื่อ - นามสกุล', 'ชื่อ - นามสกุล :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('text', 'name_th', $sale->name_th, ['class' => 'form-control col-md-7', 'required' => true, ' data-size' => '10', 'data-live-search' => 'true']) }}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('Name - Surname', 'Name - Surname :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('text', 'name_eng', $sale->name_eng, ['class' => 'form-control col-md-7']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('เบอร์', 'เบอร์ :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('tel', 'phone', $sale->phone, ['class' => 'form-control col-md-7', 'minlength' => 10, 'maxlenght' => 10, 'required' => true, 'oninput' => 'validatePhoneNumber(this)']) }}
                        </div>
                        <div class="form-group row">
                            <label for="lineid" class="col-md-3 offset-md-1 col-form-label">LineID :</label>
                            <input type="text" class="form-control col-md-7" name="lineid" value="{{ $sale->lineid }}"
                                autocomplete="off">
                        </div>
                        <div class="form-group row">
                            {{ Form::label('Email', 'Email :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('email', 'email', $sale->email, ['class' => 'form-control col-md-7']) }}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('เลขบัตรประชาชน', 'เลขบัตรประชาชน :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('text', 'idcard', $sale->idcard, ['class' => 'form-control col-md-7', 'minlength' => 13, 'maxlenght' => 13, 'oninput' => 'validateIdCard(this)']) }}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('Companies', 'Companies :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::label('Companies', $sale->companies->company_th ?? '', ['class' => ' text-left col-md-3  col-form-label']) }}
                            {{-- {{Form::select('company_id', $companies, $sale->company_id,['class' => 'form-control col-md-7 selectpicker', 'data-size' => "10" ,'data-live-search'=>"true"  ])}}
                            --}}
                        </div>
                        @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport')
                            <div class="form-group row">
                                {{ Form::label('Team', 'Team :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                <select name="agent_by" id="agent_by" class="form-control col-md-7 selectpicker">

                                    <option value="">-- เลือก --</option>
                                    @foreach ($adminagents as $adminagent)
                                        @if ($adminagent->user_id == $sale->agent_by)
                                            <option value="{{ $adminagent->user_id }}" selected>
                                                {{ $adminagent->name_th }}</option>
                                        @else
                                            <option value="{{ $adminagent->user_id }}">{{ $adminagent->name_th }}
                                            </option>
                                        @endif
                                    @endforeach

                                </select>
                            </div>
                        @elseif (Auth::user()->role()->name == 'AdminAgent')
                            <input name="agent_by" type="hidden" value="{{ Auth::user()->id }}">
                        @endif

                        {{-- <div class="form-group row">
                            {{Form::label('Team','Team', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::select('team_id', $teams, $sale->team_id,['class' => 'form-control col-md-7 selectpicker', 'id' => 'team_id',  'data-size' => "10" ,'data-live-search'=>"true"  ])}}

                        </div> --}}
                        @foreach ($subTeam as $key => $item)
                            <div
                                class="form-group sub_team row @if ($sale->team_id != $key) d-none @endif sub_team_{{ $key }}">
                                {{ Form::label('sub team', 'sub team :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                                {{ Form::select('sub_team_id', $item, $sale->sub_team_id, ['class' => 'form-control col-md-7 selectpicker sub_team_id', 'id' => 'sub_team_id', 'data-size' => '10', 'data-live-search' => 'true']) }}
                            </div>
                        @endforeach

                        <div class="form-group row">
                            {{ Form::label('Position', 'Position :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::select('position_id', $roles, $sale->position_id, ['class' => 'form-control col-md-7 selectpicker', 'data-size' => '10', 'data-live-search' => 'true']) }}

                        </div>

                        {{-- <div class="form-group row">
                            {{Form::label('created_at','join date', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::input('text', 'created_at', ($sale->created_at) ?
                            date('d/m/Y' ,strtotime($sale->created_at))
                            :
                            date('d/m/Y' , strtotime('+ 543 years'))
                            ,['class' => 'form-control col-md-7 datepicker'])}}
                        </div> --}}
                        {{-- <div class=" form-group row">
                                <div class="col-md-7 offset-md-4">
                                    <input type="file" name="files[]" class="custom-file-input" id="validatedCustomFile"
                                        multiple>
                                    <label class="custom-file-label" for="validatedCustomFile">แนบไฟล์เอกสาร</label>

                                </div>
                            </div> --}}





                        <div class="form-group row">
                            {{ Form::label('ที่อยู่', 'ที่อยู่ :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}

                            <textarea name="address" id="address" cols="30" rows="10" class="form-control col-md-7">{{ $sale->address }}</textarea>
                            {{-- {{Form::input('text', 'address',$sale->,['class' => 'form-control col-md-7' ])}} --}}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('จังหวัด', 'จังหวัด :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="province_id" id="input_province" class="form-control col-md-7">
                                <option value="">เลือก จังหวัด</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->province_id }}"
                                        {{ $province->province_id == $sale->province_id ? 'selected' : '' }}>
                                        {{ $province->province }}
                                    </option>
                                @endforeach


                            </select>
                            {{-- {{Form::label('ตำบล','ตำบล', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'district_id',$sale->district_id,['class' => 'form-control col-md-7' ])}} --}}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('อำเภอ', 'อำเภอ :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="amphur_id" id="input_amphoe" class="form-control col-md-7">
                                @foreach ($amphoes as $amphoes)
                                    <option value="{{ $amphoes->amphoe_id }}"
                                        {{ $amphoes->amphoe_id == $sale->amphur_id ? 'selected' : '' }}>
                                        {{ $amphoes->amphoe }}
                                    </option>
                                @endforeach


                            </select>
                            {{-- {{Form::label('อำเภอ','อำเภอ', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'amphur_id',$sale->amphur_id,['class' => 'form-control col-md-7' ])}} --}}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('ตำบล', 'ตำบล :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="district_id" id="input_tambon" class="form-control col-md-7">
                                @foreach ($tambons as $tambons)
                                    <option value="{{ $tambons->tambon_id }}"
                                        {{ $tambons->tambon_id == $sale->district_id ? 'selected' : '' }}>
                                        {{ $tambons->tambon }}
                                    </option>
                                @endforeach


                            </select>
                            {{-- {{Form::label('จังหวัด','จังหวัด', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'province_id',$sale->province_id,['class' => 'form-control col-md-7' ])}} --}}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('รหัสไปรษณีย์', 'รหัสไปรษณีย์ :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <input class="form-control col-md-7" name="postcode" id="input_zipcode" autocomplete="off"
                                value="{{ $sale->postcode }}">
                            {{-- {{ Form::input('text', 'postcode', $sale->postcode, ['class' => 'form-control col-md-7', 'oninput' => 'validatePostcode(this)']) }} --}}
                        </div>

                        <div class="form-group row">
                            {{ Form::label('ธนาคาร', 'ธนาคาร :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            <select name="bank_name" id="" class="form-control col-md-7">
                                <option value="" {{ '' == $sale->bank_name ? 'selected' : '' }}>เลือก</option>
                                <option value="ธนาคาร กรุงเทพ"
                                    {{ 'ธนาคาร กรุงเทพ' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร กรุงเทพ</option>
                                <option value="ธนาคาร กสิกรไทย"
                                    {{ 'ธนาคาร กสิกรไทย' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร กสิกรไทย</option>
                                <option value="ธนาคาร กรุงไทย"
                                    {{ 'ธนาคาร กรุงไทย' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร กรุงไทย</option>
                                <option value="ธนาคาร ไทยพาณิชย์"
                                    {{ 'ธนาคาร ไทยพาณิชย์' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร ไทยพาณิชย์
                                </option>
                                <option value="ธนาคาร ทหารไทยธนชาต"
                                    {{ 'ธนาคาร ทหารไทยธนชาต' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร ทหารไทยธนชาต
                                </option>
                                <option value="ธนาคาร กรุงศรีอยุธยา"
                                    {{ 'ธนาคาร กรุงศรีอยุธยา' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร กรุงศรีอยุธยา
                                </option>
                                <option value="ธนาคาร เกียรตินาคินภัทร"
                                    {{ 'ธนาคาร เกียรตินาคินภัทร' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร
                                    เกียรตินาคินภัทร</option>
                                <option value="ธนาคาร UOB"
                                    {{ 'ธนาคาร UOB' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร UOB</option>
                                <option value="ธนาคาร ออมสิน"
                                    {{ 'ธนาคาร ออมสิน' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร ออมสิน</option>
                                <option value="ธนาคาร ธกส."
                                    {{ 'ธนาคาร ธกส.' == $sale->bank_name ? 'selected' : '' }}>ธนาคาร ธกส.</option>
                            </select>
                            {{-- {{Form::input('text', 'bank_name',$sale->bank_name,['class' => 'form-control col-md-7' ])}} --}}
                        </div>
                        <div class="form-group row">
                            {{ Form::label('เลขบัญชี', 'เลขบัญชี :', ['class' => 'col-md-3 offset-md-1 col-form-label']) }}
                            {{ Form::input('text', 'bank_account', $sale->bank_account, ['class' => 'form-control col-md-7', 'minlength' => 10, 'maxlenght' => 10, 'required' => true, 'oninput' => 'validatePhoneNumber(this)']) }}
                        </div>
                        @if ($sale->id == Auth::id() || Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport')
                            {{-- <div class="form-group row">
                                    <label for="recipient-name" class="col-md-3 offset-md-1 col-form-label">Upload(เอกสาร) :</label>
                                        <input type="file" name="files" id="files">
                                </div> --}}

                            @if ($sale->regis_type == 'บุคคลธรรมดา')
                                <div class="form-group row">
                                    <label for="recipient-name"
                                        class="col-md-3 offset-md-1 col-form-label">เอกสารสำเนาบัตรประชาชน
                                        :</label>
                                    @if (!empty($files->file_register) && optional($files)->file_register != '')
                                        <a class="btn btn-primary fancybox" data-type="iframe"
                                            href="{{ $files->file_register }}" target="_blank"
                                            role="button">ดูเอกสาร</a>
                                    @else
                                        <input type="file" name="file_register" id="file_register">
                                    @endif

                                </div>
                            @else
                                <div class="form-group row">
                                    <label for="recipient-name"
                                        class="col-md-3 offset-md-1 col-form-label">เอกสารสำเนาบัตรประชาชน
                                        :</label>
                                    @if (!empty($files->file_register) && optional($files)->file_register != '')
                                        <a class="btn btn-primary fancybox" data-type="iframe"
                                            href="{{ $files->file_register }}" target="_blank"
                                            role="button">ดูเอกสาร</a>
                                    @else
                                        <input type="file" name="file_register" id="file_register">
                                    @endif

                                </div>
                            @endif

                            <div class="form-group row" id="legalEntityDocs"
                                style="{{ $sale->regis_type == 'นิติบุคคล' ? '' : 'display: none;' }}">
                                <label for="recipient-name"
                                    class="col-md-3 offset-md-1 col-form-label">เอกสารจดทะเบียนนิติบุคคล
                                    :</label>
                                @if (!empty($files->file_legal) && optional($files)->file_legal != '')
                                    <a class="btn btn-primary fancybox" data-type="iframe"
                                        href="{{ $files->file_legal }}" target="_blank" role="button">ดูเอกสาร</a>
                                @else
                                    <input type="file" name="file_legal" id="file_legal">
                                @endif
                            </div>

                            <div class="form-group row">
                                <label for="recipient-name" class="col-md-3 offset-md-1 col-form-label">เอกสารสัญญา
                                    :</label>
                                @if (!empty($files->file_contract) && optional($files)->file_contract != '')
                                    <a class="btn btn-primary fancybox" data-type="iframe"
                                        href="{{ $files->file_contract }}" target="_blank" role="button">ดูเอกสาร</a>
                                @else
                                    <input type="file" name="file_contract" id="file_contract">
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="form-group row justify-content-center">
                {{ Form::submit('อัพเดท', ['class' => 'btn btn-primary my-3 ', 'style' => 'width:100px;']) }}
            </div>
            {{ Form::close() }}
        </div>



        @if ($sale->id == Auth::id() || Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'AdminSupport')
            <div class="row">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-header">ลูกทีม</div>
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <th>No.</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                </thead>
                                <tbody>
                                    @foreach ($userInTeam as $item)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td><a href="/users/{{ $item->id }}/edit">{{ $item->code }}</a></td>
                                            <td><a href="/users/{{ $item->id }}/edit">{{ $item->name_th }}</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        @if ($sale->id == Auth::id() || Auth::user()->role()->name == 'Admin')
            <div class="row">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-header">เปลี่ยนรหัสผ่าน</div>
                        <div class="card-body">
                            @include('component.password')
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>


@endsection


@push('scripts')
    <script src="/assets/plugins/jquery-migrate/jquery-migrate.min.js"></script>
    {{-- <script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> --}}
    <script src="/assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="/assets/plugins/jquery.maskedinput/src/jquery.maskedinput.js"></script>
    <script src="/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script src="/assets/plugins/password-indicator/js/password-indicator.js"></script>
    <script src="/assets/plugins/bootstrap-combobox/js/bootstrap-combobox.js"></script>
    <script src="/assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
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
    <script src="/assets/js/demo/form-plugins.demo.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
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
            $(".fancybox").fancybox();
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#team_id').change((e) => {
                let index = e.target.value
                $(`.sub_team`).addClass('d-none')
                $(`.sub_team_${index}`).removeClass('d-none')
            })
            $('#image_profile').change(function() {
                image_preview(this)
            })

            FormPlugins.init();
        });

        function image_preview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image_profile_preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $('.sub_team_id').change(e => {
            $('#sub_id').val(e.target.value);
        })
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
@endpush
