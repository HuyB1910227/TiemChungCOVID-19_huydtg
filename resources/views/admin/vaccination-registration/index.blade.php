@extends('layouts.AdminApp')

@section('breadcrumb')
        <li class="breadcrumb-item">Đăng ký tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý đăng ký tiêm</li>

@endsection

@section('title', 'Đăng ký tiêm chủng')

@section('main-content')
{{-- <h2 class="text-center text-uppercase"> Đăng ký tiêm chủng</h2> --}}

<div class="separator"></div>
<div class="m-3" >
    <form class="bg-white card mb-1 shadow">
        <div class="row p-3">
            <div class="col-2">
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
            <div class="col-2">
                <div class="form-group">
                    <label for="inputPassword">Trạng thái</label>

                    <select id="status" name="status" class="custom-select searchField" column="3">
                        <option value="0" {{request('status') === 0 ? "selected" : ""}}>Chờ xác nhận</option>
                        <option value="" {{request('status') === null? "selected" : ""}}>Tất cả</option>
                        <option value="-2" {{request('status') == -2 ? "selected" : ""}} >Đã hủy</option>
                        <option value="-1" {{request('status') == -1 ? "selected" : ""}}>Đã từ chối</option>
                        
                        <option value="1" {{request('status') == 1 ? "selected" : ""}}>Xác nhận</option>
                        <option value="2" {{request('status') == 2 ? "selected" : ""}}>Đã hoàn thành</option>
                    </select>

                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="inputPassword">Lịch tiêm</label>

                    <input type="date" id="vaccination_date" name="vaccination_date" class="form-control searchField" column="12" value="{{request('vaccination_date')}}">

                </div>
            </div>
            
            <div class="col-2">
                <div class="form-group">
                    <label for="inputPassword">Ngày đăng ký</label>

                    <input type="date" id="registration_date" name="registration_date" class="form-control searchField" column="12" value="{{request('registration_date')}}">

                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label for="inputPassword">Điểm bất thường</label>

                    <select name="unusual_point" id="unusual_point" class="custom-select searchField" column="3">
                        <option value="0" {{request('unusual_point') === 0 ? "selected" : ""}}>Không</option>
                        <option value="" {{request('unusual_point') == null ? "selected" : ""}}>Tất cả</option>
                        <option value="1" {{request('unusual_point') == 1 ? "selected" : ""}}>Có</option>
                       


                    </select>

                </div>
            </div>
            
            
            <div class="col-12">
              
                <div class="form-group ">
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                    <a href="{{route('admin.vaccination.registration')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
                </div>
                
            </div>

        </div>
    </form>
    <div class="bg-white card shadow">
        <div class="card-header ">
                       
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered table-responsive-lg" id="vaccination-registration">
                <thead>
                    <tr>
                    
                        <th>Mã phiếu</th>
                        <th>Họ và tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>CMND/CCCD</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đăng ký</th>
                        <th>Lịch tiêm</th>
                        
                        <th>Điểm bất thường</th>
                        <th>Trạng thái</th>
                        <th>Cơ sở</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filteredData as $regForm)
                
                        
                    <tr>
                    
                    
                        <td>{{$regForm->id}}</td>
                        <td>{{$regForm->patient->full_name}}</td>
                        <td>{{date("d/m/Y", strtotime($regForm->patient->date_of_birth))}}</td>
                        <td>{{$regForm->patient->gender}}</td>
                        <td>{{$regForm->patient->identify_card}}</td>
                        <td>{{$regForm->patient->address}}</td>
                        <td>{{$regForm->patient->phone}}</td>
                        <td>{{date("d/m/Y", strtotime($regForm->registration_date))}}</td> 
                        <td>{{date("d/m/Y", strtotime($regForm->schedule->vaccination_date))}}</td>
                        <td class="text-danger text-center">{{$regForm->unusual_point == 0 ? "" : "X"}}</td>
                        <td class="font-weight-bold font-italic">
                            @if ($regForm->status == 0)
                            <span class="badge badge-secondary rounded-pill text-white">Chờ xét duyệt</span>
                        @elseif ($regForm->status == 1)
                            <span class="badge badge-primary text-white rounded-pill">Đã xác nhận</span>
                        @elseif ($regForm->status == 2)
                            <span class="badge badge-success text-white rounded-pill">Đã tiêm</span>
                        @elseif ($regForm->status == -1)
                            <span class="badge badge-warning text-white rounded-pill">Đã từ chối</span>
                        @elseif ($regForm->status == -2)
                            <span class="badge badge-danger text-white rounded-pill">Đã hủy</span>
                        @endif
                        </td>
                        <td>{{$regForm->schedule->immunizationUnit->name}}</td>
                        
                    
                        <td>
                            <form action="{{route('admin.vaccination.registration.show', $regForm->id)}}" method="post">
                                @csrf
                                <button class="btn btn-light m-1 button-no-des">
                                    <i class="fa-solid fa-circle-info"></i>
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
        $('#vaccination-registration').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
            },
           
        });
    });
</script>
@endsection