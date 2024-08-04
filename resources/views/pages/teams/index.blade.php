@extends('layouts.loged')
@section('title', 'Teams')
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
    <link href="/assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css" rel="stylesheet" />
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {!! Form::open(['route' => 'teams.store' ,'method' => 'post']) !!}
                <div class="row mb-3 ">
                    <div class="col-md-8">
                        {{Form::input('text','name' ,'',['class'=>'form-control mb-2', 'placeholder' => 'Team name' , 'required'])}}
                        {{Form::input('text','code_team' ,'',['class'=>'form-control mb-2', 'placeholder' => 'Code Team' , 'required', 'maxlength' => '4'])}}
                        {{Form::select('sale_id',$sales ,'',['class'=>'form-control', 'placeholder' => 'Leader name' ])}}
                    </div>
                    <div class="col-md-4">
                        {{Form::submit('Create' ,['class'=>'btn btn-primary'])}}
                    </div>
                </div>
            {{form::close()}}
                
            <div class="card">
                <div class="card-header">Team</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th class="text-center">Team Name</th>
                                <th class="text-center">Leader Name</th>
                                <th width="1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $team)
                                <tr>
                                    <td class="text-center">{{$loop->index+1}}</td>
                                    <td class="text-center">{{$team->name}}</td>
                                    <td class="text-center">
                                        @if($team->leader()->first())
                                        {{ $team->leader()->first()->thai_name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <ul  class="m-auto p-0 list-unstyled">
                                            <li class="dropdown action-menu" >
                                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h pointer-cursor"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a  class="dropdown-item " onclick="model('{{$team->id}}','{{$team->name}}','{{$team->code_team}}','{{$team->sale_id}}','{{isset($team->leader()->first()->thai_name)? $team->leader()->first()->thai_name : '--กรุณาเลือก--'}}')">Edit</a>
                                                        {{-- <div class="dropdown-divider"></div> --}}
                                                    {{-- <a href="javascript:;" class="dropdown-item">Remove</a> --}}
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">กรุณาเลือกหัวหน้าทีม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         {!! Form::open(['route' => ['teams.update' , 1] ,'method' => 'put' ,'id' =>'form_team'] ) !!}
                <div class="row mb-3 ">
                    <div class="col-md-12">
                        {{Form::input('text','name' ,'',['class'=>'form-control mb-2', 'id'=>'team_name', 'placeholder' => 'Team name' , 'required'])}}
                        {{Form::input('text','code_team' ,'',['class'=>'form-control mb-2', 'id'=>'code_team', 'placeholder' => 'Code Team' , 'required', 'maxlength' => '4'])}}
                        {{Form::select('sale_id',$sales ,'',['class'=>'form-control  mb-2 selectpicker', 'id' => 'sale_id' ,'placeholder' => 'Leader name',' data-size' => "10" ,'data-live-search'=>"true" ])}}
                        {{Form::input('hidden','team_id' ,'', ['id' => 'team_id'  ])}}
                    </div>
                    <div class="col-md-12 text-center">
                        {{Form::submit('Save Change' ,['class'=>'btn btn-primary btn-submit'  ])}}
                    </div>
                </div>
            {{form::close()}}
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
			FormPlugins.init();
    });

        function model(id, name,code_team, sale_id, sale_name){
            $('#sale_id').val(sale_id);
            $('.filter-option-inner-inner').html(sale_name);
            $('#team_name').val(name);
            $('#code_team').val(code_team);
            $('#team_id').val(id);
            $('#exampleModalLong').modal()
        }

</script>


@endpush
