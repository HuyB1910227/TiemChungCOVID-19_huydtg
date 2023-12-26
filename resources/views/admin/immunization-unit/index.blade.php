@extends('layouts.AdminApp')

@section('title', 'Thống kê')
@section('breadcrumb')
        <li class="breadcrumb-item" aria-current="page">Cơ sở tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý cơ sở</li>

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
{{-- <h2 class="text-center text-uppercase"> Quản lý cơ sở</h2> --}}
{{-- <p class="lead ml-2"> Đây là trang quản lý cơ sở.</p> --}}
{{-- <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.immunizationUnit.create')}}">Thêm cơ sở</a> --}}
<div class="separator"></div>
<div class="m-3">
    <div class="bg-white card shadow">
        <div class="card-header ">
            <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.immunizationUnit.create')}}">Thêm cơ sở</a>
                       
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-responsive-lg" id="immunization-unit">
                <thead>
                    <tr>
                        <th>Mã cơ sở</th>
                        <th>Tên cơ sở</th>
                        <th>Địa chỉ</th>
                        <th>Hotline</th>
                        <th>Số giấy phép hoạt động</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($immunizationUnits as $immunizationUnit)
                        <tr>
                            <td>{{$immunizationUnit->id}}</td>
                            <td>{{$immunizationUnit->name}}</td>
                            <td>{{$immunizationUnit->address}}</td>
                            <td>{{$immunizationUnit->hotline}}</td>
                            <td>{{$immunizationUnit->operating_license}}</td>
                            <td class="">
                                @if ($immunizationUnit->status)
                                    <span class="badge badge-success"> đang hoạt động</span>
                                @else
                                    <span class="badge badge-danger">ngừng hoạt động</span>
                                @endif
                            </td>
                            <td >
                                <div class="d-flex">
                                    
                                    <a class="btn btn-warning text-white button-no-des" href="{{route('admin.immunizationUnit.edit', $immunizationUnit->id)}}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if (count($immunizationUnit->employees) == 0 && count($immunizationUnit->schedules) == 0 && count($immunizationUnit->schedules) == 0)
                                        <form action="{{route('admin.immunizationUnit.destroy', $immunizationUnit->id)}}" method="post">
                                            <a class="btn btn-danger text-white button-no-des btnDelete" >
                                                <i class="fa-solid fa-trash-can"></i>
                                            </a>
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
        $('#immunization-unit').DataTable({
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
            title: 'Bạn có muốn xóa cơ sở tiêm chủng?',
            text: "Sau khi đồng ý, thông tin cơ sở không thể hoàn tác!",
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