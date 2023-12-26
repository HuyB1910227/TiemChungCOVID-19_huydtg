@extends('layouts.AdminApp')
@section('breadcrumb')
        <li class="breadcrumb-item">Lịch sử tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch sử tiêm</li>

@endsection
@section('title', 'Lịch sử tiêm')

@section('main-content')
{{-- <h2 class="text-center text-uppercase"> LỊch sử tiêm chủng</h2> --}}

<div class="separator"></div>
<div class="m-3">
    <form class="bg-white card mb-1 shadow">
       
        <div class="row p-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="inputPassword">Cơ sở</label>

                    <select id="immunization_unit_id" name="immunization_unit_id" class="custom-select searchField" column="3">
                        <option value="" >Tất cả</option>
                        @foreach ($immunizationUnits as $immunizationUnit)
                            <option value="{{$immunizationUnit->id}}" {{request('immunization_unit_id') == $immunizationUnit->id ? "selected" : ""}}>{{$immunizationUnit->name}}</option>
                            
                        @endforeach
                        
                    </select>

                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="inputPassword">Ngày tiêm</label>
                    <input type="date" id="created_at" name="created_at" class="form-control searchField" column="12" value="{{request('created_at')}}">
                </div>
            </div>
            {{-- <div class="col-3">
                <div class="form-group">
                    <label for="inputPassword">Lần tiêm </label>
                    <select id="number_of_injection" name="number_of_injection" class="custom-select searchField" column="3">
                        <option value="">Tất cả</option>
                        @foreach ($vaccinationHistories as $vaccinationHistory)
                            <option value="{{$vaccinationHistory->number_of_injection}}" {{request('number_of_injection') == $vaccinationHistory->number_of_injection ? "selected" : ""}}>{{$vaccinationHistory->number_of_injection}}</option>
                        @endforeach
                            

                        
                    </select>
                </div>
            </div> --}}
            <div class="col-3">
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
                    <a href="{{route('admin.vaccination.history')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
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
                        <th>Cơ sở</th>
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
                            <td>{{date("d/m/Y", strtotime($vacHistory->created_at))}}</td>
                            <td>{{$vacHistory->number_of_injection}}</td>
                            <td>{{$vacHistory->vaccineLot->vaccine->name}}</td>
                            <td>{{$vacHistory->schedule->immunizationUnit->name}}</td>
                            <td>{{$vacHistory->status_after}}</td>
                            <td>
                                <form action="{{route('admin.vaccination.history.show', $vacHistory->id)}}" method="post">
                                    @csrf
                                    <button class="btn btn-light button-no-des " data-toggle="tooltip" data-placement="top" title="Thông tin chi tiết">
                                        <i class="fa-solid fa-info"></i>
                                    </button>
                                </form>
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
        var table = $('#vaccination-history').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            },
           
        });
        // $(".searchField").on("keyup change", function() {
        //     var input = $(this);
        //     var colIndex = parseInt(input.attr("column"));
        //     table.column(colIndex).search(input.val()).draw();

        // });
    });
    
   
    
</script>
@endsection