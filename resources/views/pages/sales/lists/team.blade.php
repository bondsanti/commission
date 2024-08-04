@foreach ($teams as $team)
<div class="row">
    <div class="col-lg-12">
        <a href="/user?team_id={{$team->id}}"> Team ID:{{ $team->name }}</a>
    </div>
</div>
@endforeach
