@extends('layouts.loged')

@section('title', 'Commission')

@push('css')
	<link href="/assets/plugins/datatables/css/dataTables.bootstrap4.css" rel="stylesheet" />
	<link href="/assets/plugins/datatables/css/responsive/responsive.bootstrap4.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            

            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    {{Form::open(['route' => ['commissions.store'] , 'method' => 'post'])}}
                        
                        {{-- <div class="form-group row">
                            {{Form::label('Name','Name', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::input('text', 'total', '',['class' => 'form-control col-md-7' ,'required' => true])}}
                        </div> --}}

                        <div class="form-group row">
                            {{Form::label('วงเงินอนุมัติ','วงเงินอนุมัติ', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::input('number', 'approve_limit', '',['class' => 'form-control col-md-7' ,'required' => true])}}
                            {{Form::label('บาท','บาท', ['class' => 'col-md-1 col-form-label'])}}

                        </div>

                         <div class="form-group row">
                            {{Form::label('ผู้โอน','ผู้โอน', ['class' => 'col-md-3 offset-md-1 col-form-label'])}}
                            {{Form::select('user_id', $users , '',['class' => 'form-control col-md-7' ,'required' => true])}}
                        </div>
                    
                    

                        <div class="form-group row justify-content-center">
                            {{Form::submit('Save', ['class' => 'btn btn-primary my-3 '])}}
                        </div>

                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
	<script src="/assets/plugins/datatables/js/jquery.dataTables.js"></script>
	<script src="/assets/plugins/datatables/js/dataTables.bootstrap4.js"></script>
	<script src="/assets/plugins/datatables/js/responsive/dataTables.responsive.js"></script>
	<script src="/assets/plugins/datatables/js/responsive/responsive.bootstrap4.js"></script>
	<script>
		$(document).ready(function() {
			TableManageDefault.init();
		});
	</script>
@endpush