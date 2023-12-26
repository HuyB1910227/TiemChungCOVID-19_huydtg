@extends('layouts.AdminApp')

@section('title', 'Loại vắc xin')
@section('breadcrumb')
        <li class="breadcrumb-item" aria-current="page">Loại vắc xin</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý loại vắc xin</li>

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
    <div class="bg-white card shadow">
        <div class="card-header ">
            <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.type.create')}}">Thêm loại vắc xin</a>        
        </div>
        <div class="card-body">
           <table class="table  table-bordered table-responsive-lg" id="vaccination-type">
        <thead>
            <tr>
                <th>Mã loại</th>
                <th>Tên loại</th>
                <th>Mô tả</th>
                <th>Thao tác</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($types as $type)
                <tr>
                <td>{{$type->id}}</td>
                <td>{{$type->name}}</td>
                <td>{{$type->description}}</td>
                <td >
                    <div class="d-flex">
                        <a class="btn btn-warning text-white button-no-des " href="{{route('admin.type.edit', $type->id)}}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                        @if (count($type->vaccines) == 0)
                            <form action="{{route('admin.type.destroy', $type->id)}}" method="post">
                                @csrf
                                <a class="btn btn-danger text-white button-no-des btnDelete">
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
        $('#vaccination-type').DataTable({
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
            title: 'Bạn có muốn xóa loại vắc xin?',
            text: "Sau khi đồng ý, thông tin loại vắc xin không thể hoàn tác!",
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