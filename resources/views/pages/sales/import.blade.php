

@extends('layouts.loged')
@section('title', 'Add Sale')

@push('css')

@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            

            <div class="card">
                <div class="card-header">Create Sale</div>

                <div class="card-body">
                    {{Form::open(['route' => ['users.import.excel'] , 'method' => 'post', 'files' => true])}}

                        <input type="file" name="files">

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
    
@endpush