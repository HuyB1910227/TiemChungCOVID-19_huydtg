@extends('layouts.ManagerApp')

@section('title', 'Đăng ký tiêm chủng')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('manager.schedule')}}">Đăng ký tiêm chủng</a></li>
        <li class="breadcrumb-item" aria-current="page">Chi tiết phiếu đăng ký</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý đăng ký tiêm</li>

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
    <div class="row m-3">
        <div class="col-12 ">
            <div class="m-2">
                <div class="card container shadow ">
              
                    <div class="card-body container">
    
                        <div class="row">
                            <div class="col">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Mã số bệnh nhân:</th>
                                        <td>{{$reg->patient->id}}</td>
                                    </tr>
                                    <tr>
                                        <th>Họ và tên:</th>
                                        <td>{{$reg->patient->full_name}}</td>
                                    </tr>
                                    <tr>
                                        <th>CMND/CCCD:</th>
                                        <td>{{$reg->patient->identify_card}}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</th>
                                        <td>{{$reg->patient->address}}</td>
                                    </tr>
    
                                </table>
    
    
                            </div>
                            <div class="col">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Giới tính:</th>
                                        <td>{{$reg->patient->gender ? "Nam" : "Nữ"}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày sinh:</th>
                                        <td>{{date("d/m/Y", strtotime($reg->patient->date_of_birth))}}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Vắc xin đã tiêm:</th>
                                        <td>{{$reg->vaccine_id != null ? $reg->vaccine->name : "X"}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tiêm trước đó:</th>
                                        <td>{{$reg->recent_injection_date != null ? $reg->recent_injection_date : "X"}}</td>
                                    </tr>
                                    <tr>
                                        <th>Số điện thoại:</th>
                                        <td>{{$reg->patient->phone}}</td>
                                    </tr>
    
                                </table>
                            </div>
                        </div>
    
                        <hr>
                        <div class="row">
                            <h5 class="col-12">Điểm bất thường (Tiền sử)</h5>
                            <div class="col-6">
                                <h4 class="text-primary">| Có </h4>
                                @if (in_array(0, $Y))
                                    <p>Không có điểm bất thường</p>
                                @else
                                    @foreach ($Y as $i => $y)
                                        <p class="text-danger font-weight-bold font-italic">| {{++$i}}. {{$y}}</p>
                                    @endforeach
                                @endif
                                
                            </div>
                            <div class="col-6">
                                <h4 class="text-primary">| Không rõ </h4>
                                @if (in_array(0, $U))
                                    <p>Không có điểm bất thường</p>
                                @else
                                    @foreach ($U as $i => $u)
                                        <p class="text-danger font-weight-bold font-italic">| {{++$i}}. {{$u}}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 class="col-12">Đăng ký:</h5>
                            <div class="col-12">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Mã lịch hẹn:</th>
                                        <td>{{$reg->schedule->id}}</td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tiêm dự kiến:</th>
                                        <td>{{date("d/m/Y", strtotime($reg->schedule->vaccination_date))}}</td>
                                    </tr>
                                    <tr>
                                        <th>Cơ sở:</th>
                                        <td>{{$reg->schedule->immunizationUnit->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Địa chỉ:</th>
                                        <td>{{$reg->schedule->immunizationUnit->address}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer row">
                        <div class="col">
                            <a class="btn btn-light" href="{{url()->previous()}}">Trở về</a>
                        </div>
                        <div class="col">
                            <div class="d-flex flex-row-reverse">
                                {{-- <div class="d-flex justify-content-end"> --}}
                                @if ($reg->status == 0)
                                    <form action="{{route('manager.vaccination.registration.refuse', $reg->id)}}" method="post" class="float-left" >
                                        @csrf
                                        <input type="text" name="old_url" value="{{url()->previous()}}" hidden> 

                                        <button class="btn btn-warning text-white m-1 refuse-btn btnRefuse" >
                                            <i class="fa-solid fa-ban"></i> Từ chối
                                        </button>
                                    </form>
                                    <form action="{{route('manager.vaccination.registration.confirm', $reg->id)}}" method="post" class="float-right" >
                                        @csrf
                                        <input type="text" name="old_url" value="{{url()->previous()}}" hidden> 

                                        <button class="btn btn-primary m-1 confirm-btn btnConfirm">
                                            <i class="fa-solid fa-check"></i> Xác nhận
                                        </button>
                                    </form>
                                @endif
                                    
                                    
                                {{-- </div> --}}
                                {{-- <div class="col-6">
                                     <form action="{{route('employee.vaccination.registration.confirm', $reg->id)}}" method="post" class="float-right" >
                                        @csrf
                                        <button class="btn btn-primary m-1 confirm-btn btnConfirm">
                                            <i class="fa-solid fa-check"></i> Xác nhận
                                        </button>
                                    </form>
                                    
                                </div>
                                <div class="col-6">
                                    <form action="{{route('employee.vaccination.registration.refuse', $reg->id)}}" method="post" class="float-left" >
                                        @csrf
                                        <button class="btn btn-warning text-white m-1 refuse-btn btnRefuse" >
                                            <i class="fa-solid fa-ban"></i> Từ chối
                                        </button>
                                    </form>
                                   
                               </div> --}}
                            </div>
                           
                            
                            
                        </div>
    
                    </div>
                </div>
            </div>
    
    
    
           
        </div>
    </div>
@endsection








