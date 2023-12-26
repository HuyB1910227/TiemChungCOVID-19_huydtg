@extends('layouts.AdminApp')

@section('title', 'Lịch tiêm')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('admin.schedule')}}">Lịch tiêm</a></li>
        <li class="breadcrumb-item" aria-current="page">Chi tiết lịch tiêm</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch tiêm dự kiến</li>

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
    {{-- <h2 class="text-center text-uppercase"> Lịch tiêm dự kiến</h2> --}}
    <div class="separator"></div>
    <div class="row m-3 ">
        <div class="col-12 card mb-2 shadow p-1">
            <div class="d-flex ">
                @if ($schedule->status == 0 && strtotime($schedule->vaccination_date) >= strtotime(now()))
                
                    <form action="{{route('admin.schedule.confirm', $schedule->id)}}" method="post" style="width: 110px">
                        @csrf
                        <input type="text" name="old_url" value="{{url()->previous()}}" hidden> 

                        <button class="btn btn-primary m-1 confirm-btn btnConfirm">
                            <i class="fa-solid fa-check"></i> Đồng ý
                        </button>
                    </form>
                    
                    <form action="{{route('admin.schedule.cancel', $schedule->id)}}" method="post"   style="width: 110px; float: left">
                        @csrf
                        <input type="text" name="old_url" value="{{url()->previous()}}" hidden> 

                        <button class="btn btn-warning text-white m-1 refuse-btn btnRefuse" >
                            <i class="fa-solid fa-ban"></i> Từ chổi
                        </button>
                    </form>
                @endif
                    
                
            </div>
        </div>
        <div class="col-6 p-0">
            <div class="card shadow border-0 ">
                <div class="card-header bg-white">
                    <h4 class="text-center ">
                        Thông tin cơ sở
                    </h4>
                    
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        @php
                        $ad = explode(" ; ", $schedule->immunizationUnit->address);
                        @endphp
                        <tr>
                            <th>Tên cơ sở:</th>
                            <td>{{$schedule->immunizationUnit->name}}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ: </th>
                            <td>{{$ad[0]}}</td>

                        </tr>
                        <tr>
                            <th>Phường/ Xã: </th>
                            <td>{{$ad[1]}}</td>
                        </tr>
                        <tr>
                            <th>Quận/ Huyện:</th>
                            <td>{{$ad[2]}}</td>
                        </tr>
                        <tr>
                            <th>Tỉnh/ Thành phố:</th>
                            <td>{{$ad[3]}}</td>
                        </tr>
                        <tr>
                            <th>Hotline:</th>
                            <td>{{$schedule->immunizationUnit->hotline}}</td>
                        </tr>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="col-6 pr-0">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h4 class="text-center ">
                        Thông tin lịch tiêm
                    </h4>
                    
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        @php
                        $ad = explode(" ; ", $schedule->immunizationUnit->address);
                        @endphp
                        <tr>
                            <th>Mã lịch tiêm:</th>
                            <td>{{$schedule->id}}</td>
                        </tr>
                        <tr>
                            <th>Ngày tiêm: </th>
                            <td>{{date("d/m/Y", strtotime($schedule->vaccination_date))}}</td>

                        </tr>
                        <tr>
                            <th>Giờ bắt đầu: </th>
                            <td>{{date("h:i  A", strtotime($schedule->start_time))}}</td>
                        </tr>
                        <tr>
                            <th>Giờ kết thúc: </th>
                            <td>{{date("h:i  A", strtotime($schedule->end_time))}}</td>
                        </tr>
                        <tr>
                            <th>Tên vắc xin tiêm:</th>
                            <td> {{$schedule->vaccine->name}}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái:</th>
                            <td> 
                                @if($schedule->staus == 0)
                                    Chờ xét duyệt
                                @elseif ($schedule->staus == 1)
                                    Đã xác nhận
                                @elseif ($schedule->staus == -1)
                                    Đã tưc chối
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                
            </div>
           
        </div>
    </div>
    <div class="row m-3">
        <div class="card shadow border-0 col-12">
            <div class="card-header bg-white">
                <h4 class="text-center ">
                    Thông tin nhân viên
                </h4>
                
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã số</th>
                            <th>Tên nhân viên</th>
                            <th>Mã nhân viên</th>
                            <th>CMND/CCCD</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            {{-- <th>Ngày sinh</th> --}}
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                            {{-- <th>Công tác</th> --}}
                            {{-- <th>Quản lý tại cơ sở</th> --}}
                            {{-- <th>Nhân viên tiêm chủng</th> --}}
                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                            
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->full_name}}</td>
                                <td>{{$employee->employee_id}}</td>
                                <td>{{$employee->identify_card}}</td>
                               
                                <td>{{$employee->phone}}</td>
                                <td>{{$employee->user->email}}</td>
                                {{-- <td>{{$employee->date_of_birth}}</td> --}}
                                <td>{{$employee->gender == 1 ? "Nam" : "Nữ"}}</td>
                                <td>{{$employee->address}}</td>
                                {{-- <td>{{$employee->immunizationUnit->name}}</td> --}}
                                {{-- <td>{{$employee->user->hasRole('manager') != null ? "X" : ""}}</td> --}}
                                {{-- <td>{{$employee->user->hasRole('employee') != null ? "X" : ""}}</td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{url()->previous()}}"><i class="fa-solid fa-arrow-left"></i></a>
        </div>
    </div>
       
@endsection

@section('ex-script')
<script>
    $(document).ready(function () {
        $('.btnConfirm').on("click", function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn xác nhận?',
                text: "Sau khi đồng ý xác nhận, trạng thái lịch tiêm không thể hoàn tác!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý ',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.trigger('submit');
                }
            })
        });

        $('.btnRefuse').on("click", function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn từ chối?',
                text: "Sau khi từ chối, trạng thái lịch tiêm không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f5ad42',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Từ chối',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.trigger('submit');
                }
            })
        });
    });
</script>
@endsection