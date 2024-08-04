@extends('layouts.loged')
@section('title', 'รายการ')
@section('content')

<style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        border-color: #e2e7eb;
        padding: 10px 5px;
    }
</style>
{{-- <div class="container"> --}}


<div class="">
    <div class="col-md-12 ">

        <div class=" card">
            <div class="card-body " style="font-size:12px;">
               @include('pages.lists.search')
            </div>
        </div>
    </div>
    @php
        $rentsCount = is_array($rents) ? count($rents) : 0;
    @endphp
    @if ( count($rentsCount) > 0 )
    <div class="col-md-12 ">
        <div class=" card">
            <div class="card-body overflow-auto">
                @include('pages.lists.table')
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
