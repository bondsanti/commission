@extends('layouts.loged')
@section('title', 'Commission')

@section('content')
@php

if (date('d') < 16) {
    $from = date('1/m/Y', strtotime('-1 month +543 years'));
    $to = date('15/m/Y',  strtotime(' +543 years'));
} else {
    $from = date('16/m/Y' , strtotime(' +543 years'));
    $to = date('t/m/Y', strtotime('+543 years'));
}


$from = $_GET['from'] ?? $from;
$to = $_GET['to']  ?? $to;
@endphp
<div class=" " style="padding:30px;">
    <div class="row justify-content-center">
        <div class="col-md-12">


            <div class="card mb-4">
                <div class="card-header">Search</div>

            <div class="card-body">
                {{ Form::open(['route' => 'commissionssalein.index' ,'method' => 'get']) }}
                <div class="row">
                    {{Form::label('Form','Form', ['class' => 'col-md-1  col-form-label text-center '])}}
                    {{Form::input('text', 'from', $from  ,['class' => 'form-control col-md-2 datepicker' ,
                        'required' => true ])}}
                    {{Form::label('To','To', ['class' => 'col-md-1  col-form-label text-center'])}}
                    {{Form::input('text', 'to', $to    ,['class' => 'form-control col-md-2 datepicker' ,'required' => true])}}

                    <div class="col-md-2">
                        {{Form::submit('Search' ,['class'=>'btn btn-primary'])}}
                    </div>
                </div>
                {{form::close()}}
            </div>
        </div>

        <div class="card">
            <div class="card-header">Commission <span class="font-weight-light">(
                    {{ $from }} - {{  $to }} )</span></div>
            <div class="card-body overflow-auto">

                @include('pages.salein.list')

            </div>
        </div>
    </div>
</div>
</div>
@endsection
