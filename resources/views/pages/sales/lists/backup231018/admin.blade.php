@php
$role = Auth::user()->role()->name;
$i = 0;

@endphp
<h4>Total {{ number_format($data['total_user_count']) }}</h4>

<table id="tree-table" class="table table-responsive table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Count</th>
            <th>Code</th>
            <th width="50%" class="text-left">Sale Name</th>
            <th width="20%">Potision</th>
            @if($role == 'Admin' || $role == 'Authorizer' || $role == 'Support')
            <th width="1%">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $key => $item)
        @if (is_numeric($key))
        <tr class="team-color" data-id="{{$key+1}}" data-parent="0" data-level="1">
            <td><div data-column="name"></div></td>
            <td class="text-center">{{ $item['user_count'] }} คน</td>
            <td>{{ $item['team']->name }}</td>
            <td><div data-column="total"></div></td>
            <td colspan="2"></td>
        </tr>
        @foreach ($item['users'] as $user)
        @if ($user->sub_team_id == 0)
        <tr class="subteam-color" data-id="{{ $user->id }}" data-parent="{{ $key+1}}" data-level="2" style="display:none;">
            <td>
                <div data-column="name"></div>
            </td>
            <td></td>
            <td>{{ $user->code }}</td>
            <td>{{ $user->name_th }}</td>
            <td>{{ $user->roles ? $user->roles->name : '-' }}</td>
            <td>
                <ul class="m-auto p-0 list-unstyled">
                    <li class="dropdown action-menu">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-h pointer-cursor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('/users/')}}/{{$user->id}}/edit" class="dropdown-item">Edit</a>
        
                            @if ($role == 'Admin')
                            <div class="dropdown-divider"></div>
                            {{Form::open(['route' => ['users.destroy', $user->id] , 'method' => 'delete'])}}
                            {{Form::submit('Remove' , ['class' => 'dropdown-item'])}}
                            {{Form::close()}}
                            @endif
        
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        @endif
        
        <!-- Loop through users with sub_team_id matching current user's id -->
        @foreach ($item['users'] as $subUser)
        @if ($subUser->sub_team_id == $user->id)
        <tr class="subuser-color" data-id="{{ $subUser->id }}" data-parent="{{ $user->id }}" data-level="3" style="display:none;">
            <td></td>
            <td></td>
            <td>{{ $subUser->code }}</td>
            <td>{{ $subUser->name_th }}</td>
            <td>{{ $subUser->roles ? $subUser->roles->name : '-' }}</td>
            <td>
                <ul class="m-auto p-0 list-unstyled">
                    <li class="dropdown action-menu">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-h pointer-cursor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('/users/')}}/{{$subUser->id}}/edit" class="dropdown-item">Edit</a>
        
                            @if ($role == 'Admin')
                            <div class="dropdown-divider"></div>
                            {{Form::open(['route' => ['users.destroy', $subUser->id] , 'method' => 'delete'])}}
                            {{Form::submit('Remove' , ['class' => 'dropdown-item'])}}
                            {{Form::close()}}
                            @endif
        
                        </div>
                    </li>
                </ul>
            </td>
        </tr>
        @endif
        @endforeach
        @endforeach
        @endif
        @endforeach
    </tbody>
    
</table>

    
    
</table>



           

<style>
    .team-color {
        background-color: #fca903;
    }
    .subteam-color {
        background-color: #f7e9cd;
    }
    .subuser-color {
        background-color: #fcf8f0;
    }
    i {
        cursor: pointer;
    }
</style>
