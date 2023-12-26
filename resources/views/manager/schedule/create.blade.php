@extends('layouts.ManagerApp')

@section('title', 'Thêm thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('manager.schedule')}}">Lịch tiêm dự kiến</a></li>
        <li class="breadcrumb-item" aria-current="page">Thêm lịch tiêm</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch tiêm dự kiến</li>
@endsection

@section('main-content')
<div class="separator"></div>
<div>
    <div class="bg-white card w-75 m-auto p-3">
        <form action="{{route('manager.schedule.prepare')}}" method="post" id="sch">
            @csrf
            <div class="m-auto">
                <h5 class="text-primary">1. Tạo lịch tiêm</h5>
                <div class="form-group">
                    <label for="vaccination_date">Ngày tiêm</label>
                    <input type="date" name="vaccination_date" id="vaccination_date" class="form-control" value="{{old('vaccination_date')}}">
                    @error('vaccination_date')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="start_time">Giờ bắt đầu</label>
                    <input type="time" name="start_time" id="start_time" class="form-control" value="{{old('start_time')}}">
                    @error('start_time')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="end_time">Giờ kết thúc</label>
                    <input type="time" name="end_time" id="end_time" class="form-control" value="{{old('end_time')}}">
                    @error('end_time')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="vaccine">Vắc xin</label>
                    <select name="vaccine" id="vaccine" class="custom-select">
                        <option value="">--Chọn--</option>
                        @foreach ($vaccines as $vaccine)
                            <option value="{{$vaccine->id}}" {{old('vaccine') == $vaccine->id ? "selected" : ""}}>{{$vaccine->name}}</option>
                        @endforeach
                    </select>
                    @error('vaccine')
                    <div class="error-block mt-1">
                        <strong>Chưa chọn vaccine</strong>
                    </div>
                    @enderror
                </div>
            </div>
            <div class="separator"></div>
            {{-- <div class="m-auto">
               <h5 class="text-primary">2. Chọn nhân viên</h5> 
            </div>
            @error('list_employee')
                    <div class="error-block mt-1">
                        <strong>Chưa chọn nhân viên</strong>
                    </div>
                @enderror --}}
            
            {{-- <table class="table table-striped table-bordered" id="#tb_employee">
                <thead>
                    <tr>
                        <th>Chọn</th>
                        <th>Tên nhân viên</th>
                        <th>Mã nhân viên</th>
                       
                        <th>Số điện thoại</th>
                        <th>Email</th>
                      
                        <th>Giới tính</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                            <td>
                                <input type="checkbox" name="list_employee[]" value="{{$employee->id}}" {{in_array($employee->id, @old('list_employee', [-1])) ? "checked" : ""}}>
                            </td>
                            <td>{{$employee->full_name}}</td>
                            <td>{{$employee->employee_id}}</td>
                            <td>{{$employee->phone}}</td>
                            <td>{{$employee->user->email}}</td>
                            <td>{{$employee->gender == 1 ? "Nam" : "Nữ"}}</td>
                           
                    </tr>
                    @endforeach
                </tbody>
            </table> --}}


            <div class="m-auto">
                {{-- <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{url()->previous()}}"><i class="fa-solid fa-arrow-left"></i></a> --}}
                <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Tiếp theo</button>
            </div>
            
            
        </form>
    </div>
</div>
@endsection

@section('ex-script')
    {{-- <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function () {
                $('#tb_employee').DataTable({
                    "language": {
                        "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                    },
                });
            });
        </script> --}}
        
@endsection

