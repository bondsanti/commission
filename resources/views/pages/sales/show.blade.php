@extends('layouts.loged')


@section('content')
<div class=" " style="padding: 30px;">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                    @include('pages.sales.card')

                        </div>
                        <div class="col-md-6">




                    <div class="form-group row">
                        {{Form::label('Code','Code ', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Code',$sale->code, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Thai name','Thai Name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Thai name',$sale->name_th, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('Thai name','English Name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('English name',$sale->name_eng, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}

                    </div>

                    <div class="form-group row">
                        {{Form::label('Email','Email', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Email', $sale->email, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>

                    @isset($sale->companies->company_th)

                    <div class="form-group row">
                        {{Form::label('Companies','Company', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Companies',$sale->companies->company_th, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>
                    @endisset
                    @isset($sale->teams->name)

                    <div class="form-group row">
                        {{Form::label('Team', 'Team Name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Team',$sale->teams->name , ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>
                    @endisset

                    @if($sale->sub_team_id > 0 && $sale->sub_team_id != null)
                    <div class="form-group row">
                        {{Form::label('sub team', 'Sub name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('sub team', $sale->sub_team->role()->short_code.'  '.$sale->sub_team->name_th, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>
                    @endisset

                    <div class="form-group row">
                        {{Form::label('Position','Position', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('Position',$sale->role()->name, ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>

                    <div class="form-group row">
                        {{Form::label('join date', 'Join Date', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                        {{Form::label('join date',
                            ($sale->created_at) ?
                            date('d M Y' ,strtotime($sale->created_at))
                            :
                            '-'
                            , ['class' => 'col-md-4 offset-md-1 col-form-label font-weight-light'])}}
                    </div>

                    @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name == 'Support' )
                    <div class="form-group row justify-content-center">
                        <a href="{{route('users.edit', $sale->id)}}" class="btn btn-primary">แก้ไข</a>
                    </div>
                    @endif

                </div>
            </div>
                                </div>
                    </div>
            {{-- end Card --}}
        </div>
    </div>
</div>
<div class=" " style="padding:30px;">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{-- start Card --}}
            <div class="card">
                <div class="card-header">Commission</div>
                <div class="card-body text-center overflow-auto">
                    @if( count($commissions) > 0 )

                    <table id="data-table-default" class="table table-striped table-bordered dataTable">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th>Name (ชื่อลูกค้า) </th>
                                <th>Sale (ที่ขายได้) </th>
                                <th>Mortgage</th>
                                <th>Approve Limit (บาท)</th>
                                {{-- <th>Commission (%)</th> --}}
                                <th>Commission-wht</th>
                                <th>Date</th>
                                @if (Auth::user()->role()->name == 'Account' ||
                                Auth::user()->role()->name == 'Admin' )
                                <th>จ่าย</th>
                                @endif
                                <th>สถานะ</th>
                                <th>แก้ไข </th>
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
                                <td>{{$commission->customer_name}}</td>
                                <td><a
                                        href="{{route('users.show',$commission->sale_id)}}">{{$commission->sales->name_th}}</a>
                                </td>
                                <td>1</td>
                                <td class="text-right">{{ number_format($commission->approve_limit,2) }} </td>
                                {{-- <td>{{ $commission->commission }} </td> --}}
                                <td class="text-right">{{ number_format($commission->total,2) }}</td>
                                <td>{{date('d/m/Y', strtotime($commission->updated_at))}}</td>
                                @if (Auth::user()->role()->name == 'Account' ||
                                Auth::user()->role()->name == 'Admin' )
                                <td class="text-center">
                                    @if ($commission->status== 0)
                                    {{Form::open(['route' => ['commissions.paid' , $commission->id] ,'method' => 'post'])}}
                                    {{Form::submit('จ่ายเงิน',['class' => 'btn btn-primary']) }}
                                    {{Form::close()}}
                                    @else
                                    จ่ายแล้ว
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($commission->apprpoved == 0)
                                    {{Form::open(['route' => ['commissions.approved' , $commission->id] ,'method' => 'post'])}}
                                    {{Form::submit('อนุมัติ',['class' => 'btn btn-primary']) }}
                                    {{Form::close()}}
                                    @else
                                    อนุมัติแล้ว
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="javascript:;" class="btn btn-primary"
                                        onclick="edit_commission('{{$commission->id}}')">แก้ไข</a>
                                </td>
                                @else


                                <td>@if ($commission->status== 0)
                                    ยังไม่จ่าย
                                    @else
                                    จ่ายแล้ว
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @php
                            $total = $commission->total + $total;
                            $totalApprove = $commission->approve_limit + $totalApprove;
                            @endphp
                            @endforeach
                        </tbody>
                        @if ( !empty($commissions))
                        <tr>
                            <td>รวม</td>
                            <td></td>
                            <td></td>
                            <td>{{count($commissions)}}</td>
                            <td class="text-right">{{number_format( $totalApprove,2)}}</td>
                            <td class="text-right">{{number_format( $total,2)}}</td>
                            <td></td>
                            @if (Auth::user()->role()->name == 'Account' ||
                            Auth::user()->role()->name == 'Admin' )
                            <td></td>
                            <td></td>
                            <td></td>
                            @else
                            <td></td>
                            @endif
                        </tr>
                        @endif
                    </table>
                    @else

                    ไม่มีข้อมูล

                    @endif

                </div>
            </div>
            {{-- end Card --}}

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

                {!! Form::open(['route' => 'commission.update' ,'method' => 'post']) !!}
                {!! Form::hidden('id', 0, ['id' => 'id']) !!}

                <div class="form-group ">

                    {!! Form::label('approve_limit', 'Approved (Baht)', ['class' => '']) !!}
                    {!! Form::number('approve_limit',0, ['class' => 'form-control' , 'id' =>'approve_limit','readonly'=>
                    true]) !!}
                </div>

                <div class="form-group ">

                    {!! Form::label('commission', 'commission (%)', ['class' => '']) !!}
                    {!! Form::number('commission',0, ['class' => 'form-control' , 'id' =>'commission',
                    'step'=>'any' ])
                    !!}
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

@endsection

@push('scripts')

<script>
    function pay(data){
            $('#billing').modal();

        }

    function edit_commission(commission){

        axios.get(`/api/commission/${commission}`).then( res =>{
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
