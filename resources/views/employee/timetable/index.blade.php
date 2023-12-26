@extends('layouts.EmployeeApp')

@section('title', 'Tiêm chủng')

@section('breadcrumb')
        <li class="breadcrumb-item">Lịch công tác</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch làm việc</li>
       
@endsection
@section('main-content')
@if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
    @endif
    {{-- <h2 class="text-center text-uppercase"> Kế hoạch tiêm chủng</h2> --}}
        
        <div class="separator"></div>
        <div class="m-3">
            <div class="bg-white card shadow">
                <div class="card-header ">
                    <a class="btn btn-primary ml-3" href="{{route('employee.calendar')}}">
                        <i class="fa-solid fa-calendar"></i>
                    </a>       
                </div>
                <div class="card-body">
                    
                        <table class="table table-striped table-bordered table-responsive-lg"  id="timetable">
                        <thead>
                            <tr>
                                <th>Mã lịch tiêm</th>
                                <th>Ngày tiêm</th>
                                <th>Giờ bắt đầu</th>
                                <th>Giờ kết thúc</th>
                                {{-- <th>Trạng thái</th> --}}
                                <th>Vắc xin tiêm dự kiến</th>
                                <th>Số nhân viên </th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($schedules == -1) 
                                
                            @else
                                @foreach ($schedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{date('d/m/y', strtotime($schedule->vaccination_date)) }}</td>
                                    <td>{{$schedule->start_time}}</td>
                                    <td>{{$schedule->end_time}}</td>
                                    {{-- <td>{{$schedule->status ? "Đã xác nhận" : "Đã xác nhận"}}</td> --}}
                                    <td>{{$schedule->vaccine->name}}</td>
                                    <td>{{count($schedule->groups)}}</td>
                                    <td>
                                        <a class="btn btn-light m-1 button-no-des" href="{{route('employee.timetable.show', $schedule->id)}}" data-toggle="tooltip" data-placement="top" title="Xác nhận tiêm">
                                            <i class="fa-solid fa-info"></i>
                                        </a>
                                        
                                        
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>      
               </div>
            </div>
            
        </div>
    
@endsection

@section('ex-script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#timetable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            },
           
        });
    });
</script>
@endsection