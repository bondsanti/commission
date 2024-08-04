@foreach ($subs as $sub)
<table>
    <tr>
        <td>{{ $loop->index+1 }}</td>

    </tr>
</table>

@endforeach

{{-- <div class="row"> --}}
{{-- <div class="col-lg-12"> --}}
{{-- <a href="/user?sub_team_id={{$sub->id}}">{{ $sub->name_th }}</a> --}}
{{-- </div> --}}
{{-- </div> --}}
