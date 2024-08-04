@extends('layouts.loged')
@section('title', 'Roles')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {!! Form::open(['route' => 'roles.store' ,'method' => 'post']) !!}
            <div class="row mb-3 ">
                <div class="col-md-8">
                    {{Form::input('text','name' ,'',['class'=>'form-control', 'placeholder' => 'Potision name' , 'required'])}}
                </div>
                <div class="col-md-4">
                    {{Form::submit('Create' ,['class'=>'btn btn-primary'])}}
                </div>
            </div>
            {{form::close()}}

            <div class="card">
                <div class="card-header">Position</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th>Position</th>
                                <th>Description</th>
                                <th width="1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                            <tr>
                                <td class="text-center">{{$loop->index+1}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->description}}</td>
                                <td class="text-center">
                                    <ul class="m-auto p-0 list-unstyled">
                                        <li class="dropdown action-menu">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h pointer-cursor"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{config('app.url')}}/roles/{{$role->id}}/edit"
                                                    class="dropdown-item">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <a href="javascript:;" class="dropdown-item">Remove</a>
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
</div>
@endsection
