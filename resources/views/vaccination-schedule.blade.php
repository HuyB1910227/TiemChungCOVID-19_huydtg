@extends('layouts.UserApp')

@section('ex-css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
@endsection

@section('title', 'Lịch tiêm')

@section('main-content')
<div class="container-lg">
    <div class="text-center">
        <h3 class="titile mb-1">Đăng ký tiêm cho cá nhân</h3>
        {{-- <h2>{{$theLastVaccination->created_at}}</h2> --}}
    </div>
    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
    @endif
    <hr>
    <table class="table table-bordered" id="lichhen">
        <thead>
            <tr class="bg-primary text-light">
                <th>Mã lịch hẹn</th>
                <th>Cơ sở</th>
                <th>Địa chỉ</th>
                <th>Phường/ Xã</th>
                <th>Quận/ Huyện</th>
                <th>Tỉnh/ Thành phố</th>
                <th>Ngày tiêm</th>
                <th>Giờ bắt đầu</th>
                <th>Giờ kết thúc</th>
                <th>Vắc xin</th>
                <th>Thao tác</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach ($filteredSchedules as $schedule)
                
                <tr class="{{date("Y:m:d",strtotime($schedule->vaccination_date)) == date('Y:m:d') && date("H:i:s",strtotime($schedule->end_time)) <= date('H:i:s') ? 'd-none': ''}}">
                    @php
                        $addr[] = null;
                        $addr = explode(" ; ", $schedule->immunizationUnit->address);
                    @endphp
                    <td>{{$schedule->id}}</td>
                    <td>{{$schedule->immunizationUnit->name}}</td>
                    <td>{{$addr[0]}}</td>
                    <td>{{$addr[1]}}</td>
                    <td>{{$addr[2]}}</td>
                    <td>{{$addr[3]}}</th>
                    <td>{{date("d/m/Y",strtotime($schedule->vaccination_date))}}</td>
                    <td>{{$schedule->start_time}}</td>
                    <td>{{$schedule->end_time}}</td>
                    <td>{{$schedule->vaccine->name}}</td>
                    <td>
                        {{-- @if (isset($theLastVaccination) && (strtotime($theLastVaccination->created_time. "+ ". $schedule->vaccine->basic_injections_interval. " days") >= strtotime($schedule->vaccination_date))) --}}
                            {{-- <button class="btn btn-light text-primary btn-link " href="{{route('vaccination.registration', $schedule->id)}}" disabled>Chưa đến hạn tiêm</button> --}}
                        {{-- @else --}}
                        @if (!empty($theLastReg) && $theLastReg->schedule->vaccination_date >= date('Y-m-d') && ($theLastReg->status == 0 || $theLastReg->status == 1))
                            <p></p>
                        @else
                            <a class="btn btn-light text-primary btn-link " href="{{route('vaccination.registration', $schedule->id)}}">Đăng ký</a>

                        @endif
                        
                        {{-- @endif --}}
                        {{-- <a class="btn btn-light text-primary btn-link " href="{{route('vaccination.registration', $schedule->id)}}">Đăng ký</a> --}}
                    </td>
                    
                </tr>

            @endforeach
            
        </tbody>
    </table>

    <div>
        {{-- Mũi tiếp theo: {{isset($theNextDateVaccination) ? date("d-m-Y",$theNextDateVaccination) : ""}} --}}
    </div>
</div>
@endsection

@section('ex-script')
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#lichhen').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                    },
                });
            });
        </script>
    
@endsection