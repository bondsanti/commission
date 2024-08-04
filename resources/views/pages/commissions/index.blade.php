@extends('layouts.loged')
@section('title', 'Commission')

@section('content')
<div class=" " style="padding: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-12">


            <div class="card mb-4">
                <div class="card-header">Search</div>
                {{-- <div class="card-body">
                    {{ Form::open(['route' => 'commissions.search' ,'method' => 'POST']) }}
                <div class="row">
                    {{Form::label('Form','Form', ['class' => 'col-md-1  col-form-label text-center '])}}
                    {{Form::input('text', 'from', ( $from ) ? date( 'd/m/Y', strtotime($from))  : date('1/m/Y')  ,['class' => 'form-control col-md-2 datepicker' ,
                                        'required' => true ])}}
                    {{Form::label('To','To', ['class' => 'col-md-1  col-form-label text-center'])}}
                    {{Form::input('text', 'to', ( $to ) ? date( 'd/m/Y', strtotime($to)) : date('15/m/Y')  ,['class' => 'form-control col-md-2 datepicker' ,'required' => true])}}
                </div>
                <div class="row">
                    {{Form::label('status','สถานะ', ['class' => 'col-md-1 col-form-label text-center'])}}
                    {!! Form::select('status', ['ทั้งหมด','จ่ายแล้ว','ยังไม่จ่าย'],'0', ['class' =>
                    'form-control col-md-2']) !!}
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        {{Form::submit('Search' ,['class'=>'btn btn-primary'])}}
                    </div>
                </div>
                {{form::close()}}
            </div> --}}

            <div class="card-body">
                {{ Form::open(['route' => 'commission.search' , 'method'=>'get' ]) }}
                <div class="row">
                    {{Form::label('Form','Form', ['class' => 'col-md-1  col-form-label text-center '])}}
                    {{Form::input('text', 'from', ( $from ) ? date( 'd/m/Y', strtotime($from))  : date('1/m/Y')  ,['class' => 'form-control col-md-2 datepicker' ,
                        'required' => true ])}}
                    {{Form::label('To','To', ['class' => 'col-md-1  col-form-label text-center'])}}
                    {{Form::input('text', 'to', ( $to ) ? date( 'd/m/Y', strtotime($to)) : date('15/m/Y')  ,['class' => 'form-control col-md-2 datepicker' ,'required' => true])}}

                    <div class="col-md-2">
                        {{Form::submit('Search' ,['class'=>'btn btn-primary'])}}
                    </div>
                </div>
                {{form::close()}}
            </div>
        </div>

        <div class="card">
            <div class="card-header">Commission <span class="font-weight-light">(
                    {{date( 'd M Y', strtotime($from))}} - {{date( 'd M Y', strtotime($to))}} )</span></div>

            <div class="card-body overflow-auto">
                @if($type == '1')
                @include('pages.commissions.lists.admin')
                @else
                @include('pages.commissions.lists.user')
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
