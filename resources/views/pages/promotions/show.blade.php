@extends('layouts.loged')
@section('title', $promotion->title)
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">

                        @if ($promotion->youtube_url != null)

                        <div class="col-lg-6 text-center">
                            @if ($promotion->image)
                            <img src="{{$promotion->image}}" alt="" class="shadow">
                            @else
                            <img src="/images/vbeyond_ico.ico" alt="">
                            @endif
                        </div>
                        <div class="col-lg-6 text-center">
                            <iframe width="420" height="315" class="shadow" src="{{$promotion->youtube_url}}?controls=0"
                                frameborder="0"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>

                        </div>

                        @else
                        <div class="col-lg-12 text-center">
                            @if ($promotion->image)
                            <img src="{{$promotion->image}}" alt="" class="shadow">
                            @else
                            <img src="/images/favicon.png" alt="">
                            @endif
                        </div>

                        @endif
                    </div>
                    <div class="mb-3 text-center">
                        <h2>
                            {{ $promotion->title }}
                        </h2>
                    </div>
                    <div class="mb-4">
                        {!! $promotion->content !!}
                    </div>
                    <div>
                        วันเริ่มโปรโมชั่น {{ date('d/m/Y' , strtotime($promotion->startdate. '+ 543 years')) }}
                    </div>					
                    <div>
                        วันสิ้นสุดโปรโมชั่น {{ date('d/m/Y' , strtotime($promotion->expire. '+ 543 years')) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
