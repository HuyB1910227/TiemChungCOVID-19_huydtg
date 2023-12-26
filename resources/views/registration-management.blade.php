@extends('layouts.UserApp')

@section('title', 'Lịch sử đăng ký')

@section('main-content')
<div class="container p-0">
    <h3 class="titile">Lịch sử đăng ký tiêm chủng</h3>
    <br>
    
    <div class="">
        @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
        @endif
            <div class="d-flex flex-wrap justify-content-around">
                @foreach ($regs as $reg)
                    <div class="card p-4 my-2" style="width:400px; position: relative">
                        @if ($reg->status == 0)
                            <div class="badge badge-light mt-0"  style="width: 100px; position: absolute; top: 0px; right: 1px">Chờ xét duyệt</div>
                        @elseif ($reg->status == 1)
                            <div class="badge badge-primary mt-0"  style="width: 100px; position: absolute; top: 0px; right: 1px">Đã xác nhận</div>
                        @elseif ($reg->status == 2)
                            <div class="badge badge-success mt-0"  style="width: 100px; position: absolute; top: 0px; right: 1px">Đã hoàn thành</div>
                        @elseif ($reg->status == -1)
                            <div class="badge badge-warning mt-0"  style="width: 100px; position: absolute; top: 0px; right: 1px">Đã từ chối</div>
                        @elseif ($reg->status == -2)
                            <div class="badge badge-danger mt-0"  style="width: 100px; position: absolute; top: 0px; right: 1px">Đã hủy</div>
                        @endif
                        
                        
                        <div class="">Ngày tiêm: <b> {{date("d/m/Y", strtotime($reg->schedule->vaccination_date))}}</b></div>
                        <div class="">Giờ bắt đầu: <b> {{$reg->schedule->start_time}}</b></div>
                        <div class="">Giờ kết thúc: <b> {{$reg->schedule->end_time}}</b></div>
                        <div>Cơ sở: <b>{{$reg->schedule->immunizationUnit->name}}</b> </div>
                        <div>Địa điểm: <b><i>{{$reg->schedule->immunizationUnit->address}}</i></b> </div>
                        <div>Liên hệ: <b><a href="tel:{{$reg->schedule->immunizationUnit->hotline}}">{{$reg->schedule->immunizationUnit->hotline}}</a></b></div>
                        <div>Vắc xin: <b>{{$reg->schedule->vaccine->name}}</b> </div>
                        @if ($reg->status == 0)
                            <form action="{{route('vaccination.registration.destroy', $reg->id)}}" method="post">
                            @csrf
                            <button class="btn btn-danger w-50 m-1" type="submit">Hủy đăng ký</button>
                            </form>
                            
                        @endif
                        
                    </div>
                @endforeach


                
            </div>
    </div>
</div>
@endsection

