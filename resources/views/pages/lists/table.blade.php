@php
use Illuminate\Support\Str;
@endphp
{{-- <table id="data-table-default" class="table table-striped table-bordered text-center cursor-default text-ellipsis"
    style="font-size:12px;cursor: default;">
    <thead>
        <tr>
            <th width="1%">No.</th>
            <th> Team </th>
            <th> Sale ID </th>
            <th>Name</th>
           <!--<th> Tel </th>-->
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
        @foreach ($lists as $item)

        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>{{ $item->team_name }}</td>
            <td>{{ $item->subid }}</td>
            <td>{{ $item->name }}</td>
            <!--<td>{{ $item->tel }}</td>-->
            <td>{{ $item->bank }}</td>
            @php

            if ($item->status == 'Approved')
            $color = 'background-color: rgb(181, 222, 78);';
            elseif($item->status == 'Rejected')
            $color = 'background-color: rgb(255, 179, 179);';
            elseif($item->status =='Waiting')
            $color ='background-color: rgb(221, 221, 221);';
            elseif($item->status =='Pre-Approved')
            $color ='background-color: rgb(238, 255, 195);';
            else
            $color = '';

            @endphp
            <td style="{{$color}}"> {{ $item->status }} </td>
            <td>{{ ($item->project_name)? $item->project_name: '-' }}</td>
            <td>{{ ($item->Homeno )? $item->RoomNo: '-' }}</td>
            <td>{{ ($item->RoomNo) ? $item->RoomNo: '-' }}</td>
            <td>
                @if ($item->receiveddate)
                {{ date('d/m/Y', strtotime($item->receiveddate)) }}
                @else
                -
                @endif
            </td>
            <td>
                @if ($item->senddate)
                {{ date('d/m/Y', strtotime($item->senddate)) }}
                @else
                -
                @endif
            </td>
            <td>
                @if ($item->resultdate)
                {{ date('d/m/Y', strtotime($item->resultdate)) }}
                @else
                -
                @endif
            </td>
            @if ($item->reason != null)
            <td class="text-left cursor-pointer text-ellipsis">
                <span title="{{$item->reason}}">
                    {{ Str::limit($item->reason, 30) }}
                </span>
            </td>
            @else
            <td class="text-center">
                -
            </td>
            @endif

        </tr>
        @endforeach
    </tbody>



</table> --}}
        <!--Table-->
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                   

                    <div class="card-body table-responsive">
                        <table id="data-table-default" class="table table-hover table-striped text-nowrap">
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
        </div>