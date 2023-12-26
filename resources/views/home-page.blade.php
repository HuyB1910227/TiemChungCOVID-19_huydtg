@extends('layouts.UserApp')

@section('title', 'Trang chủ')

@section('main-content')
     <div class="container-lg">
            <div class="row">
                
                <div class="col-12 col-md-5 div_tc_cn">
                    <div class="div_tc_ha">
                        <img src="{{asset($patient->avatar)}}" alt="" class="rounded-circle" width="150px" height="150px">
                    </div>
                    <div class="row justify-content-center div_rounded div_tc_tt">
                        {{-- <h3 style="color: #616AC6; text-shadow: 1px 1px 2px #616AC6">{{Auth::guard('patient')->user()->full_name}}</h3> --}}
                        <h4 class="col-12 text-center font-weight-bold">Thông tin cá nhân</h4>
                        <div class="col">
                            <table class="table " style="font-size: 20px;">
                                <tr>
                                    <td class="w-50 font-weight-bold">Họ và tên: </td>
                                    <td class="w-50">{{$patient->full_name}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Ngày sinh:</td>
                                    <td>{{date("d/m/Y", strtotime($patient->date_of_birth))}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Số điện thoại:</td>
                                    <td>{{$patient->phone}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Giới tính:</td>
                                    <td>{{$patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">E-mail:</td>
                                    <td>{{$patient->email}}</td>
                                </tr>
                                @php
                                    $addr = explode(' ; ', $patient->address)
                                @endphp
                                <tr>
                                    <td class="font-weight-bold">Địa chỉ:</td>
                                    <td>{{$addr[3]}}</td>
                                </tr>
                                
                                <tr>
                                    <td class="font-weight-bold">Tỉnh/Thành phố:</td>
                                    <td>{{$addr[2]}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Quận/huyện:</td>
                                    <td>{{$addr[1]}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Phường/xã:</td>
                                    <td>{{$addr[0]}}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nghề nghiệp:</td>
                                    <td>{{$patient->career != null ? $patient->career : "Chưa cập nhật"}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7 p-1">
                    <div class="row div_rounded div_shadow">
                        
                        <div class="col-6 col-md-4 col-lg-3 my-2">
                            <a href="{{route('schedule')}}" class="card text-decoration-none"
                                style="width: 8rem; height: 10rem; background-color: #c44b14;">
                                <img src="{{asset('user/img/172813.png')}}" class="rounded-circle mx-auto mt-4" alt="..."
                                    width="70px" height="70px" style="border: 5px solid #ff590c;">
                                <p class="text-center p-2 text-white font-weight-bold">Đăng ký tiêm</p>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 my-2">
                            <a href="{{route('patient.vaccination.history')}}" class="card text-decoration-none"
                                style="width: 8rem; height: 10rem; background-color: #66d3c8;">
                                <img src="{{asset('user/img/TrangChu/historyV.webp')}}" class="rounded-circle mx-auto mt-4" alt="..."
                                    width="70px" height="70px" style="border: 5px solid #a3e7e0;">
                                <p class="text-center p-2 text-white font-weight-bold">Lịch sử tiêm</p>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 my-2">
                            <a href="{{route('patient.vaccination.certificate')}}" class="card text-decoration-none"
                                style="width: 8rem; height: 10rem; background-color:  #00bd84;">
                                <img src="{{asset('user/img/TrangChu/certificateVaccination.jpg')}}" class="rounded-circle mx-auto mt-4" alt="..."
                                    width="70px" height="70px" style="border: 5px solid #01d495;">
                                <p class="text-center p-2 text-white font-weight-bold">Chứng nhận</p>
                            </a>
                        </div>
                        <div class="col-6 col-md-4 col-lg-3 my-2">
                            <a href="tel: 0932988029" class="card text-decoration-none"
                                style="width: 8rem; height: 10rem; background-color:#F8A964;">
                                <img src="{{asset('user/img/376453.png')}}" class="rounded-circle mx-auto mt-4" alt="..."
                                    width="70px" height="70px" style="border: 5px solid #fcc89b;;">
                                <p class="text-center p-2 text-white font-weight-bold">Gọi tư vấn</p>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3 ">
                        <div class="col-12 col-md-7 contain p-0 div_rounded div_shadow ">
                            <div class="calendar">
                                <div class="month">
                                    <i class="fas fa-angle-left prev"></i>
                                    <div class="date">
                                        <h1></h1>
                                        <p></p>
                                    </div>
                                    <i class="fas fa-angle-right next"></i>
                                </div>
                                <div class="weekdays">
                                    <div>CN</div>
                                    <div>T2</div>
                                    <div>T3</div>
                                    <div>T4</div>
                                    <div>T5</div>
                                    <div>T6</div>
                                    <div>T7</div>
                                </div>
                                <div class="days"></div>
                            </div>
                        </div>
                        <div class="col-12 col-md-5 pl-3 " style="height: 600px;">
                            <div class="row justify-content-center div_rounded div_shadow ml-1 p-1"
                                style="min-height: 300px;max-height: 600px; overflow: auto">
                                @if ($regs == -1)
                                    <h5 class="col-12 text-center text-danger">Chưa có lịch hẹn</h5>
                                    <h5 class="col-12 text-primary">(*) Quý khách có thể đăng ký tiêm chủng.</h5>
                                    <div class="col-12">
                                        <a href="{{route('schedule')}}" class="btn btn-primary rounded-pill w-100">Đăng ký
                                            tiêm</a>
                                    </div>
                                @else
                                    @foreach ($regs as $reg)
                                            <div class="card w-100 m-2 card-member" >
                                                <div class="card-header bg-primary text-white">Mã số: {{$reg->schedule->id}}</div>
                                                <div class="card-body">
                                                    
                                                    <p class="card-text">Ngày: {{date("d/m/Y", strtotime($reg->schedule->vaccination_date))}}</p>
                                                    <p class="card-text">Giờ bắt đầu: {{$reg->schedule->start_time}}</p>
                                                    <p class="card-text">Giờ kết thúc: {{$reg->schedule->end_time}}</p>
                                                    <p class="card-text">Tên cơ sở: {{$reg->schedule->immunizationUnit->name}}</p>
                                                    <p class="card-text">Hotline: {{$reg->schedule->immunizationUnit->hotline}}</p>
                
                                                </div>
                                            </div>
                                        
                                        
                                    @endforeach
                                @endif
                                    

                            </div>
                            <br>
                            <div class="row justify-content-center div_rounded div_shadow ml-1 p-1 mt-1"
                                style="min-height: 260px;max-height: 550px; overflow: auto">
                                    <h4 class="text-primary p-1">Tiến trình tiêm chủng</h4>
                                   
                                    <div class="card w-100 m-1 card-member p-0" style="background-color: #07c500">
                                         {{-- <p class="text-center text-white">Mũi tiêm cơ bản</p> --}}
                                         <div class="card-body p-0 text-center">
                                            <span class="text-center text-white">Mũi tiêm cơ bản</span> <br>
                                            @if ($process['basic'] == 0)
                                                <span class="badge badge-secondary  p-1">Chưa hoàn thành</span>
                                            @elseif ($process['basic'] == 1)
                                                <span class="badge badge-primary  p-1">Đã hoàn thành</span>
                                            @endif
                                         </div>
                                         
                                    </div>
                                    
                                    <div class="card w-100 m-1 card-member p-0 " style="background-color: #ecc900; {{$process['basic'] == 0 ? 'opacity: 0.4' : ''}}" >
                                        {{-- <p class="text-center text-white">Mũi tiêm cơ bản</p> --}}
                                        <div class="card-body p-0 text-center">
                                            <span class="text-center text-white">Mũi tiêm bổ sung</span> <br>
                                            @if ($patient->required_additional_dose != 1)
                                                <span class="badge badge-danger  p-1">Không thuộc diện tiêm bổ sung</span>
                                            @elseif ($patient->required_additional_dose == 1 && $process['ex_basic'] == 0)
                                                <span class="badge badge-secondary  p-1">Chưa hoàn thành</span>
                                            @elseif ($patient->required_additional_dose == 1 && $process['ex_basic'] == 1)
                                                <span class="badge badge-primary  p-1">Đã hoàn thành</span>
                                            @endif
                                        </div>
                                        
                                   </div>
                                   <div class="card w-100 m-1 card-member p-0 " style="background-color: #048000; {{$process['basic'] == 0 ? 'opacity: 0.4' : ''}}">
                                    {{-- <p class="text-center text-white">Mũi tiêm cơ bản</p> --}}
                                        <div class="card-body p-0 text-center">
                                            <span class="text-center text-white">Mũi tiêm nhắc lại</span> <br>
                                            @if ($process['booster'] == 0)
                                                <span class="badge badge-secondary  p-1">Chưa hoàn thành</span>
                                            @elseif ($process['booster'] == 1)
                                                <span class="badge badge-primary  p-1">Đã hoàn thành</span>
                                            @endif
                                        </div>
                                        
                                    </div>
                                    
                                   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-lg">
            <hr>
            <h3 class="title text-center">Bản đồ covid-19</h3>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="border m-2 shadow rounded">

                        <iframe
                            src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=cases&showTable=false&showMap=true"
                            title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                            frameBorder="0"></iframe>


                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="border m-2 shadow rounded">

                        <iframe
                            src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=recovered&showTable=false&showMap=true"
                            title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                            frameBorder="0"></iframe>


                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="border m-2 shadow rounded">

                        <iframe
                            src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=first_dose&showTable=true&showMap=true"
                            title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                            frameBorder="0"></iframe>

                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="border m-2 shadow rounded">

                        <iframe
                            src="https://api.ncovtrack.com/vaccine/vietnam/provinces?metric=second_dose&showTable=true&showMap=true"
                            title="ncovtrack - COVID & Vaccination Statistics" height='550' width='100%'
                            frameBorder="0"></iframe>

                    </div>
                </div>
            </div>
            <div class="row justify-content-center pt-2">
                <a href="https://ncovtrack.com/vaccine/vietnam" class="banquyen">&copy;&nbsp; Bản quyền thuộc về
                    ncovtrack.com</a>
            </div>
        </div>
@endsection

@section('ex-script')
<script src="{{asset('user/js/calendar.js')}}"></script>
@endsection