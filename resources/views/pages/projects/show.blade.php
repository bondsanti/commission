@extends('layouts.loged')
@section('title', $project->name)

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<!-- begin page-header -->
<div class="row justify-content-center">
<h1 class="page-header">{{$project->name}}
</h1>
</div>
<!-- end page-header -->

    <div class="row justify-content-center">

    <div class="col-lg-5">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="card">
                <div class="card-header">ข้อมูลโครงการ</div>
            </div>
            <div class="panel-body">
                <div class="form-group row">
                    <div class="col-md-12 text-center">
                        <div class="file-field">
                            <div class="mb-4">
                                @if ($project->logo)
                                <img src="{{$project->logo}}" class="rounded-circle z-depth-1-half "
                                    alt="example placeholder avatar">
                                @else

                                <img src="/images/vbeyond_ico.ico" class="rounded-circle z-depth-1-half "
                                    alt="example placeholder avatar">
                                @endif

                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name">ชื่อ</label>
                        <div class="form-inline">
                            <label for="name" class="font-weight-light">{{$project->name}}</label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="description">รายละเอียด</label>
                        <div class="form-inline">
                            <label for="description" class="font-weight-light">{{$project->description}}</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="address">ที่อยู่</label>
                        <div class="form-inline">
                            <label for="address" class="font-weight-light">{{$project->address}}</label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="phone">เบอร์โทรศัพท์</label>
                        <div class="form-inline">
                            <label for="phone" class="font-weight-light">{{$project->phone}}</label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="price">ราคาเริ่มต้น</label>
                        <div class="form-inline">
                            <label for="price" class="font-weight-light">{{ number_format($project->start_price)  }}
                                บาท</label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="area">พื้นที่เริ่มต้น</label>
                        <div class="form-inline">
                            <label for="area" class="font-weight-light">{{$project->area}} ตร.ม.</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="type_project">ประเภท</label>
                        <div class="form-inline">
                            <label for="type_project" class="font-weight-light">{{$project->type_project}}</label>
                        </div>

                    </div>
                </div>


                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="building">จำนวน อาคาร</label>
                        <div class="form-inline">
                            <label for="building" class="font-weight-light">{{$project->building}}</label>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="unit">จำนวน ยูนิต</label>
                        <div class="form-inline">
                            <label for="unit" class="font-weight-light">{{$project->unit}}</label>
                        </div>

                    </div>
                </div>
                  <div class="form-group row">
                    <div class="col-md-12">
                        <label for="unit">Url Link</label>
                        <div class="form-inline">
                            <label for="unit" class="font-weight-light"><a href="{{$project->urllink}}" target="_blank">{{$project->urllink}}</a>
							
							</label>
                        </div>
                    </div>
                </div>	
            </div>
               
        </div>
        <!-- end panel -->


        {{-- ///////////////////////////////////////////////////////////////////// --}}

        <!-- begin panel -->
        <!-- begin panel -->
        <div class="panel panel-inverse">
		
            <div class="card">
                <div class="card-header">รูปแบบ Floor plan</div>
            </div>

            <div class="panel-body p-0">

                <div class="accordion" id="accordionExample1">
                    @foreach ($floor as $key => $item)
                    <div class="card mb-0">
                        <div class="card-header" id="heading{{$item->id}}">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                    data-target="#collapse{{$item->id}}" aria-expanded="true"
                                    aria-controls="collapse{{$item->id}}">
                                    {{$item->name}}
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{$item->id}}" class="collapse {{($key == 0) ? 'show' : '' }}"
                            aria-labelledby="heading{{$item->id}}" data-parent="#accordionExample1">
                            <div class="card-body">
                                <div class="form-group row justify-content-center">
                                    @if ($item->image)
                                    <img src="{{$item->image}}" class="rounded-circle z-depth-1-half "
                                        alt="example placeholder avatar">
                                    @else

                                    <img src="/images/vbeyond_ico.ico" class="rounded-circle z-depth-1-half "
                                        alt="example placeholder avatar">
                                    @endif
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="name">ชื่อ</label>
                                        <label for="name" class="font-weight-light">{{$item->name}}</label>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="area">ชั้นที่</label>
                                        <label for="area" class="font-weight-light">{{$item->floor}}</label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="bed_room">ตึก</label>
                                        <label for="bed_room" class="font-weight-light">{{$item->building}}</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <label for="bath_room">จำนวน ห้องทั้งหมด</label>
                                        <label for="bath_room" class="font-weight-light">{{$item->rooms}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- end panel -->

        <!-- end panel -->
        {{-- ///////////////////////////////////////////////////////////////////// --}}


    </div>
    <div class="col-lg-5">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="card">
                <div class="card-header">รูปแบบห้องชุด</div>
            </div>
            <div class="panel-body p-0">



<div class="accordion" id="accordionExample">
    @foreach ($plan as $key => $item)
    <div class="card mb-0">
        <div class="card-header" id="heading{{$item->id}}">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$item->id}}"
                    aria-expanded="true" aria-controls="collapse{{$item->id}}">
                    {{$item->name}}
                </button>
            </h2>
        </div>

        <div id="collapse{{$item->id}}" class="collapse {{($key == 0) ? 'show' : '' }}"
            aria-labelledby="heading{{$item->id}}" data-parent="#accordionExample">
            <div class="card-body">
                <div class="form-group row justify-content-center">
                    @if ($item->plan_image)
                    <img src="{{$item->plan_image}}" class="rounded-circle z-depth-1-half "
                        alt="example placeholder avatar">
                    @else

                    <img src="/images/vbeyond_ico.ico" class="rounded-circle z-depth-1-half "
                        alt="example placeholder avatar">
                    @endif
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="name">ชื่อ</label>
                        <label for="name" class="font-weight-light">{{$item->name}}</label>

                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="area">พื้นที่</label>
                        <label for="area" class="font-weight-light">{{$item->area}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="bed_room">จำนวน ห้องนอน</label>
                        <label for="bed_room" class="font-weight-light">{{$item->bed_room}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="bath_room">จำนวน ห้องน้ำ</label>
                        <label for="bath_room" class="font-weight-light">{{$item->bath_room}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="living_room">จำนวน ห้องนั่งเล่น</label>
                        <label for="living_room" class="font-weight-light">{{$item->living_room}}</label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="kitchen_room">จำนวน ห้องครัว</label>
                        <label for="kitchen_room" class="font-weight-light">{{$item->kitchen_room}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>




            </div>
        </div>
        <!-- end panel -->
    </div>
</div>
@endsection