@php
$role = Auth::user()->role()->name;
@endphp
<h2>Total {{ $count }}</h2>
<table class="table table-responsive table-hover">
    <thead>
        <tr>
            <th>No.</th>
            <th>Team Name</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($agents as $key => $item)
        <tr data-id="{{$item['teams']->id}}" class="clickable-show cursor-pointer">
            <td>{{ $loop->index+1 }}</td>
            <td>{{$item['teams']->name}}</td>
        </tr>

        @endforeach
    </tbody>

</table>


<script>
    $( () =>{
    $('.clickable-show').click( e =>{
        let id = e.currentTarget.getAttribute('data-id')
        window.location = `/user?team_id=${id}`
    })
})

</script>
