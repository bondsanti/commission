@extends('layouts.loged')
@section('title', 'Settings')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    {{-- <table id="data-table-default" class="table table-striped table-bordered dataTable"> --}}
                    <table class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr class="text-center">
                                <th width="1%">No.</th>
                                <th >Setting</th>
                                <th >Value</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($settings as $item)
                                <tr class="text-center">
                                    <td>{{$loop->index+1}}</td>
                                    <td class="text-left">{{$item->name}}</td>
                                    <td>{{$item->value}}</td>
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