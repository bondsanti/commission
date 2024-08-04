@php

$months =
// DB::select( DB::raw(" SELECT month(created_at) as month , sum(total) as total FROM `commission_salein` WHERE `code` =
// $sale->code
// GROUP BY `created_at` "));

DB::select( DB::raw(" SELECT month(created_at) as month FROM `points` WHERE `code` = $sale->code GROUP BY `month`
"));

@endphp

@if (count($months) > 0)


<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>เดือน</th>
            <th>รวม</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($months as $item)

        <tr>
            <td>{{$loop->index+1}}</td>
            {{-- <td>{{  date("F", mktime(0, 0, 0, $item->month, 10))    }}</td> --}}
            <td><a
                    href="{{route('salein.commission', $sale->id)}}?type=month&month={{ $item->month }}&year={{date('Y')}} ">{{  date("F", mktime(0, 0, 0, $item->month, 10))    }}</a>
            </td>

            @php
            $total = DB::table('commission_salein')->where('code',$sale->code)->whereMonth('created_at', $item->month
            )->first();
            @endphp


            <td>{{ ($total )? $total : number_format(0,2) }}</td>
        </tr>
        @endforeach
    </tbody>

</table>


{{--
<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Position</th>
            <th>Mortgage</th>
            <th>Approve Limit</th>
            <th>Commission-wht</th>
            <th>จ่าย</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($commissions as $item)
        <tr>
            <td>{{$loop->index+1}}</td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
@endforeach
</tbody>

</table> --}}

@else
ไม่มีข้อมูล

@endif
