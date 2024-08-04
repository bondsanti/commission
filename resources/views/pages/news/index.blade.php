@extends('layouts.loged')
@section('title', 'News')
@section('content')


<div class="container">
    <div class="row mb-3">
        <div class="col-lg-12 text-right">

            @if (Auth::user()->role()->name =='Admin' ||Auth::user()->role()->name =='Support'  )
            {{-- <div class="row mb-2">
            <div class="col-md-12 text-right"> --}}
            <a href="{{route('news.create')}}" class="btn btn-primary">เพิ่ม ข่าวสาร</a>
            {{-- </div> --}}
            {{-- </div> --}}
            @endif
        </div>
    </div>
    <div class="row ">
        @foreach ($news as $item)
        <div class="col-md-3 ">
            <a href="{{route('news.show', $item->id)}}" class="card-promotion-link">
                <div class=" card cursor-pointer card-promotion">
                    <div class="card-body p-10">
                        <div class="text-center">
                            @if ($item->image)
                            <img src="{{$item->image}}" alt="">
                            @else
                            <img src="/images/favicon.png" alt="">

                            @endif
                        </div>
                        <hr>
                        <div style="overflow:hidden;height:20px;">
                            <span>{{$item->title}}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
