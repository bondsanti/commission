@extends('layouts.loged')
@section('title', 'News')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {!! Form::open(['route' => 'news.store' ,'method' => 'post' ]) !!}

            <div class="card">
                <div class="card-header">ข่าวสาร</div>

                <div class="card-body">

                    <div class="form-group row">
                        {!! Form::label('title', 'Title', ['class' => 'col-md-2 col-text']) !!}
                        {!! Form::text('title', '', ['class' => 'form-control col-md-9']) !!}
                    </div>

                    <div class="form-group row">
                        {!! Form::label('content', 'content', ['class' => 'col-md-2 col-text']) !!}
                        {!! Form::textarea('content', '', ['class' => 'form-control col-md-9']) !!}
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
