@extends('layouts.AdminApp')

@section('title', 'Thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item" aria-current="page">Thành viên</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý thành viên</li>

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
{{-- <h2 class="text-center text-uppercase"> Quản lý thành viên</h2> --}}
{{-- <p class="lead ml-2"> Đây là trang quản lý vắc xin.</p> --}}
<div class="separator"></div>
<div class="m-3">
    <div class="bg-white card shadow">
        <div class="card-header ">
            <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.member.create')}}">Thêm thành viên</a>
                       
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-responsive-lg" id="member">
                <thead>
                    <tr>
                        {{-- <th>Mã nhân viên</th> --}}
                        <th>Tên nhân viên</th>
                        <th>Mã nhân viên</th>
                        <th>CMND/CCCD</th>
                        <th>Liên hệ</th>
                        {{-- <th>Email</th> --}}
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ</th>
                        <th>Công tác</th>
                        <th>Vai trò</th>
                        {{-- <th>Nhân viên tiêm chủng</th> --}}
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        
                            {{-- <td>{{$employee->id}}</td> --}}
                            <td>{{$employee->full_name}}</td>
                            <td>{{$employee->employee_id}}</td>
                            <td>{{$employee->identify_card}}</td>
                            {{-- <td class="font-weight-bold font-italic">Chờ duyệt...</td> --}}
                            <td>+ {{$employee->phone}} <br>
                                + {{$employee->user->email}}
                            </td>
                           
                            <td>{{date("d/m/Y", strtotime($employee->date_of_birth))}}</td>
                            <td>{{$employee->gender == 1 ? "Nam" : "Nữ"}}</td>
                            <td>{{$employee->address}}</td>
                            <td>{{$employee->immunizationUnit->name}}</td>
                            <td>{{$employee->user->hasRole('manager') != null ? "quản lý" : "nhân viên"}}</td>
                            {{-- <td>{{$employee->user->hasRole('employee') != null ? "X" : ""}}</td> --}}
                            {{-- <td>{{$employee->gender}}</td> --}}

                            <td>
                                <a class="btn btn-warning text-white m-1 button-no-des" href="{{route('admin.member.edit', $employee->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                {{-- <button class="btn btn-danger btn-white m-1">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button> --}}
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
        $('#member').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            },
           
        });
    });
</script>
@endsection