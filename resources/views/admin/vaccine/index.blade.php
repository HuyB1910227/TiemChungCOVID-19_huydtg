@extends('layouts.AdminApp')

@section('title', 'Quản lý vắc xin')
@section('breadcrumb')
        <li class="breadcrumb-item">Vắc xin</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý vắc xin</li>

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
{{-- <h2 class="text-center text-uppercase"> Vắc xin</h2> --}}
<div class="separator"></div>
<div class="m-3">
  
        <div class="bg-white card shadow">
            <div class="card-header">
                <a class="btn btn-primary mb-0 ml-2" href="{{route('admin.vaccine.create')}}">Thêm vắc xin</a>       
            </div>
            <div class="card-body">
                <table class="table table-bordered table-responsive-lg bg-white" id="vaccine">
                    <thead>
                        <tr>
                            <th>Mã vắc xin</th>
                            <th>Tên vắc xin</th>
                            <th>Mũi tiêm cơ bản</th>
                            <th>Khoảng cách mũi cơ bản (ngày)</th>
                            <th>Mũi tiêm bổ sung</th>
                            <th>Khoảng cách mũi bổ sung (ngày)</th>
                            <th>Các vắc xin thay thế</th>
                            <th>Loại vắc xin</th>
                            
                            <th>Thao tác</th>
            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vaccines as $vaccine)
                            <tr>
                                <td>{{$vaccine->id}}</td>
                                <td>{{$vaccine->name}}</td>
                                <td>{{$vaccine->basic_dose}}</td>
                                <td>{{$vaccine->basic_injections_interval}}</td>
                                <td>{{$vaccine->additional_dose}}</td>
                                <td>{{$vaccine->additional_injections_interval}}</td>
                                <td>
                                    @foreach ($vaccine->boosterVaccines as $boosterVaccine)
                                        + {{$boosterVaccine->name}} <br>
                                    @endforeach
                                </td>
                                <td>{{$vaccine->type->name}}</td>
                                <td >
                                    <div class="d-flex">
                                        <a class="btn btn-warning text-white button-no-des " href="{{route('admin.vaccine.edit', $vaccine->id)}}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @if (count($vaccine->schedules) == 0)
                                            <form action="{{route('admin.vaccine.destroy', $vaccine->id)}}" method="post">
                                                @csrf
                                                <button class="btn btn-danger btn-white button-no-des {{$vaccine->schedules != null ? '' : ''}} btnDelete" href="" >
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                    </div>
                                    
                                    
                                </td>
                            </tr> 
                        @endforeach
                        
                        
                    </tbody>
                    {{-- <tfoot>
                        <tr>
                            <th>Mã vắc xin</th>
                            <th>Tên vắc xin</th>
                            <th>Hiệu lực</th>
                            <th>Loại vắc xin</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot> --}}
                </table>     
           </div>
        </div>
        

    


</div>
@endsection

@section('ex-script')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#vaccine').DataTable({
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
            title: 'Bạn có muốn xóa vắc xin?',
            text: "Sau khi đồng ý, thông tin vắc xin không thể hoàn tác!",
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