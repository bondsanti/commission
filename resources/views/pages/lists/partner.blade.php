@extends('layouts.loged')
@section('title', 'รายการ')
@section('content')
@php
use Illuminate\Support\Str;
@endphp

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <form method="get" action="{{ route('lists.index') }}" id="searchForm">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันที่</label>
                                        <select id="dt" name="dt" class="form-control"
                                            data-placeholder="" style="width: 100%;">
                                            <option value="" selected> ทั้งหมด</option>
                                            <option value="resultdate"> Result Date</option>
                                            <option value="senddate">Sent Date</option>
                                            <option value="receiveddate">Received Date</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันเริ่ม</label>
                                        <input type="text" id="calendar_input1" class="form-control datepicker"
                                            name="startdate"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>วันที่สิ้นสุด</label>
                                        <input type="text" id="calendar_input2" class="form-control datepicker"
                                            name="enddate"
                                            value="">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>โครงการ</label>
                                        <select id="project" name="project" class="form-control"
                                            data-placeholder="เลือกโครงการ" style="width: 100%;">
                                            <option value="">ทั้งหมด</option>
                                            @foreach ($projects as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ห้องเลขที่</label>
                                        <input class="form-control" name="roomno" id="roomno" type="text"
                                            value="{{ old('roomno', request()->get('roomno', '')) }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="ถึงช่วงราคา-group">
                                        <label>ชื่อลูกค้า</label>
                                        <input class="form-control" name="name" id="name" type="text"
                                            value="{{ old('name', request()->get('name', '')) }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>ธนาคาร</label>
                                        <select id="bank" name="bank" class="form-control"
                                            data-placeholder="เลือกสถานะ" style="width: 100%;">
                                            <option value="" selected>ทั้งหมด</option>
                                            <option value="BAY">BAY</option>
                                            <option value="BBL">BBL</option>
                                            <option value="CIMB">CIMB</option>
                                            <option value="GSB">GSB</option>
                                            <option value="ISALAM">ISALAM</option>
                                            <option value="KBANK">KBANK</option>
                                            <option value="SCB">SCB</option>
                                            <option value="TBANK">TBANK</option>
                                            <option value="TMB">TMB</option>
                                            <option value="UOB">UOB</option>
                                            <option value="ธอส">ธอส</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="row search-form form-group">
                                <div class="col-lg-12">
                                    <label for="" class="col-md-12 col-form-label">สถานะ</label>
                                    <div class="col-md-12 my-auto">
                                        @php
                                            $status = [
                                                'Received',
                                                'Pending',
                                                'Waiting',
                                                'Pre-Approved',
                                                'Approved',
                                                'Rejected',
                                                'Canceled',
                                                'Returned',
                                                'Deducted',
                                                'Mortgaged',
                                                'Contract',
                                                'SLA',
                                            ];
                                        @endphp
                                        @foreach ($status as $item)
                                            <input type="checkbox" name="status[]" class="status" id="{{ $item }}"
                                                value="{{ $item }}"
                                                @isset($_GET['status'])
                                                {{ in_array($item, $_GET['status']) ? 'checked' : '' }}
                                            @else
                                                checked
                                            @endisset>
                                            <label for="{{ $item }}">{{ $item }}</label>
                                        @endforeach

                                        <a href="javascript:;" id="toggle_check1" class="btn btn-light btn-xs">Uncheck
                                            all</a>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row form-group">
                            <div class="col-lg-12">
                                <div class="box-footer text-center">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i>
                                        ค้นหา</button>
                                    <a href="{{ route('lists.index') }}" type="button" class="btn btn-danger"><i
                                            class="fa fa-refresh"></i>
                                        เคลียร์</a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>


        <!--Table-->
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                   

                    <div class="card-body">
                        <table id="data-table-default" class="table table-sm table-hover table-striped text-nowrap  table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th width="1%">No.</th>
                                    <th> Team </th>
                                    <th> Sale ID </th>
                                    <th> Name </th>
                                    <th> Bank </th>
                                    <th> Status </th>
                                    <th> Project </th>
                                    <th> Home No </th>
                                    <th> Room No </th>
                                    <th> Received Date </th>
                                    <th> Sent Date </th>
                                    <th> Result Date </th>
                                    <th> Result Reason </th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                @php

                                if ($item['status'] == 'Approved')
                                $color = 'background-color: rgb(181, 222, 78);';
                                elseif($item['status'] == 'Rejected')
                                $color = 'background-color: rgb(255, 179, 179);';
                                elseif($item['status'] =='Waiting')
                                $color ='background-color: rgb(221, 221, 221);';
                                elseif($item['status'] =='Pre-Approved')
                                $color ='background-color: rgb(238, 255, 195);';
                                else
                                $color = '';
                    
                                @endphp
                                    <tr class="text-center" >
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td></td>
                                        <td>{{ $item['subid'] }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['bank'] }}</td>
                                        <td style="{{$color}}">{{ $item['status'] }}</td>
                                        <td>{{ $item['project_name'] ?: '-' }}</td>
                                        <td>{{ $item['Homeno'] }}</td>
                                        <td>{{ $item['RoomNo'] }}</td>
                                        <td>{{ $item['receiveddate'] ? date('d/m/Y', strtotime($item['receiveddate'])) : '-' }}</td>
                                        <td>{{ $item['senddate'] ? date('d/m/Y', strtotime($item['senddate'])) : '-' }}</td>
                                        <td>{{ $item['resultdate'] ? date('d/m/Y', strtotime($item['resultdate'])) : '-' }}</td>
                                        <td class="{{ $item['reason'] ? 'text-left' : 'text-center' }}">
                                            {{ $item['reason'] ? Str::limit($item['reason'], 30) : '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}


    </div><!-- /.container-fluid -->



@endsection
{{-- @push('script') --}}
<!-- Check&UnCheck ALL-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButton = document.getElementById('toggle_check1');
        var checkboxes = document.querySelectorAll('.status');

        var updateToggleButton = function() {
            var isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            toggleButton.textContent = isChecked ? 'Uncheck all' : 'Check all';
        };

        updateToggleButton();

        toggleButton.addEventListener('click', function() {
            var shouldCheck = toggleButton.textContent === 'Check all';
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = shouldCheck;
            });
            updateToggleButton();
        });
    });
</script>
{{-- @endpush --}}
