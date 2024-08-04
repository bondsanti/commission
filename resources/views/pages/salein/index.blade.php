@extends('layouts.loged')
@section('title', 'Sales In')

@section('content')
@php
$role = Auth::user()->role() ;
@endphp
<div class=" " style="padding:30px;">

    {{-- <div class="row justify-content-center">
        <div class="col-md-12">


            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => 'salein.index', 'method' => 'get']) !!}
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
        </div>
    </div> --}}

    <div class="row justify-content-center">
        <div class="col-md-12">


            <div class="card">
                <div class="card-header">Sale IN</div>

                <div class="card-body">
                    <table  id="data-table-default" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th width="1%">Point</th>
                                <th width="1%">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $item)
                            <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $item->code }}</td>
                                <td><a href="{{route('salein.edit',$item->id)}}">{{ $item->name_th }}</a></td>
                                <td>{{ $item->position_name }}</td>
                                <td class="text-right"></td>
                                {{-- <td class="text-right">{{ number_format($item->commission_point,2) }}</td> --}}
                                <td>
                                    <ul class="m-auto p-0 list-unstyled">
                                        <li class="dropdown action-menu">
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h pointer-cursor"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item "
                                                    href="{{ route('salein.edit', $item->id) }} ">Edit</a>
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
