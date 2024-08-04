@php

$role = Auth::user()->role();

$sum_point = 0;
$total = 0 ;

@endphp
<table id="data-table-default" class="table table-striped table-bordered dataTable">
    <thead>
        <tr class="text-center">
            <th width="1%">No.</th>
            <th width="200px;">Name</th>
            <th>Position</th>
            <th>Mortgage</th>
            <th>Point</th>
            <th>Approve Limit</th>
            {{-- <th>Commission (%)</th> --}}
            <th>Commission-wht</th>
            <th>วันสรุปยอด</th>
            @if ($role->name == 'Account' ||
            $role->name == 'Admin' )
            <th>จ่าย</th>
            <th>สถานะ</th>
            <th>แก้ไข</th>
            @endif
            <th>รายละเอียด</th>
        </tr>
    </thead>
    <tbody>
            @if ($commissions)

        @foreach ($commissions as $key => $commission)
            <tr>
                <td class="text-center">{{($key+1)}}</td>
                <td>
                <a href="{{route('salein.edit', $commission->user_id)}}">
                    {{$commission->name_th}}
                </a>
                </td>
                <td class="text-center">{{$commission->position_name}}</td>
                <td class="text-center">{{$commission->mortgage}}</td>
                <td class="text-center">{{ $commission->point ? $commission->point  : '-'  }}</td>
                <td class="text-right">{{ number_format($commission->approve_limit,2) }}</td>
                <td class="text-right">{{ number_format($commission->total,2)}}</td>
                <td class="text-right">{{ date('d/m/Y', strtotime($commission->created_at)) }}</td>
                   @if ($role->name == 'Account' || $role->name == 'Admin' )
                    <td  class="text-center">
                        @if ($commission->approved == 0)
                        <span class="text-danger">ยังไม่จ่าย</span>
                        @else
                        <span class="text-success">จ่ายแล้ว</span>
                        @endif
                    </td>

                <td  class="text-center">
                    @if ($commission->approved == 0)
                    {{Form::open(['route' => ['commissionssalein.approved' , $commission->id] ,'method' => 'post'])}}
                    {{Form::submit('กดเพื่ออนุมัติ',['class' => 'btn btn-primary']) }}
                    {{Form::close()}}
                    @else
                    อนุมัติแล้ว
                    @endif
                </td>
                <td>
                    @if ($commission->approved == 0)
                    <a href="javascript:;" class="btn btn-primary"  onclick="edit_commission('{{$commission->id}}')">แก้ไข</a>
                    @endif

                </td>
                @endif
                <td>
                    @if ($commission->position_name == 'Vice President of Sales Distribution-Internal')
                        <a href="javascript:;"  onclick="get_commissionVP('{{$commission->id}}')" >รายละเอียด</a>
                    @else
                        @php
                            $staff = explode(' ',$commission->position_name);
                            $staff = strtolower(end($staff));
                        @endphp
                        @if ($staff == 'daily')
                            <a href="javascript:;"  onclick="get_commission_daily('{{$commission->id}}')" >รายละเอียด</a>
                        @else
                            <a href="javascript:;"  onclick="get_commission('{{$commission->id}}')" >รายละเอียด</a>
                        @endif
                    @endif
                </td>
            </tr>
@if ($key == 0)
@php
    // $sumAll_mortgage += $commission->mortgage;
    // $sumAll_totalApprove += $commission->approve_limit;
@endphp
@endif
@php
    $total += $commission->total;
    $sum_point += $commission->point;
@endphp
        @endforeach

            @endif

    </tbody>

    @if ( !empty($commissions))
    <tr style="font-weight: bold;">
        <td>รวม</td>
        <td></td>
        <td></td>

        <td class="text-center">{{ $sumMortgage}}</td>
        <td class="text-center">{{$sum_point}} </td>
        <td class="text-right">{{number_format( $approve_limit,2)}}</td>
        <td class="text-right">{{number_format( $total,2)}}</td>
        <td></td>

        @if ($role->name == 'Account' ||
            $role->name == 'Admin' )
        <td></td>
        <td></td>
        <td></td>
        @endif
        <td></td>

    </tr>
    @endif

</table>


<!-- The Modal -->
<div class="modal fade" id="commission_detail">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><span id=" "></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                <table class="table ">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>point</th>
                            <th>approve limit</th>
                            <th>customer name</th>
                            <th><span id="coloumn-sale"></span></th>
                            <th>วันโอน</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>


<!-- The Modal -->
<div class="modal fade" id="commission_edit">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><span id="heading"></span></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">

                {!! Form::open(['route' => 'commissionssalein.update' ,'method' => 'post']) !!}
                {!! Form::hidden('id', 0, ['id' => 'id']) !!}

                <div class="form-group ">

                    {!! Form::label('approve_limit', 'Approved (Baht)', ['class' => '']) !!}
                    {!! Form::number('approve_limit',0, ['class' => 'form-control' , 'id' =>'approve_limit','readonly'=>
                    true]) !!}
                </div>

                <div class="form-group ">

                    {!! Form::label('total', 'total', ['class' => '']) !!}
                    {!! Form::number('total',0, ['class' => 'form-control' , 'id' =>'total', 'step'=>'any' ]) !!}
                </div>

                <div class="form-group text-center">
                    {!! Form::submit('อัพเดท', ['class' => 'btn btn-primary']) !!}
                </div>


                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>
@push('scripts')

<script>

    function get_commissionVP(id ){
    axios.get(`/api/pointvp/${id}`).then( res =>{
        $('#coloumn-sale').html('leader name');
            $('#commission_detail').modal();
            $('#tbody').html('')
            let text = '';
            let data = res.data
            let i = 1;
            data.forEach(element => {
                $('#tbody').append(`<tr><td>${i}</td><td  class="text-right">${element.point}</td><td class="text-right">${element.approve_limit}</td><td>${element.customer_name}</td><td>${element.sale_name}</td><td>${element.created_at}</td></tr>`)
                i++;
            });
        })
    }


    function get_commission_daily(id) {

         axios.get(`/api/pointdaily/${id}`).then( res =>{

            $('#coloumn-sale').html('sale name');

            $('#commission_detail').modal();
            $('#tbody').html('')
            let text = '';
            let data = res.data
            let i = 1;
            data.forEach(element => {
                $('#tbody').append(`<tr><td>${i}</td><td  class="text-right">${element.point}</td><td class="text-right">${element.approve_limit}</td><td>${element.customer_name}</td><td>${element.sale_name}</td><td>${element.created_at}</td></tr>`)
                i++;
            });
        })
    }

    function get_commission(id ){
    axios.get(`/api/point/${id}`).then( res =>{
        $('#coloumn-sale').html('sale name');

            $('#commission_detail').modal();
            $('#tbody').html('')
            let text = '';
            let data = res.data
            let i = 1;
            data.forEach(element => {
                $('#tbody').append(`<tr><td>${i}</td><td  class="text-right">${element.point}</td><td class="text-right">${element.approve_limit}</td><td>${element.customer_name}</td><td>${element.sale_name}</td><td>${element.created_at}</td></tr>`)
                i++;
            });
        })
    }

    function edit_commission(commission){

        axios.get(`/api/commissionsalein/${commission}`).then( res =>{
            let customer = res.data;
            $('#heading').html(customer.customer_name)
            $('#id').val(customer.id)
            $('#commission').val(customer.commission)
            $('#total').val(customer.total)
            $('#approve_limit').val(customer.approve_limit)

            $('#commission_edit').modal();

        })

    }

    </script>
@endpush
