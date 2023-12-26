@extends('layouts.EmployeeApp')

@section('title', 'Tiêm chủng')
@section('breadcrumb')
        <li class="breadcrumb-item">Xử lý tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Xử lý tiêm chủng</li>

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

    {{-- <h2 class="text-center text-uppercase"> Xử lý tiêm chủng</h2> --}}

    {{-- <div class="separator"></div> --}}
    
    <div class="m-3 d-block">
        <form class="bg-white card mb-1 shadow">
            <div class="row p-3">
                
                <div class="col-3">
                    <div class="form-group">
                        <label for="inputPassword">Lịch tiêm</label>
                        <input type="date" id="vaccination_date" name="vaccination_date" class="form-control searchField" column="12" value="{{request('vaccination_date')}}">
                    </div>
                </div>
                
                <div class="col-3">
                    <div class="form-group">
                        <label for="inputPassword">Ngày đăng ký</label>
                        <input type="date" id="registration_date" name="registration_date" class="form-control searchField" column="12" value="{{request('registration_date')}}">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="inputPassword">Điểm bất thường</label>
                        <select name="unusual_point" id="unusual_point" class="custom-select searchField" column="3">
                            <option value="" {{request('unusual_point') == '' ? "selected" : ""}}>Tất cả</option>
                            <option value="1" {{request('unusual_point') == 1 ? "selected" : ""}}>Có</option>
                            <option value="0" {{request('unusual_point') === 0 ? "selected" : ""}}>Không</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="inputPassword">Vắc xin</label>
                        <select name="vaccine_id" id="vaccine_id" class="custom-select searchField" column="3">
                            <option value="">--Chọn--</option>
                            @foreach ($vaccines as $vaccine)
                                <option value="{{$vaccine->id}}"{{request('vaccine_id') == $vaccine->id ? "selected" : ''}}>{{$vaccine->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                
                
                <div class="col-12">
                  
                    <div class="form-group ">
                        <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>Tìm kiếm</button>
                        <a href="{{route('employee.vaccination.execution')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
    
                    </div>
                    
                </div>
    
            </div>
        </form>
        <div class="bg-white card shadow">
            <div class="card-header ">
                           
            </div>
            <div class="card-body">
                    <table class="table table-striped table-bordered table-responsive-lg" id="vaccination-execute">
                    <thead>
                        <tr>
                            <th>Mã số phiếu</th>
                            
                            <th>Họ và tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>CMND/CCCD</th>
                            {{-- <th>Địa chỉ</th> --}}
                            <th>Số điện thoại</th>
                            <th>Ngày đăng ký</th>
                            <th>Lịch tiêm</th>
                            <th>Điểm bất thường</th>
                            <th>Lần tiêm</th>
                            <th>Vắc xin</th>
                            <th>Mã lô</th>
                            <th>Y/c mũi bổ sung</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($filteredData as $regForm)
                            @if ($regForm->status == 1)
                                
                            
                            <tr>
                                <td>{{$regForm->id}}</td>
                               
                                <td>{{$regForm->patient->full_name}}</td>
                                <td>{{$regForm->patient->date_of_birth}}</td>
                                <td>{{$regForm->patient->gender ? "Nam" : "Nữ"}}</td>
                                <td>{{$regForm->patient->identify_card}}</td>
                                {{-- <td>{{$regForm->patient->address}}</td> --}}
                                <td>{{$regForm->patient->phone}}</td>
                                <td>{{$regForm->created_at}}</td>
                                <td>{{$regForm->schedule->vaccination_date}}</td>
                                <td class="text-danger">{!!$regForm->unusual_point == 0 ? "" : '<i class="fa-solid fa-xmark"></i>'!!}</td>

                                <td>{{$regForm->injection_times}}</td>
                                <td>{{$regForm->schedule->vaccine->name}}</td>
                                <td >
                                    <form action="{{route('employee.vaccination.execution.store', $regForm->id)}}" id="{{'FormReg_'.$regForm->id}}" method="post" >
                                        @csrf
                                        {{-- <input type="text" id="regForm_id" value="{{$regForm->id}}"> --}}
                                    
                                        <select name="vaccine_lot_id" id="" class="custom-select">
                                            <option value="">--Chọn--</option>
                                            @foreach ($vaccineLots as $vaccineLot)
                                                
                                                @if ($vaccineLot->vaccine->id == $regForm->schedule->vaccine->id)
                                                    <option value="{{$vaccineLot->id }}">{{$vaccineLot->lot_code}}</option>
                                                @endif
                                                
                                            @endforeach
                                            
                                        </select>
                                        <span class="text-danger d-none" >Chưa chọn lô vắc xin tiêm</span>
                                        <br>
                                        {{-- FormReg_{{$regForm->id}} --}}
                                    
                                </td>
                                <td>
                                    <input type="checkbox" {{$regForm->patient->required_additional_dose == 1 ? "checked" : ""}} name="required_additional_dose" value="1">
                                </td>
                                <td >
                                    {{-- @if (strtotime($registrationForm->schedule->vaccination_date) <= now()) --}}
                                  
                                     
                                    
                                        
                                    {{-- @endif --}}
                                    

                                </form>
                                    {{-- @if (strtotime($regForm->schedule->vaccination_date) <= strtotime(now())) --}}
                                        <button class="btn btn-primary text-white button-no-des btn-confirm" data-role="{{$regForm->id}}" data-toggle="tooltip" data-placement="top" title="Xác nhận tiêm">
                                            <i class="fa-solid fa-syringe"></i> 
                                            
                                        </button>
                                    {{-- @endif --}}
                                    <form action="{{route('employee.vaccination.execution.show', $regForm->id)}}" method="post">
                                        @csrf
                                        <button class="btn btn-light button-no-des" data-toggle="tooltip" data-placement="top" title="Thông tin chi tiết">
                                            <i class="fa-solid fa-info"></i>
                                        </button>
                                    </form>
                                   
                                    <form action="{{route('employee.vaccination.execution.cancel', $regForm->id)}}" method="post">
                                        @csrf
                                        <input type="text" value="{{$regForm->id}}" hidden>
                                        <button class="btn btn-danger text-white button-no-des btnCancel" type="submit" data-toggle="tooltip" data-placement="top" title="Hủy tiêm">
                                            <i class="fa-solid fa-ban " ></i> 
                                        </button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        

                    </tbody>

                </table>     
           </div>
        </div>
        
    </div>
@endsection

@section('ex-script')
    <script>
        $(document).ready(function() {
            // const ConfirmForm = $('#FormReg_');
            // console.log($('.btn-confirm').data('role'));
        //    $('.btn-confirm').on("click" , function {
        //         console.log("yes");
        //         console.log($(this).data("role"));
        //         // console.log($(this).data("id"));
        //         // var str = '#FormReg_' + $(this).data("id");
        //         // var ConfirmForm = $(str);
        //         // var strSelect = str + " select";
        //         // var spanError = str + " span";
        //         // if($(strSelect).val() != 0) {
        //         //     return ConfirmForm.submit();
        //         // }
        //         // console.log(ConfirmForm)
        //         // ConfirmForm.submit();
        //     });
            $('.btn-confirm').on("click", function() {
                console.log($(this).data("role"));
                var str = '#FormReg_' + $(this).data("role");
                console.log(str);
                var ConfirmForm = $(str);
                var strSelect = str + " select";
                var spanError = str + " span";
                if($(strSelect).val() != 0) {
                    return ConfirmForm.submit();
                }
                $(spanError).removeClass('d-none');
            })
        });
    </script>
    
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#vaccination-execute').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Vietnamese.json",
                },
               
            });
        });
    </script>
    
    <script>
        $('.btnCancel').on("click", function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        Swal.fire({
            title: 'Bạn có hủy tiêm?',
            text: "Sau khi đồng ý xác nhận, trạng thái phiếu tiêm không thể hoàn tác!",
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