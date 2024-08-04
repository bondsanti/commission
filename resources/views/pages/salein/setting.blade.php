@extends('layouts.loged')
@section('title', 'Sales In')

{{-- @push('styles') --}}
{{-- <style>
.form-control{
    border-radius: 0px !important;
    border:none !important;
    border-bottom: 1px solid #888 !important;
}
</style> --}}
{{-- @endpush --}}
@section('content')
@php

$positions = DB::table('hr.tb_status')->whereIn( 'name_eng', ['upper','under'])->get();
$position_id = $_GET['position_id'] ?? '';

$direct_sale_daily = DB::table('hr.settings')->where('description','direct-sale-daily')->where('key', 'point')->first();
$direct_sale_staff = DB::table('hr.settings')->where('description','direct-sale-staff')->where('key', 'point')->first();
$telesales_daily = DB::table('hr.settings')->where('description','telesales-daily')->where('key', 'point')->first();
$telesales_staff = DB::table('hr.settings')->where('description','telesales-staff')->where('key', 'point')->first();


if( isset($_GET['position_id'])){
$settings = DB::table('hr.settings')->where('position_id',$_GET['position_id'])->where('key', 'commission')->get();
}

@endphp

<div class=" " style="padding:30px;">
    <div class="row">
        <div class="col-md-6">
            <h3>Commission</h3>
        </div>
        <div class="col-md-6 text-right m-auto">
            <h4 class="mb-0">*ทุกการแก้ไขจะคำนวณใหม่ในรอบถัดไป</h4>

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'commissionssalein.setting', 'method' => 'get']) !!}
                            <div class="row">
                                {{-- <div class="col-md-4">
                                    <select name="status_id" id="status_id" class="form-control">
                                        <option value="">Telesale Staff</option>
                                        <option value="">Direct Sale Staff</option>
                                        <option value="">Telesale Daily</option>
                                        <option value="">Direct Sale Daily</option>
                                    </select>
                                </div> --}}
                                <div class="col-md-4">
                                    <select name="position_id" id="position_id" class="form-control">
                                        <option value="5" <?=($position_id== 5) ? 'selected' : ''?>>VP</option>
                                        <option value="7" <?=($position_id== 7) ? 'selected' : ''?>>Manager</option>
                                        <option value="8" <?=($position_id== 8) ? 'selected' : ''?>>TL</option>
                                        <option value="9" <?=($position_id== 9) ? 'selected' : ''?>>Senior Supervisor
                                        </option>
                                        <option value="10" <?=($position_id== 10) ? 'selected' : ''?>>Supervisor
                                        </option>
                                        <option value="15" <?=($position_id== 15) ? 'selected' : ''?>>Senior Manager
                                        </option>
                                        <option value="12" <?=($position_id== 12) ? 'selected' : ''?>>Staff</option>
                                    </select>
                                    {{-- {!! Form::select('position_id', Arr::pluck($positions, 'name', 'id') ,$position_id ?? null, [ 'class' => 'form-control' ] ) !!} --}}
                                </div>
                                <div class="col-md-2">
                                    {!! Form::submit('ตั้งค่า', ['class' => 'btn btn-primary']) !!}
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <table class="table text-center">
                        <thead>
                            <th>No.</th>
                            <th>ค่าแรก</th>
                            <th> </th>
                            <th>ค่าที่สอง</th>
                            <th>ค่าตอบแทน</th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (isset($_GET['position_id']))
                            @foreach ($settings as $key => $item)
                            @include('pages.salein.trupdate')
                            @endforeach
                            <tr>
                                {!! Form::open(['route' =>[ 'commissionssalein.setting.update' , $_GET['position_id']],
                                'method' => 'post']) !!}
                                {!! Form::hidden('key', 'commission') !!}
                                <td> </td>
                                <td><input type="text" class="form-control" name="first_value"></td>
                                <td>
                                    -
                                </td>
                                <td><input type="text" class="form-control" name="second_value"></td>
                                <td><input type="text" class="form-control" name="value"></td>
                                <td>{!! selectOption($item->condition??0) !!}</td>
                                <td> {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                            @endif
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
        @if ( ($_GET['position_id']?? 0) == 12)

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <h4>ราคาต่อ Point</h4>
                    {{--  --}}
                    <div class="col-md-12 mb-2">
                        {!! Form::open(['route' =>[ 'commissionssalein.setting.point' ,'direct-sale-daily'], 'method' =>
                        'put']) !!}
                        <div class="row">
                            <label for="point" class="col-md-4 col-form-label  ">Direct Sale Daily</label>
                            <div class="col-md-6">
                                {!! Form::text('points', $direct_sale_daily->value, ['class' => 'form-control' ]) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{--  --}}
                    {{--  --}}
                    <div class="col-md-12 mb-2">
                        {!! Form::open(['route' =>[ 'commissionssalein.setting.point' ,'telesales-daily'], 'method' =>
                        'put']) !!}
                        <div class="row">
                            <label for="point" class="col-md-4 col-form-label  ">Telesales Daily</label>
                            <div class="col-md-6">
                                {!! Form::text('points', $telesales_daily->value, ['class' => 'form-control' ]) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{--  --}}
                    <hr>
                    {{--  --}}
                    <div class="col-md-12 mb-2">
                        {!! Form::open(['route' =>[ 'commissionssalein.setting.point' ,'direct-sale-staff'], 'method' =>
                        'put']) !!}
                        <div class="row">
                            <label for="point" class="col-md-4 col-form-label  ">Direct Sale Staff</label>
                            <div class="col-md-6">
                                {!! Form::text('points', $direct_sale_staff->value, ['class' => 'form-control' ]) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{--  --}}
                    {{--  --}}
                    <div class="col-md-12">
                        {!! Form::open(['route' =>[ 'commissionssalein.setting.point' ,'telesales-staff'], 'method' =>
                        'put']) !!}
                        <div class="row">
                            <label for="point" class="col-md-4 col-form-label  ">Telesales Staff</label>
                            <div class="col-md-6">
                                {!! Form::text('points', $telesales_staff->value, ['class' => 'form-control' ]) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    {{--  --}}
                </div>
            </div>
        </div>
        @endif

    </div>

    {{-- END COMMISSION  --}}

    @if ( ($_GET['position_id']?? 0 ) == 8 || ($_GET['position_id']?? 0 ) == 12 )
    <hr>

    {{-- START ALLOWANCE --}}

    <div class="row">
        <div class="col-md-6">
            <h3>Allowance</h3>
        </div>
        <div class="col-md-6 text-right m-auto">
            <h4 class="mb-0">*ทุกการแก้ไขจะคำนวณใหม่ในรอบถัดไป</h4>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Telesale Daily</h4>
                    @if ( ($_GET['position_id']?? 0) == 12)

                    <h5>Staff</h5>
                    <table class="table text-center">
                        <thead>
                            <th width="50px">No.</th>
                            <th width="100px">ประเภท</th>
                            <th width="50px"> </th>
                            <th width="100px">ค่าแรก </th>
                            <th width="100px">เงื่อนไขอื่น</th>
                            <th width="100px">ประเภท</th>
                            <th width="100px"></th>
                            <th width="100px">ค่าสอง </th>
                            <th width="100px">ค่าตอบแทน </th>
                            <th></th>
                        </thead>
                        <tbody>

                            @php
                            $teles_daily = DB::table('hr.settings_test')->where('position_id', 12)
                            ->where('description','telesales-daily')
                            ->get();
                            @endphp
                            @foreach ($teles_daily as $key => $item)
                            @include('pages.salein.allowanceupdate')
                            @endforeach

                            {!! Form::open(['route' =>[ 'commissionssalein.allowance' ,'12'], 'method' =>'post']) !!}
                            {!! Form::hidden('description', 'telesales-daily') !!}
                            <tr>
                                <td> </td>
                                <td>{!! selectOptionAllowance('key','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num"></td>
                                <td>-</td>
                                <td>{!! selectOptionAllowance('condition','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value2','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num2"></td>
                                <td><input type="text" class="form-control" name="first_value"></td>
                                <td> {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}</td>
                            </tr>
                            {!! Form::close() !!}

                        </tbody>

                    </table>
                    @endif

                    @if ( ($_GET['position_id']?? 0) == 8)
                    <h5>Team Leader</h5>
                    <table class="table text-center">
                        <thead>
                            <th width="50px">No.</th>
                            <th width="100px">ประเภท</th>
                            <th width="50px"> </th>
                            <th width="100px">ค่าแรก </th>
                            <th width="100px">เงื่อนไขอื่น</th>
                            <th width="100px">ประเภท</th>
                            <th width="100px"></th>
                            <th width="100px">ค่าสอง </th>
                            <th width="100px">ค่าตอบแทน </th>
                            <th></th>
                        </thead>
                        <tbody>
                            @php
                            $teles_daily = DB::table('hr.settings_test')->where('position_id', 8)
                            ->where('description','telesales-daily')
                            ->get();
                            @endphp
                            @foreach ($teles_daily as $key => $item)
                            @include('pages.salein.allowanceupdate')
                            @endforeach
                            {!! Form::open(['route' =>[ 'commissionssalein.allowance' ,'8'], 'method' =>'post']) !!}
                            {!! Form::hidden('description', 'telesales-daily') !!}
                            <tr>
                                <td> </td>
                                <td>{!! selectOptionAllowance('key','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num"></td>
                                <td>-</td>
                                <td>{!! selectOptionAllowance('condition','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value2','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num2"></td>
                                <td><input type="text" class="form-control" name="first_value"></td>
                                <td> {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}</td>
                            </tr>
                            {!! Form::close() !!}

                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4>Direct Sale Daily</h4>
                    @if ( ($_GET['position_id']?? 0) == 12)

                    <h5>Staff</h5>
                    <table class="table text-center">
                        <thead>
                            <th width="50px">No.</th>
                            <th width="100px">ประเภท</th>
                            <th width="50px"> </th>
                            <th width="100px">ค่าแรก </th>
                            <th width="100px">เงื่อนไขอื่น</th>
                            <th width="100px">ประเภท</th>
                            <th width="100px"></th>
                            <th width="100px">ค่าสอง </th>
                            <th width="100px">ค่าตอบแทน </th>
                            <th></th>
                        </thead>
                        <tbody>
                            @php
                            $teles_daily = DB::table('hr.settings_test')->where('position_id', 12)
                            ->where('description','direct-sale-daily')
                            ->get();
                            @endphp
                            @foreach ($teles_daily as $key => $item)
                            @include('pages.salein.allowanceupdate')
                            @endforeach

                            {!! Form::open(['route' =>[ 'commissionssalein.allowance' ,'12'], 'method' =>'post']) !!}
                            {!! Form::hidden('description', 'direct-sale-daily') !!}
                            <tr>
                                <td> </td>
                                <td>{!! selectOptionAllowance('key','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num"></td>
                                <td>-</td>
                                <td>{!! selectOptionAllowance('condition','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value2','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num2"></td>
                                <td><input type="text" class="form-control" name="first_value"></td>
                                <td> {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}</td>
                            </tr>
                            {!! Form::close() !!}

                        </tbody>
                    </table>
                    @endif

                    @if ( ($_GET['position_id']?? 0) == 8)

                    <h5>Team Leader</h5>
                    <table class="table text-center">
                        <thead>
                            <th width="50px">No.</th>
                            <th width="100px">ประเภท</th>
                            <th width="50px"> </th>
                            <th width="100px">ค่าแรก </th>
                            <th width="100px">เงื่อนไขอื่น</th>
                            <th width="100px">ประเภท</th>
                            <th width="100px"></th>
                            <th width="100px">ค่าสอง </th>
                            <th width="100px">ค่าตอบแทน </th>
                            <th></th>
                        </thead>
                        <tbody>
                            @php
                            $teles_daily = DB::table('hr.settings_test')->where('position_id', 8)
                            ->where('description','direct-sale-daily')
                            ->get();
                            @endphp
                            @foreach ($teles_daily as $key => $item)
                            @include('pages.salein.allowanceupdate')
                            @endforeach
                            {!! Form::open(['route' =>[ 'commissionssalein.allowance' ,'8'], 'method' =>'post']) !!}
                            {!! Form::hidden('description', 'direct-sale-daily') !!}
                            <tr>
                                <td> </td>
                                <td>{!! selectOptionAllowance('key','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num"></td>
                                <td>-</td>
                                <td>{!! selectOptionAllowance('condition','0') !!}</td>
                                <td>{!! selectCompareOptionAllowance('value2','0') !!}</td>
                                <td><input type="text" class="form-control" name="value_num2"></td>
                                <td><input type="text" class="form-control" name="first_value"></td>
                                <td> {!! Form::submit('เพิ่ม', ['class' => 'btn btn-primary']) !!}</td>
                            </tr>
                            {!! Form::close() !!}
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
        </div>


    </div>

    {{-- END ALLOWANCE --}}
    @endif

    {{-- START NETWORK --}}
    <hr>

    <div class="row">
        <div class="col-md-6">
            <h3>Network</h3>
        </div>
        <div class="col-md-6 text-right m-auto">
            <h4 class="mb-0">*ทุกการแก้ไขจะคำนวณใหม่ในรอบถัดไป</h4>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Lead Online (FB,Google,Web)</h5>
                    <table class="table">
                        <thead>
                            <th>No.</th>
                            <th>ตำแหน่ง</th>
                            <th>ค่าตอบแทน ต่อ Unit</th>
                            <th> </th>
                        </thead>
                        <tbody>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 38)->first(); @endphp
                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 38], 'method' => 'put'])
                                !!}
                                {!! Form::hidden('description', 'officer') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>1</td>
                                <td>Marketing officer</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {{FORM::close()}}
                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 39)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 39], 'method' => 'put'])
                                !!}
                                {!! Form::hidden('description', 'tl') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>2</td>
                                <td>Executive / Supervisor / MNG</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {{FORM::close()}}
                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 40)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 40], 'method' => 'put'])
                                !!}
                                {!! Form::hidden('description', 'manager') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>3</td>
                                <td>Marketing Head</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {{FORM::close()}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--  --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5>Lead Affliate (Partner)</h5>
                    <table class="table">
                        <thead>
                            <th>No.</th>
                            <th>ตำแหน่ง</th>
                            <th>ค่าตอบแทน ต่อ Unit</th>
                            <th> </th>
                        </thead>
                        <tbody>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 41)->first(); @endphp
                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 41], 'method' => 'put'])
                                !!}
                                {!! Form::hidden('description', 'officer') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>1</td>
                                <td>Marketing officer</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 42)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 42], 'method' => 'put'])
                                !!}
                                {!! Form::hidden('description', 'tl') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>2</td>
                                <td>Executive / Supervisor / MNG</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 43)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 43], 'method' => 'put'])
                                !!}

                                {!! Form::hidden('description', 'manager') !!}
                                {!! Form::hidden('key', 'network-online') !!}
                                <td>3</td>
                                <td>Marketing Head</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--  --}}
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">
                    <h5>Lead Agent Customer (ปิดขายเอง)</h5>
                    <table class="table">
                        <thead>
                            <th>No.</th>
                            <th>ตำแหน่ง</th>
                            <th>ค่าตอบแทน ต่อ Unit</th>
                            <th> </th>
                        </thead>
                        <tbody>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 44)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 44], 'method' => 'put'])
                                !!}

                                {!! Form::hidden('description', 'officer') !!}
                                {!! Form::hidden('key', 'network-direct') !!}
                                <td>1</td>
                                <td>Marketing officer</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}
                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 45)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 45], 'method' => 'put'])
                                !!}

                                {!! Form::hidden('description', 'tl') !!}
                                {!! Form::hidden('key', 'network-direct') !!}
                                <td>2</td>
                                <td>Executive / Supervisor / MNG</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                            <tr>
                                @php $office = DB::table('hr.settings')->where('id', 46)->first(); @endphp

                                {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , 46], 'method' => 'put'])
                                !!}

                                {!! Form::hidden('description', 'manager') !!}
                                {!! Form::hidden('key', 'network-direct') !!}
                                <td>3</td>
                                <td>Marketing Head</td>
                                <td><input type="text" class="form-control" name="value" value="{{$office->value}}">
                                </td>
                                <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
                                {!! Form::close() !!}

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--  --}}

    </div>

    {{-- END NETWORK --}}


</div>

@php

function selectOption($type=0)
{
$text = "<select name='condition' class='form-control' style='width:100px;'>";
    $text .= "<option value='0' ".($type==0 ? 'selected':'').">กรุณาเลือก</option>";
    $text .= "<option value='1' ".($type==1 ? 'selected':'').">Mortgage</option>";
    $text .= "<option value='2' ".($type==2 ? 'selected':'').">Mortgage & App-in</option>";
    // $text .= "<option value='3' ".($type==3 ? 'selected':'').">App-in & Mortgage</option>";
    $text .= "<option value='4' ".($type==4 ? 'selected':'').">App-in</option>";
    $text .= "<option value='5' ".($type==5 ? 'selected':'').">Point</option>";
    $text .= "</select>";

return $text;
}

function selectOptionAllowance($name='', $type=0)
{
$text = "<select name='".$name."' class='form-control' style='width:100px;'>";
    $text .= "<option value='0' ".($type=='0' ? 'selected':'').">กรุณาเลือก</option>";
    $text .= "<option value='Mortgage' ".($type=='Mortgage' ? 'selected':'').">Mortgage</option>";
    $text .= "<option value='App-in' ".($type=='App-in' ? 'selected':'').">App-in</option>";
    $text .= "<option value='Point' ".($type=='Point' ? 'selected':'').">Point</option>";
    $text .= "</select>";

return $text;
}

function selectCompareOptionAllowance($name='', $type=0){
$text = "<select name='".$name."' class='form-control' style='width:100px;'>";
    $text .= "<option value='0' ".($type==0 ? 'selected':'').">กรุณาเลือก</option>";
    $text .= "<option value='m' ".($type=='m' ? 'selected':'')."> >=</option>";
    $text .= "<option value='l' ".($type=='l' ? 'selected':'').">
        < </option>"; $text .="</select >" ; return $text; } function selectCompareOption($type=0){
            $text="<select name='compare' class='form-control' style='width:100px;'>" ; $text .="<option value='0' "
            .($type==0 ? 'selected' :'').">กรุณาเลือก
    </option>";
    $text .= "<option value='>' ".($type== '>' ? 'selected':'')."> ></option>";
    $text .= "<option value='>=' ".($type=='>=' ? 'selected':'')."> >=</option>";
    $text .= "<option value='=' ".($type=='=' ? 'selected':'')."> = </option>";
    $text .= "<option value='<' ".($type=='<' ? 'selected':'').">
        < </option>"; $text .="<option value='<=' " .($type=='<=' ? 'selected' :'').">
            <= </option>"; $text .="</select >" ; return $text; } @endphp @endsection
