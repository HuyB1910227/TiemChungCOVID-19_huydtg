@extends('layouts.ManagerApp')

@section('title', 'Thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item">Lịch tiêm dự kiến</li>
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
        <div class="m-3">
            <form class="bg-white card mb-1 shadow">
       
                <div class="row p-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="inputPassword">Trạng thái </label>
                            <select id="status" name="status" class="custom-select searchField" column="3">
                                    <option value="">Tất cả</option>
                                    <option value="-1">Đã từ chối</option>
                                    <option value="0">Chờ xét duyệt</option>
                                    <option value="1">Đã xác nhận</option>
                                    <option value="-2">Đã hủy</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="inputPassword">Ngày tiêm dự kiến</label>
                            <input type="date" id="vaccination_date" name="vaccination_date" class="form-control searchField" column="12" value="{{request('vaccination_date')}}">
                        </div>
                    </div>
                    
                    <div class="col-4">
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
                            <a href="{{route('manager.schedule')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
                        </div>
                        
                    </div>
        
                </div>
            </form>
            
            <div class="bg-white card shadow">
                <div class="card-header ">
                     <a href="{{route('manager.schedule.create')}}" class="btn btn-primary ml-2">Thêm lịch tiêm</a>
                               
                </div>
                <div class="card-body">
                        <table class="table table-striped table-bordered table-responsive-lg" id="schedule" >
                        <thead>
                            <tr>
                                <th>Mã lịch tiêm</th>
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
                                <td>{{date("d/m/Y", strtotime($schedule->vaccination_date))}}</td>
                                <td>{{$schedule->start_time}}</td>
                                <td>{{$schedule->end_time}}</td>
                                
                                <td>{{$schedule->vaccine->name}}</td>
                                <td>{{count($schedule->groups)}}</td>
                                <td>
                                    @if($schedule->status == 1)
                                        <span class="badge badge-primary">Đã xác nhận</span>
                                    @elseif ($schedule->status == 0)
                                        <span class="badge badge-secondary">Chờ xét duyệt</span>
                                    @elseif ($schedule->status == -1)
                                        <span class="badge badge-danger">Đã từ chối</span>
                                    @elseif ($schedule->status == -2)
                                        <span class="badge badge-danger">Đã hủy</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-light m-1 button-no-des" href="{{route('manager.schedule.show', $schedule->id)}}">
                                        <i class="fa-solid fa-info"></i>
                                    </a>
                                    <br>
                                    {{-- <button class="btn btn-warning text-white m-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-white m-1">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button> --}}
                                    @if ($schedule->status == 0)
                                        <a class="btn btn-warning text-white button-no-des m-1" href="{{route('manager.schedule.edit', $schedule->id)}}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        
                                        <form action="{{route('manager.schedule.destroy', $schedule->id)}}" method="post">
                                            @csrf
                                            {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                            <button class="btn btn-danger btn-white button-no-des m-1 btnDelete" type="submit">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    @endif
                                    
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
            $('#schedule').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                },
               
            });
        });
    </script>

    <script>
        $('.btnDelete').on("click", function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có muốn hủy lịch tiêm?',
                text: "Sau khi đồng ý, lịch tiêm không thể hoàn tác!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý ',
                cancelButtonText: 'Trở lại'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.trigger('submit');
                }
            })
        });
    </script>
@endsection