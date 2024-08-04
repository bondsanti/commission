@extends('layouts.loged')
@section('title', 'News')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            {!! Form::open(['route' => 'news.store' ,'method' => 'post', 'files' => true ]) !!}

            <div class="card">
                <div class="card-header">ข่าวสาร</div>

                <div class="card-body">


                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <div class="file-field">
                                <div class="mb-4">
                                    <img src="/images/favicon.png" class=" z-depth-1-half avatar-pic"
                                        alt="example placeholder avatar" id="preview_img">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="btn btn-mdb-color btn-rounded float-left">
                                        <span> {{'เพิ่มรูป' }}</span>
                                        <input type="file" name="image" id="upload_img" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        {!! Form::label('หัวข่าว', 'หัวข่าว', ['class' => 'col-md-2 col-text']) !!}
                        {!! Form::text('title', '', ['class' => 'form-control col-md-9' , 'required' => true]) !!}
                    </div>
                    <div class="form-group row">
                        {!! Form::label('วันที่', 'วันที่', ['class' => 'col-md-2 col-text']) !!}
                        {!! Form::text('date', '', ['class' => 'form-control col-md-9 datepicker' ,
                        'required' => true])
                        !!}
                    </div>
                    <div class="form-group row">
                        {!! Form::label('บทความ', 'บทความ', ['class' => 'col-md-2 col-text']) !!}
                        {!! Form::textarea('content', '', ['class' => 'form-control col-md-9', 'id' => 'textarea' ,
                        'rows' => 10 , 'required' => true]) !!}
                    </div>

                    <div class="form-group row"></div>


                    <div class="form-group row justify-content-center">
                        {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
