@extends('layouts.loged')
@section('title', 'Sales')

@section('content')
<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-12">



            <div class="card">
                <div class="card-header">การค้นหา</div>

                <div class="card-body">
                    {!! Form::open(['route' => 'user.search', 'method' => 'get']) !!}
                    <div class="form-group row">
                        <label for="name" class="col-form-label col-md-2">ชื่อ</label>
                        <input type="text" name="name" class="form-control col-md-4">

                    </div>
                    <div class="form-group row">
                        <label for="code" class="col-form-label col-md-2">รหัส</label>
                        <input type="text" name="code" class="form-control col-md-4">
                    </div>
                    <div class="form-group row">
                        <label for="idcard" class="col-form-label col-md-2">เลขบัตรประชาชน</label>
                        <input type="text" name="idcard" class="form-control col-md-4">
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-form-label col-md-2">เบอร์โทรศัพท์</label>
                        <input type="text" name="phone" class="form-control col-md-4">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

            <div class="card">
                <div class="card-header">Sales/Agents</div>

                <div class="card-body">

                    <h2>Total {{ $count }}</h2>
                    <table class="table  text-center ">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Code</th>
                                <th>Sale Name</th>
                                <th>Potision</th>
                            </tr>
                        </thead>
                        @foreach ($agents as $item)

                        <tbody>
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    <a href="/users/{{$item->id}}/edit">{{$item->code}}</a>
                                </td>
                                <td>
                                    <a href="/users/{{$item->id}}/edit">{{$item->name_th}}</a>
                                </td>

                                <td>{{  $item->role_name }}</td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection
