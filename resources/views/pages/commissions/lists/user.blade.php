{{-- <table class="table table-striped table-bordered "> --}}
<table id="data-table-default" class="table table-striped table-bordered dataTable">
    <thead>
        <tr class="text-center">
            <th width="1%">No.</th>
            <th class="text-left">ID </th>
            <th>Sale Name</th>
            <th>Position</th>
            <th>Updated </th>
            <th>Commission-wht</th>
        </tr>
    </thead>
    <tbody>
        @php
        $total = 0;
        $totalApprove = 0;
        @endphp
        @foreach ($commissions as $commission)
        <tr>
            <td class="text-center">{{$loop->index+1}}</td>
            <td>{{$commission->id}}</td>
            <td><a href="{{route('users.show', $commission->user_id)}}">{{$commission->users->name_th}}</a>
            </td>
            <td class="text-center">{{$commission->users()->first()->role()->name}}</td>
            <td class="text-center">{{ date('d M Y' , strtotime($commission->updated_at)) }}</td>
            <td class="text-right">{{ number_format($commission->total,2)}}</td>
        </tr>
        @php
        $total = $commission->total + $total;
        $totalApprove = $commission->total + $total;
        @endphp
        @endforeach
    </tbody>
    <tr>
        <td>รวม</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-right">{{number_format( $total,2)}}</td>
        {{-- <td class="text-right">{{number_format( $total,2)}}</td> --}}
    </tr>

</table>
