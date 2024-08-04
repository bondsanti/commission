@extends('layouts.loged')
@section('title', 'Roles')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">


            <div class="card">
                <div class="card-header">{{$role->name}}</div>

                <div class="card-body">
                    {{Form::model($role,['route' => ['roles.update', $role->id] , 'method' => 'put'])}}
                    <div class="form-group row">
                        {{Form::label('Name','Name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('text', 'name', $role->name,['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Description','Description', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::textarea('description', $role->description,['class' => 'form-control col-md-7' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Commission','Commission', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::number('commission', $role->commission,['class' => 'form-control col-md-2' ,'required' => true, 'step' => 'any'])}}
                        {{Form::label('%','%', ['class' => 'col-md-3 col-form-label'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Mortgage','Mortgage', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'mortgage', $role->mortgage,['class' => 'form-control col-md-2' ,'required' => true])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Agent','Agent', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'SALE', $role->SALE,['class' => 'form-control col-md-2' ,'required' => true])}}


                    </div>

                    <div class="form-group row">
                        {{Form::label('TL','TL', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'TL', $role->TL,['class' => 'form-control col-md-2' ,'required' => true])}}


                    </div>

                    <div class="form-group row">
                        {{Form::label('MG','MG', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'MG', $role->MG,['class' => 'form-control col-md-2' ,'required' => true])}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('SM','SM', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'SM', $role->SM,['class' => 'form-control col-md-2' ,'required' => true])}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('AVP','AVP', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'AVP', $role->AVP,['class' => 'form-control col-md-2' ,'required' => true])}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('VP','VP', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::input('number', 'VP', $role->VP,['class' => 'form-control col-md-2' ,'required' => true])}}

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
