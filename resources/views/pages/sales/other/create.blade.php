@extends('layouts.loged')
@section('title', 'Add Other')

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
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">Create Other</div>

                <div class="card-body">
                    {{Form::open(['route' => ['users.other.store'] , 'method' => 'post', 'files' => true])}}



                    <div class="form-group row">
                        {{Form::label('user_name','user name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'user_name','',['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('name_th','Thai name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'name_th','',['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('name_eng','English name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'name_eng','',['class' => 'form-control col-md-7' ])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Email','Email', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('email', 'email','',['class' => 'form-control col-md-7' ])}}
                    </div>


                    <div class="form-group row">
                        {{Form::label('Position','Position', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::select('position_id', $roles,'2',['class' => 'form-control col-md-7 selectpicker ' ,'data-size' => "10" ,'data-live-search'=>"true"  ])}}
                    </div>




                    <div class="form-group row justify-content-center">
                        {{Form::submit('Save', ['class' => 'btn btn-primary my-3 '])}}
                    </div>

                    {{Form::close()}}
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
    $(document).ready(function() {

            FormPlugins.init();
		});
</script>
@endpush
