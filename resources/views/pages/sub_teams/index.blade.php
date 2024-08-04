@extends('layouts.loged')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            {!! Form::open(['route' => 'subteams.store' ,'method' => 'post']) !!}
                <div class="row mb-3 ">
                    <div class="col-md-8">
                        {{Form::input('text','name' ,'',['class'=>'form-control mb-2', 'placeholder' => 'Sub Team name' , 'required'])}}
                        {{Form::select('team_id',$teams ,'',['class'=>'form-control mb-2', 'placeholder' => 'Team name' ])}}
                        {{Form::select('sale_id',$sales ,'',['class'=>'form-control mb-2', 'placeholder' => 'Leader name' ])}}
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
                                <th class="text-center">Team Name</th>
                                <th class="text-center">Leader Name</th>
                                <th width="1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subTeam as $team)
                                <tr>
                                    <td class="text-center">{{$loop->index+1}}</td>
                                    <td class="text-center">{{$team->name}}</td>
                                    <td class="text-center">
                                    {{$team->leader()->first()->name}}
                                    </td>
                                    <td class="text-center">
                                        <ul  class="m-auto p-0 list-unstyled">
                                            <li class="dropdown action-menu" >
                                                <a href="javascript:;"  data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h pointer-cursor"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a href="{{config('app.url')}}/teams/{{$team->id}}/edit"  class="dropdown-item">Edit</a>
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
