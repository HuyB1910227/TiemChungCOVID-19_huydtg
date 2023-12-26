@extends('layouts.ManagerApp')

@section('title', 'Thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item">Lô vắc xin</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lô vắc xin</li>

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
{{-- <h2 class="text-center text-uppercase"> Quản lý lô vắc xin</h2> --}}
        <div class="separator"></div>
        <div class="m-3">
            <div class="bg-white card shadow">
                <div class="card-header ">
                    <a href="{{route('manager.lot.create')}}" class="btn btn-primary ml-2">Nhập vắc xin</a>
                </div>
                <div class="card-body">
                            <table class="table table-striped table-bordered table-responsive-lg" id="storage">
                        <thead>
                            <tr>
                                <th>Mã lô</th>
                                <th>Tên vắc xin</th>
                                <th>Ngày sản xuất</th>
                                <th>Ngày nhập kho</th>
                                <th>Ngày hết hạn</th>
                                <th>Số lượng</th>
                                <th>Còn lại</th>
                                <th>Tình trạng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lots as $lot)
                                <tr>
                                <td>{{ $lot->lot_code}}</td>
                                <td>{{ $lot->vaccine->name}}</td>
                                <td>{{ date('d/m/Y', strtotime($lot->manufacturing_date))}}</td>
                                <td>{{ date('d/m/Y', strtotime($lot->transaction_date))}}</td>
                                <td>{{ date('d/m/Y', strtotime($lot->expired_date))}}</td>
                                <td>{{ $lot->quantity}}</td>
                                @php
                                    $remain = 0;
                                    $remain = $lot->quantity - count($lot->vaccinationHistories);
                                @endphp
                                <td>{{ $remain }}</td>
                                <td class="">
                                    @if (\Carbon\Carbon::now() >= $lot->expired_date)
                                        <span class="badge badge-danger">Đã hết hạn</span>
                                    @else
                                        <p class="badge badge-success">Có thể sử dụng</p>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-warning text-white button-no-des mb-1" href="{{route('manager.lot.edit', $lot->id)}}">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    @if (count($lot->vaccinationHistories) == 0)
                                        <form action="{{route('manager.lot.destroy', $lot->id)}}" method="post">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button class="btn btn-danger btn-white button-no-des btnDelete" type="submit">
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
            $('#storage').DataTable({
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
                title: 'Bạn có muốn xóa lô vắc xin?',
                text: "Sau khi đồng ý, thông tin lô vắc xin không thể hoàn tác!",
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