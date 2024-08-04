@extends('layouts.loged')
@section('title', $new->title)
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-lg-12">

            <div class="card">
                @if (Auth::user()->role()->name == 'Admin' || Auth::user()->role()->name =='Support' )
                <div class="card-header text-right">
                    {!! Form::open(['route' => ['news.destroy', $new->id],'method' => 'delete']) !!}
                    <a href="{{route('news.edit', $new->id)}}">แก้ไข</a>
                    {!! Form::submit('ลบ', ['class' => 'bg-transparent border-none', 'style' => 'border:none']) !!}
                    {!! Form::close() !!}
                </div>
                @endif
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if ($new->image)
                        <img src="{{$new->image}}" alt="" class="shadow">
                        @else
                        <img src="/images/favicon.png" alt="">
                        @endif
                    </div>
                    <div class="mb-3">
                        <h2>
                            {{ $new->title }}
                        </h2>
                    </div>
                    <div class="mb-3" style="color:#888">
                        {!! $new->content !!}
                    </div>
                    <div style="color:#888">
                        ข่าวเมื่อ {!! date('d/m/Y', strtotime($new->date . ' + 543 years ')) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
