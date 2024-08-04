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
@endpush
@section('content')
<div style="padding:30px;">
    @php
    $role = Auth::user()->role()
    @endphp

    <div class="row">
        {{-- {{Form::model($sale ,['route' => ['users.update', $sale->id] , 'method' => 'put' , 'files' => true ,'class' => 'w-100'])}}
        --}}
        <div class="col-lg-6">

            <div class="tab-content shadow-sm" id="nav-tabContent" style="height:650px">

                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div>

                        <div class="form-group row">
                            {{Form::label('Code','Code', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::label('Code',$sale->code, ['class' => 'col-md-7  col-form-label pl-0'])}}
                        </div>

                        <div class="form-group row">
                            {{Form::label('Thai name','Thai name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::label('Thai name',$sale->name_th, ['class' => 'col-md-7  col-form-label pl-0'])}}
                        </div>

                        <div class="form-group row">
                            {{Form::label('name_eng','English name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::label('name_eng', ($sale->name_eng ) ? $sale->name_eng : '-', ['class' => 'col-md-7  col-form-label pl-0'])}}

                        </div>
                        <div class="form-group row">
                            {{Form::label('email','Email', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::label('email', ($sale->email ) ? $sale->email : '-' ,  ['class' => 'col-md-7  col-form-label pl-0'])}}

                        </div>


                        <div class="form-group row">
                            {{Form::label('position_id','Position', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::label('position_id',$sale->role($sale->position_id)->name , ['class' => 'col-md-7  col-form-label pl-0'])}}

                        </div>

                        {{-- <div class=" form-group row">
                            <div class="col-md-7 offset-md-4">
                                <input type="file" name="files[]" class="custom-file-input" id="validatedCustomFile"
                                    multiple>
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                            </div>
                        </div> --}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('phone','เบอร์โทรศัพท์', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('phone',  ($sale->phone ) ? $sale->phone : '-', ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('idcard','เลขบัตรประชาชน', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('idcard', ($sale->idcard ) ? $sale->idcard : '-', ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>
                    <div class="form-group row">
                        {{Form::label('bank_name','ธนาคาร', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('bank_name', ($sale->bank_name ) ? $sale->bank_name : '-', ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>
                    <div class="form-group row">
                        {{Form::label('bank_account','เลขบัญชี', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('bank_account', ($sale->bank_account ) ? $sale->bank_account : '-' , ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>
                    <div class="form-group row">
                        {{Form::label('commission','Commission(%)', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('commission', ($sale->commission ) ? $sale->commission : '-' , [ 'id'=>'text_edit', 'class' => 'col-md-2  col-form-label pl-0'])}}
                        @if ($role->name == 'Admin')

                        {{ Form::text('commission', $sale->commission , ['id'=>'text_update' ,'class'=>'form-control col-md-2 d-none ']) }}
                        {{-- <input type="button" class="btn btn-primary" value="แก้ไข"> --}}
                        <a href="javascript:;" id="a_edit" onclick="editCom({{$sale->id}})"
                            style=" margin: auto 0px;">แก้ไข</a>
                        <a href="javascript:;" id="a_update" onclick="updateCom({{$sale->id}})" class="d-none"
                            style=" margin: auto 2px auto 15px;">อัพเดท</a>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <div class="tab-content shadow-sm" id="nav-tabContent" style="height: 650px;overflow: auto;">
                <h5>ลูกทีมของ {{$sale->name_th}}</h5>
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    @php
                    $subTeam = DB::table('hr.users')
                    ->leftJoin('hr.tb_position','tb_position.id','users.position_id')
                    ->where('sup_team', $sale->code)
                    ->select('users.id as user_id', 'users.name_th', 'users.code', 'tb_position.*')
                    ->get();
                    @endphp
                    <table id="data-table-default" class="table table-striped table-bordered dataTable">
                        <thead>
                            <th>ชื่อ</th>
                            <th>ตำแหน่ง</th>
                            <th>ลูกทีมของ</th>
                        </thead>
                        <tbody>
                            @if ( count($subTeam) > 0)
                            @php
                                $i=0;
                            @endphp
                            @foreach ($subTeam as $lead)
                            <tr>
                                <td><a href="/salein/{{$lead->user_id}}/edit">{{$lead->name_th}}</a></td>
                                <td>{{$lead->name}}</td>
                                <td></td>
                            </tr>

                            @php
                                $subTeamOfTeam = DB::table('hr.users')
                                ->leftJoin('hr.tb_position','tb_position.id','users.position_id')
                                ->where('sup_team', $lead->code)
                                ->select('users.id as user_id', 'users.name_th', 'users.code', 'tb_position.*')
                                ->get();
                            @endphp
                                @foreach ($subTeamOfTeam as $item)
                                <tr>
                                    <td><a href="/salein/{{$item->user_id}}/edit">{{$item->name_th}}</a></td>
                                    <td>{{$item->name}}</td>
                                    <td><a href="/salein/{{$lead->user_id}}/edit">{{$lead->name_th}}</a></td>
                                </tr>

                                @endforeach

                            @endforeach
                            @else

                            <tr>
                                <td colspan="3">ไม่มีลูกทีม</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- {{Form::close()}} --}}
    </div>
</div>



<div class=" " style="padding:30px;">
    @php
    $from = $_GET['from'] ?? date('1/m/Y', strtotime("+ 543 Years"));
    $to = $_GET['to'] ?? date('d/m/Y', strtotime("+ 543 Years"));
    @endphp
    <div class="row">
        <div class="col-lg-12 ">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => ['salein.edit', $sale->id] ,'method' => 'get']) }}
                    <div class="row">
                        {{Form::label('Form','Form', ['class' => 'col-md-1  col-form-label text-center '])}}
                        {{Form::input('text', 'from', $from  ,['class' => 'form-control col-md-2 datepicker' ,
                        'required' => true ])}}
                        {{Form::label('To','To', ['class' => 'col-md-1  col-form-label text-center'])}}
                        {{Form::input('text', 'to', $to    ,['class' => 'form-control col-md-2 datepicker' ,'required' => true])}}

                        <div class="col-md-2">
                            {{Form::submit('Search' ,['class'=>'btn btn-primary'])}}
                        </div>
                    </div>
                    {{form::close()}}
                </div>
            </div>
        </div>


        <div class="col-lg-12 ">
            <div class="card">
                <div class="card-header">Commission</div>
                <div class="card-body overflow-auto">
                    @include('pages.salein.list-edit')
                </div>
            </div>
        </div>
    </div>

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

<script>
    $(document).ready(function() {




    });


    function updateCom(sale_id) {
        axios.post(`/api/users/${sale_id}/comission`, {commission: $('#text_update').val() }).then( res=>{
            location.reload()
        $('#a_update').addClass('d-none')

        })

    }

    function editCom(sale_id) {
        $('#a_edit').addClass('d-none')
        $('#text_edit').addClass('d-none')
        $('#a_update').removeClass('d-none')
        $('#text_update').removeClass('d-none')
    }

</script>
@endpush
