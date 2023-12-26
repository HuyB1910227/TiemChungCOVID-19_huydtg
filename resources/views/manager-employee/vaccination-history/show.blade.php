@if (Auth::user()->hasRole('administrator'))
    
    @php
        $app = "layouts.AdminApp";
        $breadcrumb = 'admin.vaccination.history'
    @endphp

@elseif (Auth::user()->hasRole('manager'))
    @php
        $app = "layouts.ManagerApp";
        $breadcrumb = 'manager.vaccination.history'
    @endphp
@elseif (Auth::user()->hasRole('employee'))
    @php
        $app = "layouts.EmployeeApp";
        $breadcrumb = 'employee.vaccination.history'
    @endphp
@endif

@extends($app)

@section('breadcrumb')
    {{-- <li class="breadcrumb-item"><a href="{!!$breadcrumb!!}">Lịch sử tiêm</a></li> --}}
    <li class="breadcrumb-item">Chi tiết lịch sử tiêm</li>
    <li class="text-uppercase ml-auto font-weight-bold">Quản lý lịch sử tiêm chủng</li>
@endsection
    

@section('main-content')
    {{-- @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
    @endif --}}
    
    <div class="separator"></div>
    <div class="row m-3 ">
        <div class="col-4 p-0">
            <div class="card shadow border-0 ">
                <div class="card-header bg-white">
                    <h4 class="text-center ">
                        Thông tin cơ sở
                    </h4>
                    
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        @php
                        $ad = explode(" ; ", $vaccinationHistory->schedule->immunizationUnit->address);
                        @endphp
                        <tr>
                            <th>Mã lịch tiêm:</th>
                            <td>{{$vaccinationHistory->schedule->id}}</td>
                        </tr>
                        <tr>
                            <th>Cơ sở tiêm:</th>
                            <td>{{$vaccinationHistory->schedule->immunizationUnit->name}}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ: </th>
                            <td>{{$ad[0]}}</td>
                        </tr>
                        <tr>
                            <th>Phường/ Xã: </th>
                            <td>{{$ad[1]}}</td>
                        </tr>
                        <tr>
                            <th>Quận/ Huyện:</th>
                            <td>{{$ad[2]}}</td>
                        </tr>
                        <tr>
                            <th>Tỉnh/ Thành phố:</th>
                            <td>{{$ad[3]}}</td>
                        </tr>
                        <tr>
                            <th>Hotline:</th>
                            <td>{{$vaccinationHistory->schedule->immunizationUnit->hotline}}</td>
                        </tr>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="col-4 pr-0">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h4 class="text-center ">
                        Thông tin mũi tiêm
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Mũi tiêm:</th>
                            <td>{{$vaccinationHistory->number_of_injection}}</td>
                        </tr>
                        <tr>
                            <th>Ngày tiêm: </th>
                            <td>{{date("d/m/Y h:m:s", strtotime($vaccinationHistory->created_at))}}</td>
                        </tr>
                        <tr>
                            <th>Tên vắc xin tiêm: </th>
                            <td>{{$vaccinationHistory->schedule->vaccine->name}}</td>
                        </tr>
                        <tr>
                            <th>Lô vắc xin: </th>
                            <td>{{$vaccinationHistory->vaccineLot->lot_code}}</td>
                        </tr>
                        <tr>
                            <th>Loại vắc xin: </th>
                            <td>{{$vaccinationHistory->vaccineLot->vaccine->type->name}}</td>
                        </tr>
                        <tr>
                            <th>Trạng thái sau tiêm: </th>
                            <td>{{$vaccinationHistory->status == null ? "Chưa cập nhật" : $vaccinationHistory->status}}</td>
                        </tr>
                        
                    </table>
                </div>
                
            </div>
           
        </div>
        <div class="col-4 pr-0">
            <div class="card shadow border-0">
                <div class="card-header bg-white">
                    <h4 class="text-center ">
                        Thông tin người tiêm
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        @php
                        $ad = explode(" ; ", $vaccinationHistory->patient->address);
                        @endphp
                        <tr>
                            <th>Mã bệnh nhân:</th>
                            <td>{{$vaccinationHistory->patient_id}}</td>
                        </tr>
                        <tr>
                            <th>Họ và tên: </th>
                            <td>{{$vaccinationHistory->patient->full_name}}</td>
                        </tr>
                        <tr>
                            <th>CCCD/CMND: </th>
                            <td>{{$vaccinationHistory->patient->identify_card}}</td>
                        </tr>
                        <tr>
                            <th>Giới tính: </th>
                            <td>{{$vaccinationHistory->patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                        </tr>
                        <tr>
                            <th>Email: </th>
                            <td>{{$vaccinationHistory->patient->email}}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại: </th>
                            <td>{{$vaccinationHistory->patient->phone}}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ: </th>
                            <td>{{$vaccinationHistory->patient->address}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row m-3">
        <div class="card shadow border-0 col-12">
            <div class="card-header bg-white">
                <h4 class="text-center ">
                    Thông tin nhân viên
                </h4>
                
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã số</th>
                            <th>Tên nhân viên</th>
                            <th>Mã nhân viên</th>
                            <th>CMND/CCCD</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Địa chỉ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                        <tr>
                                <td>{{$employee->id}}</td>
                                <td>{{$employee->full_name}}</td>
                                <td>{{$employee->employee_id}}</td>
                                <td>{{$employee->identify_card}}</td>
                                <td>{{$employee->phone}}</td>
                                <td>{{$employee->user->email}}</td>
                                <td>{{$employee->gender == 1 ? "Nam" : "Nữ"}}</td>
                                <td>{{$employee->address}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <a class="btn btn-light" href="{{url()->previous()}}">Trở về</a>
                </div>
                
        </div>
    </div>
    
       
@endsection