{{-- <tr>
    {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , $item->id ], 'method' => 'put']) !!}
        {!! Form::hidden('key', 'allownce') !!}

        <td>{{ $key+1}}</td>
<td><input type="text" class="form-control" name="first_value" value="{{$item->first_value}}"></td>
<td>
    -
</td>
<td><input type="text" class="form-control" name="second_value" value="{{$item->second_value}}"></td>
<td><input type="text" class="form-control" name="value" value="{{$item->value}}"></td>
<td>{!! selectOption($item->condition) !!}</td>
<td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
{!! Form::close() !!}

{!! Form::open(['route' =>[ 'commissionssalein.setting.delete' , $item->id ], 'method' => 'delete']) !!}
<td> {!! Form::submit('ลบ', ['class' => 'btn btn-danger']) !!}</td>
{!! Form::close() !!}

</tr> --}}


@php

$value_num2 = $item->value2 ?? 0;

if($value_num2[0] == 'l'){
$value_num2 = 'l';
}elseif($value_num2[0] == 'm'){
$value_num2 = 'm';
}else{
$value_num2 = 0;
}

$value_num = $item->value ?? 0;

if($value_num[0] == 'l'){
$value_num = $value_num[0];
}elseif($value_num[0] == 'm'){
$value_num = $value_num[0];
}else{
$value_num = 0;
}

@endphp
<tr>
    {!! Form::open(['route' =>[ 'commissionssalein.allowance' , $item->id ], 'method' =>'PUT']) !!}
    {{-- {!! Form::hidden('description', 'telesales-daily') !!} --}}
    <td> </td>
    <td>{!! selectOptionAllowance('key', $item->key) !!}</td>
    <td>{!! selectCompareOptionAllowance('value', $value_num) !!}</td>
    <td><input type="text" class="form-control" name="value_num" value="{{ substr($item->value??0,1) ?? 0}}"></td>
    <td>-</td>
    <td>{!! selectOptionAllowance('condition', $item->condition ?? null) !!}</td>
    <td>{!! selectCompareOptionAllowance('value2', $value_num2?? 0 ) !!}</td>
    <td><input type="text" class="form-control" name="value_num2" value="{{ substr($item->value2 ?? 0,1) ?? 0}}"></td>
    <td><input type="text" class="form-control" name="first_value" value="{{ $item->first_value }}"></td>
    <td> {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}</td>
    {!! Form::close() !!}

    {!! Form::open(['route' =>[ 'commissionssalein.setting.delete' , $item->id ], 'method' => 'delete']) !!}
    <td> {!! Form::submit('ลบ', ['class' => 'btn btn-danger']) !!}</td>
    {!! Form::close() !!}
</tr>
