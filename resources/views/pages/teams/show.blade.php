@extends('layouts.loged')
@section('title', 'Teams')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            

            <div class="card">
                <div class="card-header">Team</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="1%">No.</th>
                                <th class="text-center">Team Name</th>
                                <th class="text-center">Leader Name</th>
                                <th width="1%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $team)
                                <tr>
                                    <td class="text-center">{{$loop->index+1}}</td>
                                    <td class="text-center">{{$team->name}}</td>
                                    <td class="text-center">
                                        @if($team->leader()->first())
                                        {{ $team->leader()->first()->thai_name }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <ul  class="m-auto p-0 list-unstyled">
                                            <li class="dropdown action-menu" >
                                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h pointer-cursor"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a  class="dropdown-item " onclick="model('{{$team->id}}',' {{$team->name}}','{{$team->sale_id}}')">Edit</a>
                                                        <div class="dropdown-divider"></div>
                                                    <a href="javascript:;" class="dropdown-item">Remove</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         {!! Form::open(['route' => ['teams.update' , 1] ,'method' => 'put' ,'id' =>'form_team'] ) !!}
                <div class="row mb-3 ">
                    <div class="col-md-12">
                        {{Form::input('text','name' ,'',['class'=>'form-control mb-2', 'id'=>'team_name', 'placeholder' => 'Team name' , 'required'])}}
                        {{Form::select('sale_id',$sales ,'',['class'=>'form-control  mb-2', 'id' => 'sale_id' ,'placeholder' => 'Leader name' ])}}
                        {{Form::input('hidden','team_id' ,'', ['id' => 'team_id'  ])}}
                    </div>
                    <div class="col-md-12">
                        {{Form::submit('Save Change' ,['class'=>'btn btn-primary'])}}
                    </div>
                </div>
            {{form::close()}}
      </div>

    </div>
  </div>
</div>


</div>

@endsection

@push('scripts')
<script>
        function model(id, name, sale_id){
            $('#sale_id').val(sale_id);
            $('#team_name').val(name);
            $('#team_id').val(id);
            $('#exampleModalLong').modal()
        }

</script>
@endpush
