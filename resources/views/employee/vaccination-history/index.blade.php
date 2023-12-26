@extends('layouts.EmployeeApp')
@section('breadcrumb')
        <li class="breadcrumb-item">Lịch sử tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch sử tiêm</li>

@endsection
@section('title', 'Lịch sử tiêm chủng')

@section('main-content')
@if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
    @endif
    {{-- <h2 class="text-center text-uppercase"> Lịch sử tiêm chủng</h2> --}}


<div class="separator"></div>
<div class="m-3">
    <form class="bg-white card mb-1 shadow">
        {{-- @csrf --}}
       
        <div class="row p-3">
            <div class="col-4">
                <div class="form-group">
                    <label for="inputPassword">Ngày tiêm</label>
                    <input type="date" id="created_at" name="created_at" class="form-control searchField" column="12" value="{{request('vaccination_date')}}">
                </div>
            </div>
            {{-- <div class="col-4">
                <div class="form-group">
                    <label for="inputPassword">Lần tiêm </label>
                    <select id="number_of_injection" name="number_of_injection" class="custom-select searchField" column="3">
                        <option value="">Tất cả</option>

                    
                            <option value="1" {{request('number_of_injection') == 1 ? "selected" : ""}}>1</option>
                            <option value="2" {{request('number_of_injection') == 2 ? "selected" : ""}}>2</option>
                            <option value="n" {{request('number_of_injection') == "n" ? "selected" : ""}}>Mũi tiêm bổ sung</option>

                        
                    </select>
                </div>
            </div> --}}
            <div class="col-4">
                <div class="form-group">
                    <label for="inputPassword">Vắc xin</label>
                  
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
                    <a href="{{route('employee.vaccination.history')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
                </div>
                
            </div>

        </div>
    </form>
    <div class="bg-white card shadow">
        <div class="card-header ">
                       
        </div>
        <div class="card-body">
                <table class="table table-striped table-bordered table-responsive-lg" id="vaccination-history">
                <thead>
                    <tr>
                        <th>Mã số </th>
                        <th>Họ và tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>CMND/CCCD</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ngày tiêm</th>
                    
                        <th>Lần tiêm</th>
                        <th>Vắc xin</th>
                        <th>Trạng thái sau tiêm</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vacHistories as $vacHistory)
                        <tr>
                            <td>{{$vacHistory->id}}</td>
                            <td>{{$vacHistory->patient->full_name}}</td>
                            <td>{{date("d/m/Y", strtotime($vacHistory->patient->date_of_birth))}}</td>
                            <td>{{$vacHistory->patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                            <td>{{$vacHistory->patient->identify_card}}</td>
                            <td>{{$vacHistory->patient->address}}</td>
                            <td>{{$vacHistory->patient->phone}}</td>
                            <td>{{date("d/m/Y ", strtotime($vacHistory->created_at))}}</td>
                            <td>{{$vacHistory->number_of_injection}}</td>
                            <td>{{$vacHistory->vaccineLot->vaccine->name}}</td>
                            <td>{!!$vacHistory->status_after == "Chưa cập nhật" ? '<span class="text-secondary">Chưa cập nhật</span>' : $vacHistory->status_after!!}</td>
                            <td >
                                <div class="d-flex">
                                    <form action="{{route('employee.vaccination.history.show', $vacHistory->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-light button-no-des " data-toggle="tooltip" data-placement="top" title="Thông tin chi tiết">
                                            <i class="fa-solid fa-info"></i>
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-primary button-no-des" data-toggle="modal" data-target="#id{{$vacHistory->id}}" data-toggle="tooltip" data-placement="top" title="Cập nhật trạng thái sau tiêm">
                                        <i class="fa-solid fa-file-lines"></i> 
                                    </button>
                                </div>
                                
                            </td>
                            {{-- <div class="modal fade" id="id{{$vacHistory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm trạng thái sau tiêm</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('employee.vaccination.history.update', $vacHistory->id)}}" method="post" id="frmSuaTrangThai">
                                                @csrf
                                                <div>
                                                    <input type="text" class="form-control" name="vaccination_history_id" id="vaccination_history_id" value="{{$vacHistory->id}}"> 
                                                </div>
                                                <div class="form-group">
                                                    <label for="status_after">Trạng thái sau tiêm</label>
                                                    <input type="text" class="form-control" name="status_after">
                                                </div>
                                                <div>
                                                    <p class="text-danger">Lưu ý: Sau khi cập nhật trạng thái sau tiêm, bạn không có khả năng hoàn tác!</p>
                                                </div>
                        
                                        </div>
                                        <div class="modal-footer">
                        
                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                            </form>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>
                        
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            
                    </tr>
                    @endforeach
                    
                </tbody>    
            </table>     
       </div>
    </div>
    
    @foreach ($vacHistories as $vacHistory)
    {{-- <div class="modal" tabindex="-1" role="dialog" id="122">
        <!-- modal form here -->
      </div> --}}
    <div class="modal fade" id="id{{$vacHistory->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm trạng thái sau tiêm </h5>
                    {{-- <h6>Mã số: {{$vacHistory->id}}</h6> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employee.vaccination.history.update', $vacHistory->id)}}" method="post" id="frmSuaTrangThai">
                        @csrf
                        {{-- <div>
                            <input type="text" class="form-control" name="vaccination_history_id" id="vaccination_history_id" value="{{$vacHistory->id}}"> 
                        </div> --}}
                        <div class="form-group">
                            <label for="status_after">Trạng thái sau tiêm</label>
                            <input type="text" class="form-control" name="status_after" value="{{$vacHistory->status_after === 'Chưa cập nhật' ? '' : $vacHistory->status_after}}" placeholder="Chưa cập nhật">
                        </div>
                        <div class="form-group">
                            
                            <input type="checkbox" {{$vacHistory->patient->required_additional_dose == 1 ? "checked" : ""}} name="required_additional_dose" value="1"> Yêu cầu tiêm mũi bổ sung
                        </div>
                        <div>
                            <p class="text-danger">Lưu ý: Sau khi cập nhật trạng thái sau tiêm, bạn vẫn có thể cập nhật yêu cầu mũi tiêm bổ sung đối với các đối tượng đã được chỉ định</p>
                        </div>

                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Thoát</button>

                </div>
            </div>
        </div>
    </div>
    @endforeach
    
</div>
@endsection

@section('ex-script')
<script>
$(document).ready(function() {
    // var btnTTST = $('.btnttst');
    // const frmTrangThai = $('#vaccination_history_id');
    // btnTTST.on("click", function() {
    //     var lstID = $(this).data('lst_id');
    //     frmTrangThai.val(lstID);
    // })

    // $('#tbLichSuTiem').DataTable({
    //     "language": {
    //         "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
    //     },
    // });
});
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#vaccination-history').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                },
               
            });
        });
    </script>

@endsection