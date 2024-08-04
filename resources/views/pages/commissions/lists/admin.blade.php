@php
$role = Auth::user()->role();
@endphp
<table id="data-table-default" class="table table-striped table-bordered dataTable">
    <thead>
        <tr class="text-center">
            <th width="1%">No.</th>
            <th>Name</th>
            <th>Position</th>
            <th>Mortgage</th>
            <th>Approve Limit</th>
            {{-- <th>Commission (%)</th> --}}
            <th>Commission-wht</th>
            @if ($role->name == 'Account' ||
            $role->name == 'Admin' )
            <th>จ่าย</th>
            <th>สถานะ</th>
            <th>แก้ไข</th>
            @endif
        </tr>
    </thead>
    <tbody>

        @php
        $total = 0;

        @endphp
        @foreach ($commissions as $key => $commission)

        @php
        $totalApprove = 0;
        $sum_mortgage = 0;
        $sum_approve_limit = 0;
        $sum = 0;
        $status = 0;
        @endphp

        @foreach ($commission['commission'] as $item)

        @php
        $sum_mortgage += $item->sum_mortgage;
        $sum_approve_limit += $item->sum_approve_limit;
        $sum += $item->sum;
        $status += $item->sum;

        @endphp

        @endforeach

        <tr>
            <td class="text-center">{{$loop->index+1}}</td>
            {{-- <td><a href="{{route('users.show', $commission['user']->id)}}">
            {{$commission['user']->name_th}}
            </a> </td> --}}

            <td>
                @if ($role->name == 'Account' || $role->name == 'Admin')
                <a href="{{route('users.show', $commission['user']->id)}}">
                    {{$commission['user']->name_th}}
                </a>
                @else


                @if ($commission['user']->id == Auth::id())
                <a href="{{route('users.show', $commission['user']->id)}}">
                    {{$commission['user']->name_th}}
                </a>
                @else
                {{$commission['user']->name_th}}
                @endif
                @endif
            </td>

            <td class="text-center">{{$commission['user']->role($commission['user']->id)->name}}</td>
            <td class="text-center">{{$sum_mortgage}}</td>
            <td class="text-right">{{ number_format($sum_approve_limit,2)}}</td>
            {{-- <td class="text-right">{{ $commission['user']->role()->commission}}</td> --}}
            <td class="text-right">{{ number_format($sum,2)}}</td>
            @if ($role->name == 'Account' || $role->name == 'Admin')
            <td class="text-center">
                @if ($item->status == 0)
                <span class="text-danger">ยังไม่จ่าย</span>
                @else
                <span class="text-success">จ่ายแล้ว</span>
                @endif
            </td>
            <td  class="text-center">

                @if ($item->status == 0)
                    {{Form::open(['route' => ['commissions.approved' ,1] ,'method' => 'post'])}}
                    {{Form::submit('กดเพื่ออนุมัติ',['class' => 'btn btn-primary']) }}
                    {{Form::close()}}
                @else
                อนุมัติแล้ว
                @endif
                </td>
            <td>
                @if ($item->status == 0)
                <a href="javascript:;" class="btn btn-primary"  onclick="edit_commission('{{$commission['user']->id}}')">แก้ไข</a>
                @endif

            </td>
            @endif
        </tr>
        @php
        $total += $sum ;

        if($loop->index == 0){

        $sumAll_mortgage = $sum_mortgage ;
        $sumAll_totalApprove = $sum_approve_limit;
        }
        @endphp
        @endforeach

    </tbody>
    @if ( !empty($commissions))
    <tr>
        <td>รวม</td>
        <td></td>
        <td></td>
        <td class="text-center">{{ $sumAll_mortgage}}</td>
        <td class="text-right">{{number_format( $sumAll_totalApprove,2)}}</td>
        <td class="text-right">{{number_format( $total,2)}}</td>
        @if ($role->name == 'Account' || $role->name == 'Admin')
        <td class="text-right"> </td>
        @endif
        <td></td>
        <td></td>

    </tr>
    @endif

</table>
