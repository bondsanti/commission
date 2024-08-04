
@if( count($roleLogReject) > 0 )
<table id="data-table-default" class="table table-striped table-bordered">
    <thead class="text-center">
        <td width="1%">No.</td>
        <td class="text-left">Name</td>
        <td>Team</td>
        <td>ตำแหน่งปัจจุบัน</td>
        <td>ขึ้น-ลง ตำแหน่ง</td>
        <td width="1%">Status</td>
        <td width="1%">Approve</td>
        <td >รายละเอียด</td>
        <td >Updated</td>
    </thead>
    <tbody>
            @foreach ($roleLogReject as $item)
                <tr class="text-center" >
                    <td >{{$loop->index+1}}</td>
                    <td class="text-left"><a href="{{route('users.show',$item->users()->first()->id)}}"> {{ $item->users()->first()->thai_name }}</a></td>
                    <td>{{ $item->users()->first()->teams()->first()->name }} </td>
                    <td>{{ $item->roleBefore()->first()->name }} </td>
                    <td>{{ $item->roleAfter()->first()->name }} </td>
                    <td >
                        @if($item->action == 'up')
                            <i class="fas fa-chevron-circle-up fa-lg" style="color:#38c172"></i>
                        @else
                            <i class="fas fa-chevron-circle-down fa-lg" style="color:#e3342f"></i>
                        @endif
                    </td>
                    <td class="border-0 d-inline-flex">
                        {{Form::open([ 'route'=> ['users.approve' , $item->id], 'method' => 'post'])}}
                            <button type="submit" class="bg-transparent border-0"><i class="fas fa-check-circle text-success fa-lg"></i></button>
                        {{Form::close()}}
                    </td>
                    <td>
                        <a href="#" class="promote-detail" data-name="{{ $item->users()->first()->thai_name }}" data-id="{{$item->user_id}}">รายละเอียด</a>
                    </td>
                    <td>
                        {{ date( 'd M Y H:i', strtotime($item->updated_at .' + 543 years' ))}}
                    </td>
                </tr>
            @endforeach

    </tbody>
</table>
@else
<div class="text-center">
    ไม่มีข้อมูล
</div>
@endif