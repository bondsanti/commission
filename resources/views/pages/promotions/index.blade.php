@extends('layouts.loged')
@section('title', 'Promotion')
@section('content')
@php
use Illuminate\Support\Str;
@endphp
<div class="container">

    @foreach ($projects as $item)
    @if ( count($item->promotions) == 0 )
    @php
    continue;
    @endphp

    @endif
    <h4>
        {{ $item->name }}
    </h4>
    <div class="row ">
        @foreach ($item->promotions as $promotion)

        <div class="col-md-3 ">
            <a href="{{route('promotions.show', $promotion->id)}}" class="card-promotion-link">
                <div class=" card cursor-pointer card-promotion">
                    <div class="card-body p-10">
                        <div class="text-center">
                            @if ($promotion->image)
                            <img src="{{$promotion->image}}" alt="">
                            @else

                            <img src="/images/favicon.png" alt="">
                            @endif
                        </div>
                        <hr>
                        <div style="overflow:hidden;height:20px;">
                            <span>{{ Str::limit($promotion->title,50) }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    <hr>
    @endforeach

</div>
@endsection
