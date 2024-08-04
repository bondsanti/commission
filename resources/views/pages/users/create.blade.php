@extends('layouts.loged')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">Create User</div>

                <div class="card-body">
                    {{Form::open(['route' => ['sales.store'] , 'method' => 'post'])}}

                    {{-- <div class="form-group row">
                            {{Form::label('Thai name','Thai name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::input('text', 'thai_name','',['class' => 'form-control col-md-7' ,'required' => true])}}
                </div>

                <div class="form-group row">
                    {{Form::label('English name','English name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::input('text', 'eng_name','',['class' => 'form-control col-md-7' ,'required' => true])}}
                </div>

                <div class="form-group row">
                    {{Form::label('Companies','Companies', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::select('company_id', $companies,'',['class' => 'form-control col-md-7'])}}
                </div>

                <div class="form-group row">
                    {{Form::label('Team','Team', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::select('team_id', $teams,'',['class' => 'form-control col-md-7'])}}
                </div>

                <div class="form-group row">
                    {{Form::label('sub team','sub team', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::select('sub_team_id', $subTeam,'',['class' => 'form-control col-md-7'])}}

                </div>

                <div class="form-group row">
                    {{Form::label('Position','Position', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::select('role_id', $roles,'',['class' => 'form-control col-md-7'])}}
                </div>

                <div class="form-group row">
                    {{Form::label('join date','join date', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                    {{Form::input('text', 'join_date','',['class' => 'form-control col-md-7 datetimepicker' ,'required' => true])}}
                </div>

                <div class="form-group row">
                    <input type="file" id="input-file-now" class="file-upload col-md-7 offset-md-4" />
                </div> --}}



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
<script>
    $(function () {
    $('.datetimepicker').datetimepicker();
    });
</script>

@endpush
