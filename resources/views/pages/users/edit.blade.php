@extends('layouts.loged')
@section('title', 'Edit')

@push('css')
<link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
<link href="/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
<link href="/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" />
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
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{$sale->name_th}}</div>

                <div class="card-body">
                    {{Form::model($sale ,['route' => ['users.update', $sale->id] , 'method' => 'put' , 'files' => true])}}

                    <div class="form-group row">
                        {{Form::label('Code','Code', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Code',$sale->code, ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Thai name','Thai name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'name_th', $sale->name_th,['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Eng name','Eng name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'name_eng', $sale->name_eng,['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>
                    @if(Auth::user()->role()->name != 'Admin' &&
                    Auth::user()->role()->name != 'Authorizer' &&
                    Auth::user()->role()->name != 'Support'
                    )

                    <div class="form-group row">
                        {{Form::label('Email','Email', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('email', 'email', $sale->email,['class' => 'form-control col-md-7'  ])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Companies','Companies', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Companies',($sale->companies()->first())? $sale->companies->company_th : '', ['class' => 'col-md-7  col-form-label pl-0'])}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('Team','Team', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Team',($sale->teams()->first())? $sale->teams()->first()->name : '', ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Leader','Leader', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Leader', ($sale->leader($sale)) ? $sale->leader($sale)->first()->name_th : '' , ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('created_at','join date', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('created_at', ($sale->created_at) ?  date('d M Y',strtotime($sale->created_at)) : '-', ['class' => 'col-md-7  col-form-label pl-0'])}}
                    </div>
                    @endif

                    <div class="form-group row justify-content-center">
                        {{Form::submit('อัพเดท', ['class' => 'btn btn-primary my-3 '])}}
                    </div>

                    {{Form::close()}}
                </div>
            </div>

            {{--  --}}


            <div class="card">
                <div class="card-header">เปลี่ยนรหัสผ่าน</div>

                <div class="card-body">
                    @include('component.password')
                </div>
            </div>
        </div>
    </div>
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
</script>
@endpush
