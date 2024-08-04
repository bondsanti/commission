@extends('layouts.loged')
@section('title', 'Project')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">โครงการทั้งหมด</div>

            <div class="card-body">
            <table id="data-table-default" class="table table-striped table-bordered text-center table-responsive">
                <thead>
                <tr>
                <td width="1%">No.</td>
                <td class="text-left">ชื่อโครงการ</td>

                </tr>
                </thead>
                <tbody>
                @foreach ($projects as $item)
					@if ($item->active)
					<tr>
                    <td class="text-center">{{$loop->index+1}}</td>
                    <td class="text-left">
                        <label for="" class="d-none">{{$item->name}}</label>
                            <a href="{{route('projects.show' ,$item->id)}}">{{$item->name}}</a>
                            {{-- <input type="text" value="{{$item->name}}"
                            class="form-control form-view form-edit-{{$item->id}}" readonly> --}}
                        </td>
                    </tr>
                         @endif					
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- end panel -->
  

</div>
@endsection