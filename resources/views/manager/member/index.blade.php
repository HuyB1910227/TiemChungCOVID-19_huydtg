@extends('layouts.ManagerApp')

@section('title', 'Thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item" aria-current="page">Nhân viên</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý nhân viên</li>

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
    {{-- <h2 class="text-center text-uppercase"> Quản lý nhân viên</h2> --}}

    <div class="separator"></div>
    <div class="m-3">
      <div class="bg-white card shadow">
        <div class="card-header ">
          <a class="btn btn-primary mb-0 ml-2" href="{{route('manager.member.create')}}">Thêm nhân viên</a>
                       
        </div>
        <div class="card-body">
          <table class="table table-bordered table-responsive-lg" id="member">
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
                    {{-- <th>Công tác</th> --}}
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
                       
                        <td>+{{$employee->phone}}
                            <br>
                            +{{$employee->user->email}}
                        </td>
                        {{-- <td></td> --}}
                        <td>{{date("d/m/Y", strtotime($employee->date_of_birth))}}</td>
                        <td>{{$employee->gender == 1 ? "Nam" : "Nữ"}}</td>
                        <td>{{$employee->address}}</td>
                        {{-- <td>{{$employee->immunizationUnit->name}}</td> --}}
                        <td>{{$employee->user->hasRole('manager') != null ? "Quản lý" : "Nhân viên"}}</td>
                        {{-- <td>{{$employee->user->hasRole('employee') != null ? "X" : ""}}</td> --}}
                       
    
                        <td>
                          @if ($employee->user->hasRole('employee'))
                            <a class="btn btn-warning text-white button-no-des m-1" href="{{route('manager.member.edit', $employee->id)}}">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                          @endif
                            
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