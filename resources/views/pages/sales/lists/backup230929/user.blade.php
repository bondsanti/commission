@php
$role = Auth::user()->roles->name;
@endphp
<h2>Total {{ $count }}</h2>
<table class="table table-responsive table-hover">
    <thead width="100%">
        <tr>
            <th width="1%">No.</th>
            <th width="5%">Code</th>
            <th width="10%" class="text-left">Sale Name</th>
            <th width="10%">Potision</th>
        </tr>
    </thead>

    <tbody>
        <tr class="clickable  " data-toggle="collapse" aria-expanded="false">
            <td><i class="fas fa-plus"></i></td>
            <td>{{$agents['leader']->code}}</td>
            <td>{{$agents['leader']->name_th}}</td>
            <td>{{ ($agents['leader']->roles) ? $agents['leader']->roles->name : ''  }}</td>
        </tr>
    </tbody>


    {{--  --}}

    @isset($agents['subteams'])
    @php
    $z = 0;
    @endphp
    @foreach ($agents['subteams'] as $key => $subteams)
    <tbody class="collapse group-of-rows-{{$key}} show">
        <tr class="clickable leader " data-toggle="collapse" data-target=".list-of-rows-{{$key}}" aria-expanded="false"
            aria-controls="list-of-rows-{{$z}}">
            <td><i class="fas fa-plus"></i></td>
            <td>{{$subteams['sub']->code}}</td>
            <td>{{$subteams['sub']->name_th}}</td>
            <td>{{ ($subteams['sub']->roles) ? $subteams['sub']->roles->name : ''  }}</td>
        </tr>
    </tbody>



    @foreach ($subteams['users'] as $i => $subteam)
    @if ($subteams['sub']->code == $subteam->code)
    {{-- @php continue; @endphp --}}
    @continue
    @endif
    <tbody class="collapse list-of-rows-{{$key}}">
        <tr>
            <td><i class="fas fa-minus"></i></td>
            <td>{{$subteam->code}}</td>
            <td>{{$subteam->name_th}}</td>
            <td>{{ ($subteam->roles) ? $subteam->roles->name : '' }}</td>

        </tr>
    </tbody>
    @endforeach
    @php
    $z = 0;
    @endphp
    @endforeach

    @endisset



    {{--  --}}

    @foreach ($agents['users'] as $i => $agent)
    <tbody>
        <tr class="  " data-toggle="collapse" aria-expanded="false">
            <td><i class="fas fa-minus"></i></td>
            <td>{{$agent->code}}</td>
            <td>{{$agent->name_th}}</td>
            <td>{{ ($agent->roles) ? $agent->roles->name : ''  }}</td>

        </tr>
    </tbody>
    @endforeach
