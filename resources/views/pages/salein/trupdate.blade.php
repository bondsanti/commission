<tr>
    {!! Form::open(['route' =>[ 'commissionssalein.setting.put' , $item->id ], 'method' => 'put']) !!}
        {!! Form::hidden('key', 'commission') !!}
        <td>{{ $key+1}}</td>
        <td><input type="text" class="form-control" name="first_value" value="{{$item->first_value}}" ></td>
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

</tr>
