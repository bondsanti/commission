@php
$role = Auth::user()->role()->name;
$i = 0;
$ii = 0;
$iii = 0;
@endphp


<h4>Total {{ number_format($countAgents) }}</h4>
<table id="tree-table" class="table table-responsive table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Code</th>
            <th width="50%" class="text-left">Sale Name</th>
            <th width="20%">Potision</th>
            @if($role == 'Admin' ||
            $role == 'Authorizer' ||
            $role == 'Support'
            )
            <th width="1%">Actions</th>
            @endif
        </tr>
    </thead>
        <tbody>
        @foreach ($agents as $key => $item)
        
        <tr class="team-color" data-id="{{$key+1}}" data-parent="0" data-level="1">
            <td><div data-column="name"></div></td>
            <td>{{$item['teams']->name}}</td>
            <td><div data-column="total"></div></td>
            <td colspan="2"></td>
        </tr>
        @isset($item['subteams'])
        @foreach ($item['subteams'] as $subteams)

        @isset($subteams['sub'])
       
        <tr class="subteam-color" data-id="{{$subteams['sub']->code}}" data-parent="{{$key+1}}" data-level="2">
                    <td>
                        <div data-column="name"><i class="fas fa-plus fa-lg"></i></div>
                    </td>
                    <td>{{$subteams['sub']->code}}</td>
                    <td>{{$subteams['sub']->name_th}}</td>
                    <td></td>
                    <td></td>
                </tr>
            
            @foreach ($subteams['users'] as $i => $subteam)
                @php
                $ii=1000;
                @endphp
                @if ($subteams['sub']->code == $subteam->code)
                @php
                continue;
                @endphp
                @endif

            <tr dclass="clickable" data-id="{{$subteam->code}}" data-parent="{{$key+1}}" data-level="3">
                <td><div data-column="name"><i class="fas fa-minus fa-lg"></i></div></td>
                <td>{{$subteam->code}}</td>
                <td>{{$subteam->name_th}}</td>
                <td>{{$subteam->roles->name}}</td>
                {{-- <td>{{$subteam->name}}</td> --}}
                <td>
                    <ul class="m-auto p-0 list-unstyled">
                        <li class="dropdown action-menu">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-ellipsis-h pointer-cursor"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{url('/users/')}}/{{$subteam->id}}/edit" class="dropdown-item">Edit</a>
            
                                @if ($role == 'Admin')
                                <div class="dropdown-divider"></div>
                                {{Form::open(['route' => ['users.destroy', $subteam->id] , 'method' => 'delete'])}}
                                {{Form::submit('Remove' , ['class' => 'dropdown-item'])}}
                                {{Form::close()}}
                                @endif
            
                            </div>
                        </li>
                    </ul>
                </td>
            </tr>
        @endforeach
        @endisset

        @php
         $i++;
        @endphp

        @endforeach
        @endisset
     @endforeach
        
        </tbody>

        
    
</table>

<style>
    .team-color{
        background-color:#fca903;
    }
    .subteam-color{
       background-color:#f7e9cd;
    }
    i{
        cursor: pointer;
    }
    
</style>

    {{-- <table class="table table-responsive table-hover" id="tree-table">  
        <tbody>
        <th>#</th>
        <th>Test</th>
        <tr data-id="1" data-parent="0" data-level="1">
        <td><div data-column="name"><i class="fas fa-plus fa-lg"></i></div></td>
        <td>Additional info</td>
        </tr>
        <tr data-id="2" data-parent="1" data-level="2">
        <td><div data-column="name"><i class="fas fa-plus fa-lg"></i></div></td>
        <td>Additional info</td>
        </tr>
        <tr data-id="3" data-parent="2" data-level="2">
        <td><div data-column="name"><i class="fas fa-plus fa-lg"></i></div></td>
        <td>Additional info</td>
        </tr>
        <tr data-id="4" data-parent="2" data-level="2">
        <td><div data-column="name"><i class="fas fa-plus fa-lg"></i></div>Team4</td>
        <td>Additional info</td>
        </tr>
        <tr data-id="5" data-parent="2" data-level="3">
        <td >Team5</td>
        <td>Additional info</td>
        </tr>
        <tr data-id="6" data-parent="2" data-level="3">
            <td data-column="name">Team6</td>
            <td>Additional info</td>
            </tr>
        </tbody>
        
   </table> --}}
   {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> --}}

