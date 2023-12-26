@extends('layouts.ManagerApp')

@section('breadcrumb')
        <li class="breadcrumb-item">Đăng ký tiêm chủng</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý đăng ký tiêm</li>
       
@endsection

@section('title', 'Thống kê')

@section('main-content')
@if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div> 
    @endif
    {{-- <h2 class="text-center text-uppercase"> Đăng ký tiêm chủng</h2> --}}
    
<div class="separator"></div>
<div class="m-3">
    <form class="bg-white card mb-1 shadow">
        <div class="row p-3">
            <div class="col-3">
                <div class="form-group">
                    <label for="inputPassword">Trạng thái</label>

                    <select id="status" name="status" class="custom-select searchField" column="3">
                        <option value="0" {{request('status') === 0 ? "selected" : ""}}>Chờ xác nhận</option>
                        <option value="" {{request('status') == null ? "selected" : ""}}>Tất cả</option>
                        <option value="-2" {{request('status') == -2 ? "selected" : ""}} >Đã hủy</option>
                        <option value="-1" {{request('status') == -1 ? "selected" : ""}}>Đã từ chối</option>
                        
                        <option value="1" {{request('status') == 1 ? "selected" : ""}}>Xác nhận</option>
                        <option value="2" {{request('status') == 2 ? "selected" : ""}}>Đã hoàn thành</option>
                    </select>

                </div>
            </div>
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
            
            
            <div class="col-12">
              
                <div class="form-group ">
                    <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Tìm kiếm</button>
                    <a href="{{route('manager.vaccination.registration')}}" class="btn btn-primary"><i class="fa-solid fa-repeat"></i></a>
                </div>
                
            </div>

        </div>
    </form>
    
    <div class="bg-white card shadow">
        <div class="card-header ">
            <form action="{{route('manager.vaccination.registration.confirmMany', "abc")}}" method="post" class="ml-2">
                @csrf
                <input type="text" name="IDs" hidden/>
                {{-- <button type="submit" value="Submit" class="btn btn-primary ">Xác nhận</button> --}}
                <button type="submit" value="Submit" class="btn btn-primary " id="btnConfirmList" disabled>Xác nhận <span class="bg-white text-primary badge rounded-circle">0</span></button>

            </form>    
        </div>
        <div class="card-body">
                <table class="table table-striped table-bordered table-responsive-lg" id="vaccination-registration">
                <thead>
                    <tr>
                        <th>Chọn</th>
                        <th>Mã số</th>
                        <th>Họ và tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>CMND/CCCD</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Ngày đăng ký</th>
                        <th>Mũi tiêm đăng ký</th>
                        <th>Lịch tiêm</th>
                        <th>Điểm bất thường</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filteredData as $regForm)
                
                        
                    <tr>
                        <td>
                            <input type="checkbox" name="listForms[]" value="{{$regForm->id}}" {{$regForm->status == 0 ? '' : 'disabled'}}>
                        </td>
                    
                        <td>{{$regForm->id}}</td>
                        <td>{{$regForm->patient->full_name}}</td>
                        <td>{{date("d/m/Y", strtotime($regForm->patient->date_of_birth))}}</td>
                        <td>{{$regForm->patient->gender}}</td>
                        <td>{{$regForm->patient->identify_card}}</td>
                        <td>{{$regForm->patient->address}}</td>
                        <td>{{$regForm->patient->phone}}</td>
                        
                        <td>{{date("d/m/Y", strtotime($regForm->registration_date))}}</td> 
                        <td>{{$regForm->injection_times != "AD" ? $regForm->injection_times : "Bổ sung"}}</td>
                        <td>{{date("d/m/Y", strtotime($regForm->schedule->vaccination_date))}}</td>
                        
                        
                        <td class="text-danger text-center">{{$regForm->unusual_point == 0 ? "" : "X"}}</td>
                        <td class="font-weight-bold font-italic">
                            @if ($regForm->status == 0)
                            <span class="badge badge-secondary">Chờ xét duyệt</span>
                            @elseif ($regForm->status == 1)
                                <span class="badge badge-primary">Đã xác nhận</span>
                            @elseif ($regForm->status == 2)
                                <span class="badge badge-success">Đã tiêm</span>
                            @elseif ($regForm->status == -1)
                                <span class="badge badge-warning">Đã từ chối</span>
                            @elseif ($regForm->status == -2)
                                <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        
                    
                        <td>
                            <form action="{{route('manager.vaccination.registration.show', $regForm->id)}}" method="post">
                                @csrf
                                <button class="btn btn-light m-1 button-no-des">
                                    <i class="fa-solid fa-info"></i>
                                </button>
                            </form>
                            @if ($regForm->status == 0 && $regForm->vaccination_date <= date("Y-m-d") && $regForm->end_time <= date("H:i:s"))
                                <form action="{{route('manager.vaccination.registration.confirm', $regForm->id)}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary m-1 confirm-btn button-no-des btnConfirm">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            
                                <form action="{{route('manager.vaccination.registration.refuse', $regForm->id)}}" method="post">
                                    @csrf
                                    <button class="btn btn-warning text-white m-1 refuse-btn button-no-des btnRefuse" >
                                        <i class="fa-solid fa-ban"></i> 
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
{{-- <script>
    $('.confirm-btn').click(function (e) {
        e.preventDefault();

        var formId = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: `{{route('manager.vaccination.registration.confirm', $formId)}}`,
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function (response) {
                // handle the response from the server
            }
        });
    });
</script> --}}
<script>
     $(document).ready(function() {
        const countStringIDS = (input) => {
            var $arrayIds = input.split(',');
            return $arrayIds.length;
        }
        $("input[name='listForms[]']").on("click", function(){
                var checkedValues = $("input[name='listForms[]']:checked").map(function() {
                    return this.value;
                }).get();
            
            $("input[name='IDs']").val('');
            $("input[name='IDs']").val(checkedValues.join(","));    
            if( $("input[name='IDs']").val() != ''){
                // var $arrayIds = $("input[name='IDs']").val().split(',');

                $('#btnConfirmList span').text(countStringIDS($("input[name='IDs']").val()));
                $('#btnConfirmList').prop({
                    disabled: false
                });
                
                // console.log($arrayIds.length)
            } else {
                $('#btnConfirmList').prop({
                    disabled: true
                });
                $('#btnConfirmList span').text("0");
            }

            $('#btnConfirmList').on("click", function(e) {
                console.log("yes");
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: `Bạn có chắc chắn xác nhận ${countStringIDS($("input[name='IDs']").val())} phiếu tiêm vừa chọn?`,
                    text: "Sau khi đồng ý, trạng thái các phiếu tiêm không thể hoàn tác!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý gửi!',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.trigger('submit');
                    }
                });
            });
        });


        $("input[name='IDs']").on("input", function () {
            // if($(this).val() == ''){
            //     console.log('no');
            // }
            console.log($(this));
        });

        $('.btnConfirm').on("click", function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn xác nhận?',
                text: "Sau khi đồng ý xác nhận, trạng thái phiếu tiêm không thể hoàn tác!",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Đồng ý ',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.trigger('submit');
                }
            })
        });

        $('.btnRefuse').on("click", function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Bạn có chắc chắn từ chối?',
                text: "Sau khi từ chối, trạng thái phiếu tiêm không thể hoàn tác!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f5ad42',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Từ chối',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.trigger('submit');
                }
            })
        });
    });
</script>



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