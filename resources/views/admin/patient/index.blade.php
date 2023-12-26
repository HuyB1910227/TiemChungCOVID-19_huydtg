@extends('layouts.AdminApp')

@section('title', 'Thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item" aria-current="page">Người dùng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý người dùng</li>

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
            {{-- <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.member.create')}}">Thêm thành viên</a> --}}
                       
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-responsive-lg" id="member">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Họ tên</th>
                        <th>CMND/CCCD</th>
                        <th>Liên hệ</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>Địa chỉ</th>
                        <th>Nghề nghiệp</th>
                       
                        {{-- <th>Thao tác</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                    <tr>
                        
                            <td>{{$patient->id}}</td>
                            <td>{{$patient->full_name}}</td>
                            <td>{{$patient->identify_card}}</td>
                            <td>+{{$patient->phone}} <br>
                                +{{$patient->email}}
                            </td>
                            <td>{{date("d/m/Y", strtotime($patient->date_of_birth))}}</td>
                            <td>{{$patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                            <td>{{$patient->address}}</td>
                            <td>{{$patient->career}}</td>

                            {{-- <td>
                                <a class="btn btn-warning text-white m-1 button-no-des" href="{{route('admin.member.edit', $employee->id)}}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                            </td>  --}}
                        
                    
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