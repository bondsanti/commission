@php
$role = Auth::user()->role()->name;
@endphp
<h2>Total {{ $count }} </h2> 
<table class="table table-responsive table-hover">
    {{ $teams->links() }}
    <thead>
        <tr>
            <th>No.</th>
            <th>Code</th>
            <th width="50%" class="text-left">Sale Name</th>
            <th width="10%">Potision</th>
            @if($role == 'Admin' ||
            $role == 'Authorizer' ||
            $role == 'Support'
            )
            <th width="1%">Actions</th>
            @endif
        </tr>
    </thead>
    @php
    $z = 0;
    @endphp


    @foreach ($agents as $key => $item)

    <tbody>
        <tr class="clickable " data-toggle="collapse" data-target=".group-of-rows-{{$key}}" aria-expanded="false"
            aria-controls="group-of-rows-{{$key}}">

            <td><i class="fas fa-plus"></i></td>
            <td colspan="4">{{$item['teams']->name}}</td>
        </tr>
    </tbody>


    @isset($item['subteams'])

    @foreach ($item['subteams'] as $subteams)
    @isset($subteams['sub'])
    <tbody class="collapse group-of-rows-{{$key}}">
        <tr class="clickable leader " data-toggle="collapse" data-target=".list-of-rows-{{$z}}" aria-expanded="false"
            aria-controls="list-of-rows-{{$z}}">
            <td><i class="fas fa-plus"></i></td>
            <td>{{$subteams['sub']->code}}</td>
            <td>{{$subteams['sub']->name_th}}</td>
            {{-- <td>{{ ($subteams['sub']->role()) ? $subteams['sub']->role()->name : ''  }}</td> --}}
            <td></td>
            <td class="text-center">
                <ul class="m-auto p-0 list-unstyled">
                    <li class="dropdown action-menu">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-ellipsis-h pointer-cursor"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('/users/')}}/{{$subteams['sub']->id}}/edit"
                                class="dropdown-item">Edit</a>

                            @if ($role == 'Admin')
                            <div class="dropdown-divider"></div>
                            {{Form::open(['route' => ['users.destroy', $subteams['sub']->id] , 'method' => 'delete'])}}
                            {{Form::submit('Remove' , ['class' => 'dropdown-item'])}}
                            {{Form::close()}}
                            @endif

                        </div>
                    </li>
                </ul>
            </td>
        </tr>
    </tbody>


    @foreach ($subteams['users'] as $i => $subteam)

    @if ($subteams['sub']->code == $subteam->code)
    @php
    continue;
    @endphp
    @endif
    <tbody class="collapse list-of-rows-{{$z}}">
        <tr>
            <td><i class="fas fa-minus"></i></td>
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
    </tbody>

    @endforeach
    @endisset
    @php
    $z++;
    @endphp
    @endforeach
    @endisset
    @endforeach
</table>

