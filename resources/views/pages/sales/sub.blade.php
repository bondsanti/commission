@extends('layouts.loged')
@section('title', 'Sales')

@section('content')
@php
$role = Auth::user()->role()->name ;
@endphp
<div class="container">


    <div class="row justify-content-center">
        <div class="col-md-12">
            @if($role == 'Admin' ||
            $role == 'Support'
            )
            <div class="row mb-3">
                <div class="col-md-12">
                    <a href="{{config('app.url')}}/users/create" class="btn btn-primary">Add Sale/Agent</a>
                    @if($role == 'Admin' )
                    <a href="{{config('app.url')}}/users/create/other" class="btn btn-primary">Add Other</a>
                    @endif
                </div>
            </div>
            @endif

            @if($role == 'Admin' ||
            $role == 'Authorizer' ||
            $role == 'Support'

            )
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
            @endif
            <div class="card">
                <div class="card-header">Sales/Agents</div>

                <div class="card-body">

                    @if($role == 'Admin' ||
                    $role == 'Authorizer' ||
                    $role == 'Support'

                    )
                    {{-- @include('pages.sales.lists.admin') --}}
                    {{-- @include('pages.sales.lists.admin') --}}
                    @include('pages.sales.lists.sub')
                    @else
                    @include('pages.sales.lists.user')
                    @endif

                </div>
            </div>


        </div>
    </div>
</div>

@endsection
