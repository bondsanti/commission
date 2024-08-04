@if( count($roleLog) > 0 )
<table id="data-table-default" class="table table-striped table-bordered">
    <thead class="text-center">
        <td width="1%">No.</td>
        <td class="text-left">Name</td>
        <td>Team</td>
        <td>ตำแหน่งปัจจุบัน</td>
        <td>ขึ้น-ลง ตำแหน่ง</td>
        <td width="1%">Status</td>
        <td width="1%">Approve</td>
        <td>รายละเอียด</td>
        <td>Updated</td>
    </thead>
    <tbody>
        @foreach ($roleLog as $item)

        <tr class="text-center">
            <td>{{$loop->index+1}}</td>
            <td class="text-left"><a href="{{route('users.show',$item->users()->first()->id)}}">
                    {{ $item->users()->first()->name_th }}</a></td>
            <td>{{ $item->users()->first()->teams()->first()->name }} </td>
            <td>{{ $item->roleBefore()->first()->name }} </td>
            <td>{{ $item->roleAfter()->first()->name }} </td>
            <td>
                @if($item->action == 'up')
                <i class="fas fa-chevron-circle-up fa-lg" style="color:#38c172"></i>
                @else
                <i class="fas fa-chevron-circle-down fa-lg" style="color:#e3342f"></i>
                @endif
            </td>
            <td class="border-0 d-inline-flex">
                {{Form::open([ 'route'=> ['users.approve' , $item->id], 'method' => 'post'])}}
                <button type="submit" class="bg-transparent border-0"><i
                        class="fas fa-check-circle text-success fa-lg"></i></button>
                {{Form::close()}}
                {{Form::open([ 'route'=> ['users.reject' , $item->id], 'method' => 'post'])}}
                <button type="submit" class="bg-transparent border-0"><i
                        class="fas fa-times-circle text-danger fa-lg"></i></button>
                {{Form::close()}}
            </td>
            <td>
                <a href="#" class="promote-detail" data-name="{{ $item->users()->first()->name_th }}"
                    data-id="{{$item->user_id}}">รายละเอียด</a>
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

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><span id="modal-title-text"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        <tr>
                            <td>Code.</td>
                            <td>ชื่อ</td>
                            <td>ตำแหน่ง</td>
                            <td>Mortgage</td>
                        </tr>
                    </thead>
                    <tbody id="tbody-list">


                    </tbody>
                    <tr>
                        <td colspan="3">รวม</td>
                        <td><span id="sum"></td>
                    </tr>
                </table>
            </div>

            <!-- Modal footer -->
        </div>
    </div>
</div>
@push('scripts')

<script>
    $('.promote-detail').click((e)=>{
        let name = e.target.getAttribute('data-name')
        let id = e.target.getAttribute('data-id')
        $('#modal-title-text').html(name);
        $('#myModal').modal();
        let text= '';
        $('#tbody-list').html('');
        let  sum = 0;
        axios.get(`/api/users/promote/${id}`).then((response)=>{

            for (let index = 0; index < response.data.length; index++) {
                let element = response.data[index];
                sum += element.mortgage;
                text += `<tr><td>${element.code}</td><td>${element.thai_name}</td><td>${element.role.name}</td><td>${element.mortgage}</td></tr>`;
            }
            $('#tbody-list').append(`${text}`)
            $('#sum').html(`${sum}`)
        })
    })
</script>
@endpush
