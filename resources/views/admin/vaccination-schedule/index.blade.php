@extends('layouts.AdminApp')

@section('title', 'Lịch tiêm')
@section('breadcrumb')
        <li class="breadcrumb-item">Lịch tiêm</li>
        {{-- <li class="text-uppercase ml-auto font-weight-bold">Lịch tiêm dự kiến</li> --}}
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
        <div class="separator"></div>
        <div class="m-3">
            <form class="bg-white card mb-1 shadow">
       
                <div class="row p-3">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="inputPassword">Cơ sở tiêm chủng </label>
                            <select id="immunization_unit_id" name="immunization_unit_id" class="custom-select searchField" column="3">
                                <option value="">Tất cả</option>
                                @foreach ($immunizationUnits as $immunizationUnit)
                                    <option value="{{$immunizationUnit->id}}" {{request('immunization_unit_id') == $immunizationUnit->id ? "selected" : ""}}>{{$immunizationUnit->name}}</option>
                                @endforeach
                                    
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="inputPassword">Trạng thái </label>
                            <select id="status" name="status" class="custom-select searchField" column="3">
                                <option value="0" {{request('status') === 0 ? "selected" : ""}}>Chờ xét duyệt</option>

                                    <option value="" {{request('status') === null ? "selected" : ""}}>Tất cả</option>
                                    
                                    <option value="-1" {{request('status') == -1 ? "selected" : ""}}>Đã từ chối</option>
                                    
                                    <option value="1" {{request('status') == 1 ? "selected" : ""}}>Đã xác nhận</option>
                                    
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="inputPassword">Ngày tiêm dự kiến</label>
                            <input type="date" id="vaccination_date" name="vaccination_date" class="form-control searchField" column="12" value="{{request('vaccination_date')}}">
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="form-group">
                            <label for="inputPassword">Vắc xin dự kiến</label>
                          
                                <select name="vaccine_id" id="vaccine_id" class="custom-select searchField" column="3">
                                    <option value="">--Chọn--</option>
                                    @foreach ($vaccines as $vaccine)
                                        <option value="{{$vaccine->id}}" {{request('vaccine_id') == $vaccine->id ? "selected" : ""}}>{{$vaccine->name}}</option>
                                    @endforeach
                                </select>
                            
                        </div>
                    </div>
                    
                    
                    
                    <div class="col-12">
                      
                        <div class="form-group ">
                            <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                            <a href="{{route('admin.schedule')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
                        </div>
                        
                    </div>
        
                </div>
            </form>
            <div class="bg-white card shadow">
                <div class="card-header ">
                   
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-responsive-lg" id="vaccination-schedule">
                        <thead>
                            <tr>
                                <th>Mã lịch tiêm</th>
                                <th>Mã cơ sở</th>
                                <th>Tên cơ sở</th>
                                <th>Địa chỉ</th>
                                <th>Ngày tiêm</th>
                                <th>Giờ bắt đầu</th>
                                <th>Giờ kết thúc</th>
                                <th>Vắc xin tiêm dự kiến</th>
                                <th>Số nhân viên tiêm</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->id }}</td>
                                <td>{{$schedule->immunizationUnit->id}}</td>
                                <td>{{$schedule->immunizationUnit->name}}</td>
                                <td>{{$schedule->immunizationUnit->address}}</td>
                                <td>{{date("d/m/Y", strtotime($schedule->vaccination_date)) }}</td>
                                <td>{{$schedule->start_time}}</td>
                                <td>{{$schedule->end_time}}</td>
                                <td>{{$schedule->vaccine->name}}</td>
                                <td>{{count($schedule->groups)}}</td>
                                <td>
                                    @if ($schedule->status == 1)
                                        <span class="badge badge-primary">Đã xác nhận</span>
                                    @elseif ($schedule->status == 0)
                                        <span class="badge badge-secondary">Chờ xét duyệt</span>
                                    @elseif ($schedule->status == -1)
                                        <span class="badge badge-warning text-white">Đã từ chối</span>
                                    @elseif ($schedule->status == -2)
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td >
                                    <div class="d-flex">
                                        <a class="btn btn-light m-1 button-no-des" href="{{route('admin.schedule.show', $schedule->id)}}">
                                            <i class="fa-solid fa-circle-info"></i>
                                        </a>
                                        @if ($schedule->status == 0 && strtotime($schedule->vaccination_date) >= strtotime(date('Y/m/d 00:00:00')))
                                            <form action="{{route('admin.schedule.confirm', $schedule->id)}}" method="post">
                                                @csrf

                                                <button class="btn btn-primary m-1 confirm-btn button-no-des btnConfirm">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                            
                                            <form action="{{route('admin.schedule.cancel', $schedule->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-warning text-white m-1 refuse-btn button-no-des btnRefuse" >
                                                    <i class="fa-solid fa-ban"></i> 
                                                </button>
                                            </form>
                                        @endif
                                        
                                    </div>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
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
        $('#vaccination-schedule').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            },
           
        });

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