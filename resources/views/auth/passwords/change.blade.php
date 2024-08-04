@extends('layouts.app')
@section('title', 'เปลี่ยนรหัสผ่าน')
@section('content')
<div class="container m-auto">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {!! Form::open(['route' => 'passwords.change' ,'method' => 'PUT' ]) !!}

            <div class="card">
                <div class="card-header">กรุณาเปลี่ยนรหัสผ่าน เมื่อเข้าครั้งแรก</div>
                <div class="card-body">
                    <div class="form-group row">
                        {!! Form::label('password', 'Password', ['class' => 'col-md-3 col-text']) !!}
                        <div class="col-md-8">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" value=""
                                required autofocus>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        {!! Form::label('c_password', 'Confirm Password', ['class' => 'col-md-3 col-text']) !!}
                        <div class="col-md-8">
                            <input id="c_password" type="password"
                                class="form-control  @error('c_password') is-invalid @enderror" name="c_password"
                                value="" required autofocus>
                            @error('c_password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('c_password') }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row justify-content-center">
                        {!! Form::submit('ยืนยัน', ['class' => 'btn btn-primary']) !!}
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
