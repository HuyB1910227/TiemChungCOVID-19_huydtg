@if (Auth::user()->hasRole('administrator'))
    
    @php
        $app = "layouts.AdminApp";
        $breadcrumb = 'admin.profile';
        $routeUpdateAvatar = "admin.profile.update.avatar";
        $routeUpdate = "admin.profile.update";
        
    @endphp
    

@elseif (Auth::user()->hasRole('manager'))
    @php
        $app = "layouts.ManagerApp";
        $breadcrumb = 'manager.profile';
        $routeUpdateAvatar = "manager.profile.update.avatar";
        $routeUpdate = "manager.profile.update";

    @endphp
@elseif (Auth::user()->hasRole('employee'))
    @php
        $app = "layouts.EmployeeApp";
        $breadcrumb = 'employee.profile';
        $routeUpdateAvatar = "employee.profile.update.avatar";
        $routeUpdate = "employee.profile.update";

    @endphp
@endif

@extends($app)
@section('breadcrumb')
    <li class="breadcrumb-item">Hồ sơ cá nhân</li>
    <li class="text-uppercase ml-auto font-weight-bold">Quản lý hồ sơ cá nhân</li>
    
@endsection

@section('main-content')
    <div class="row m-3">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show row" role="alert">
                                <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                    @endif
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col-12">
                            <div style="display: flex; align-items: center; ">
                                <div class="avatar-left mr-3">
                                    <img src="{{asset($details->avatar)}}" alt="" class=" mx-auto bg-white" width="200px" height="200px" >
                                </div>
                                <div class="text-avatar-right">
                                    <h4>Xin chào!</h4>
                                    <h3 style="color: #616AC6; text-shadow: 1px 1px 2px #616AC6">{{$details->full_name}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <form action="{{route($routeUpdateAvatar, Auth::id())}}" method="POST" enctype="multipart/form-data">
                                <br>
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-file">
                                            <input type="file" name="fileToUpload" id="fileToUpload" placeholder="Chọn ảnh đại diện" class="custom-file-input">
                                            <label class="custom-file-label" for="fileToUpload" aria-describedby="inputGroupFileAddon02">Chọn ảnh đại diện...</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="submit" class="btn btn-primary" id="btnChangeAvatar">Thay đổi ảnh đại diện</button>
                                    </div>
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col p-2 ">
                    <button class="btn btn-warning float-right text-light" data-toggle="modal" data-target="#exampleModal" id="mmodal"><i class="fa-solid fa-pen-to-square"></i> Sửa thông tin cá nhân</button>
                    {{-- <button class="btn btn-warning float-right mr-1 text-light"><i class="fa-solid fa-lock"></i> Đổi mật khẩu</button> --}}
                </div>
            </div>
        </div>
        <div class="col-12 bg-white mt-2">
            <div class="row rounded rounded-3 justify-content-center p-2 ">
                <h4>Thông tin chính</h4>
                <div class="col-12 p-0">
                    <table class="table table-striped mb-0">
                        <tr>
                            <td class="w-50 font-weight-bold">Họ và tên: </td>
                            <td class="w-50">{{$details->full_name}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ngày sinh:</td>
                            <td>{{date("d/m/Y", strtotime($details->date_of_birth))}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Giới tính:</td>
                            <td>{{$details->gender == 1 ? "Nam" : "Nữ"}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Số điện thoại:</td>
                            <td>{{$details->phone}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">CMND/CCCD:</td>
                            <td>{{$details->identify_card}}</td>
                        </tr>
                        @if (Auth::user()->hasRole('employee') || Auth::user()->hasRole('manager'))
                            <tr>
                                <td class="font-weight-bold">Mã nhân viên:</td>
                                <td>{{$details->employee_id}}</td>
                            </tr>
                        @endif
                        @php
                            $addr = explode(' ; ', $details->address)
                        @endphp
                        <tr>
                            <td class="font-weight-bold">Thành phố:</td>
                            <td>{{$addr[3]}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Quận/huyện:</td>
                            <td>{{$addr[2]}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Phường/xã:</td>
                            <td>{{$addr[1]}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Địa chỉ:</td>
                            <td>{{$addr[0]}}</td>
                        </tr>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-show="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thông tin cá nhân</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <form action="{{route($routeUpdate, $details->id)}}" method="post" id="frmTTCN">
                            @csrf
                            <div class="form-group">
                                <label for="full_name">Họ và tên <span class="required-fill-in">*</span></label>
                                <input type="text" name="full_name" id="full_name" placeholder="" class="form-control" value="{{old('full_name', $details->full_name)}}">
                            </div>
    
                            <div class="form-group">
                                <label for="date_of_birth">Ngày sinh <span class="required-fill-in">*</span></label>
                                <input type="date" name="date_of_birth" id="date_of_birth" placeholder="" class="form-control" value="{{old('date_of_birth', $details->date_of_birth) }}">
                            </div>
                            <legend class="col-form-label">Giới tính <span class="required-fill-in">*</span></legend>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="1" class="form-check-input" {{old('gender',$details->gender) == 1 ? "checked" : ""}}>
                                <label for="gender1" class="form-check-label">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="0" class="form-check-input" {{old('gender',$details->gender) == 0 ? "checked" : ""}}>
                                <label for="gender2" class="form-check-label">Nữ </label>
                            </div>
                            
                            <div class="form-group">
                                <label for="identify_card">Số hộ chiếu/CMND/CCCD <span class="required-fill-in">*</span></label>
                                <input type="text" name="identify_card" id="identify_card" placeholder="" class="form-control" value="{{old('identify_card', $details->identify_card)}}">
                                @error('identify_card')
                                    <div class="error-block mt-1">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            
                            
                            <div class="form-group">
                                <label for="">Tỉnh/ Thành phố <span class="required-fill-in">*</span></label>
                                <select name="province" id="province" class="custom-select">
                                    <option value="{{old('province') ? old('province') : $addr[3]}}">{{old('province') ? old('province') : $addr[3]}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Quận/ Huyện <span class="required-fill-in">*</span></label>
                                <select name="district" id="district" class="custom-select">
                                    <option value="{{old('district') ? old('district') : $addr[2]}}">{{old('district') ? old('district') : $addr[2]}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Phường/ Xã <span class="required-fill-in">*</span></label>
                                <select name="village" id="village" class="custom-select">
                                    <option value="{{old('village') ? old('village') : $addr[1]}}">{{old('village') ? old('village') : $addr[1]}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Địa chỉ <span class="required-fill-in">*</span></label>
                                <input type="text" name="address" id="address" placeholder="" class="form-control" value="{{old('address', $addr[0])}}">
                            </div>
                            <hr>
                           
                            <div class="form-group">
                                <label for="phone">Số điện thoại <span class="required-fill-in">*</span></label>
                                <input type="tel" name="phone" id="phone" placeholder="" class="form-control" value="{{old('phone', $details->phone)}}">
                                @error('phone')
                                    <div class="error-block mt-1">
                                        <strong>{{$message}}</strong>
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label for="employee_id">Mã nhân viên <span class="required-fill-in">*</span></label>
                                <input type="tel" name="employee_id" id="employee_id" placeholder="" class="form-control" value="{{$details->employee_id}}">
                                
                            </div> --}}

                            {{-- <button type="submit" id="btnLuuThayDoi">Gửi</button> --}}
                        </form>
                    </div>
                    <div class="modal-footer">
                        {{-- <input type="text"> --}}
                        <button class="btn btn-primary" id="btnCheck" >Cập nhật</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('ex-script')
<script>
    $(document).ready(function () {
        @error('identify_card')
            $('#exampleModal').modal('show')
        @enderror
        @error('phone')
            $('#exampleModal').modal('show')
        @enderror
        
        const tp = $('#province')
        const qh = $('#district')
        const px = $('#village')

        $.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
        console.log(data);
        $.each(data, function (index, elementType) {
            
            tp.append(`<option value="${elementType.name}">${elementType.name}</option>`);
            
        })


    if(tp.val() !== ""){
        var indexTP
        var arrQH
        var tenPX
        var indexQH
        var arrPX
        indexTP = data.indexOf(data.find((data) => data.name === tp.val()))
        console.log(indexTP)
        arrQH = data[indexTP].districts
        $.each(arrQH, function (index, elementQH) {
            qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
        })
        indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === qh.val()))

        arrPX = arrQH[indexQH].wards
        $.each(arrPX, function (index, elementPX) {
            px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
        })

        tp.on("change", function () {
        
            qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenTP = $(this).val()
            indexTP = data.indexOf(data.find((data) => data.name === tenTP))
            console.log(indexTP)
            arrQH = data[indexTP].districts
            $.each(arrQH, function (index, elementQH) {
            
                qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
            

            })

        })
        qh.on("change", function () {
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            tenPX = $(this).val()
            indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
            
            arrPX = arrQH[indexQH].wards
            $.each(arrPX, function (index, elementPX) {
                px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
            })
        })
    } else {
        var indexTP
        var arrQH

        tp.on("change", function () {
            
            qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenTP = $(this).val()
            indexTP = data.indexOf(data.find((data) => data.name === tenTP))
            console.log(indexTP)
            arrQH = data[indexTP].districts
            $.each(arrQH, function (index, elementQH) {
                var quanhuyen = elementQH.name
                qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
                

            })

        })
        qh.on("change", function () {
            px.find('option').remove().end().append('<option value="">--Chọn--</option>')
            var tenPX = $(this).val()
            var indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
            console.log(indexQH)
            var arrPX = arrQH[indexQH].wards
            $.each(arrPX, function (index, elementPX) {
                px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
            })
        })

    }
    }).fail(function (error) {

    });
    });
</script>
{{-- <script>
$(document).ready(function () {
    // @error('identify_card')
        $('#mmodal').click();
    // @enderror
    // @error('phone')
        // $('#exampleModal').modal('show')
    // @enderror
    const tp = $('#province')
    const qh = $('#district')
    const px = $('#village')
    $.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
        console.log(data);
        $.each(data, function (index, elementType) {
            
            tp.append(`<option value="${elementType.name}">${elementType.name}</option>`);
            
        })
        if(tp.val() !== ""){
            var indexTP
            var arrQH
            var tenPX
            var indexQH
            var arrPX
            indexTP = data.indexOf(data.find((data) => data.name === tp.val()))
            console.log(indexTP)
            arrQH = data[indexTP].districts
            $.each(arrQH, function (index, elementQH) {
                qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
            })
            indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === qh.val()))
            arrPX = arrQH[indexQH].wards
            $.each(arrPX, function (index, elementPX) {
                px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
            })
            tp.on("change", function () {
                qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
                px.find('option').remove().end().append('<option value="">--Chọn--</option>')
                var tenTP = $(this).val()
                indexTP = data.indexOf(data.find((data) => data.name === tenTP))
                console.log(indexTP)
                arrQH = data[indexTP].districts
                $.each(arrQH, function (index, elementQH) {
                    qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
                })

            })
            qh.on("change", function () {
                px.find('option').remove().end().append('<option value="">--Chọn--</option>')
                tenPX = $(this).val()
                indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
                arrPX = arrQH[indexQH].wards
                $.each(arrPX, function (index, elementPX) {
                    px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
                })
            })
        } else {
            var indexTP
            var arrQH
            tp.on("change", function () {
                qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
                px.find('option').remove().end().append('<option value="">--Chọn--</option>')
                var tenTP = $(this).val()
                indexTP = data.indexOf(data.find((data) => data.name === tenTP))
                console.log(indexTP)
                arrQH = data[indexTP].districts
                $.each(arrQH, function (index, elementQH) {
                    qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
                })
            })
            qh.on("change", function () {
                px.find('option').remove().end().append('<option value="">--Chọn--</option>')
                var tenPX = $(this).val()
                var indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
                console.log(indexQH)
                var arrPX = arrQH[indexQH].wards
                $.each(arrPX, function (index, elementPX) {
                    px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
                })
            })

        }
    }).fail(function (error) {
        console.log(error)
    });
})
</script> --}}
<script>
    $.validator.addMethod("minAge", function(value, element, min) {
    var today = new Date();
    var birthDate = new Date(value);
    var age = today.getFullYear() - birthDate.getFullYear();

    if (age > min + 1) {
        return true;
    }

    var m = today.getMonth() - birthDate.getMonth();

    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age >= min;
    }, "Bạn chưa đủ tuổi!");
    
    $.validator.addMethod("lengthCC", function(value, element) {
        if (element.value.length == 8 || element.value.length == 9 || element.value.length == 12) {
            return true;
        } else {
            return false;
        }
    }, "Mã thẻ phải có 8 hoặc 9 hoặc 12 ký tự số!");
    $(document).ready(function() {
        $('#frmTTCN').validate({
            rules: {
                full_name: {
                    required: true,
                    minlength: 8
                },

                date_of_birth: {
                    required: true,
                    minAge: 18,
                },
                province: {
                    required: true
                },
                district: {
                    required: true
                },
                village: {
                    required: true
                },
                address: {
                    required: true
                },
                identify_card: {
                    required: true,
                    number: true,
                    lengthCC: true


                },

                
            },
            messages: {
                full_name: {
                    required: "Bạn chưa nhập vào họ và tên",
                    minlength: "Họ và tên phải có ít nhất 8 ký tự!"
                },
                date_of_birth: {
                    required: "Bạn chưa nhập vào ngày sinh",
                    minAge: "Ngày sinh không hợp lệ!"
                },
                province: {
                    required: "Bạn chưa nhập tỉnh hoặc Thành Phố",
                },
                district: {
                    required: "Bạn chưa nhập Quận hoặc Huyện",
                },
                village: {
                    required: "Bạn chưa nhập Phường hoặc Xã",
                },
                address: {
                    required: "Bạn chưa nhập địa chỉ",
                },
                identify_card: {
                    required: "Bạn chưa nhập vào căn cước công dân",

                    number: "Căn cước công dân sai định dạng"
                }
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("name") === "gender") {
                    error.insertAfter(element.parent("div").siblings("legend.gioitinh"));
                } else if (element.prop("name") === "rdDoTuoi") {
                    error.insertAfter(element.parent("div").siblings("legend.dotuoi"));

                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {

                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {

                $(element).addClass("is-valid").removeClass("is-invalid");


            }
        });
        $('#btnCheck').on("click", function() {
            console.log("yes");
            $('#frmTTCN').valid();
            if ($('#frmTTCN').valid() == true) {
                $('#frmTTCN').submit();
            } else {
                console.log("no");
            }
        });
        $('#btnChangeAvatar').css('display', 'none');
        $('#fileToUpload').on("change", function() {
            if ($(this).val() != null) {
                $('#btnChangeAvatar').css('display', 'inline-block');
            }
        });
        // $('input[type="file"]').change(function(e) {
        //     var fileName = e.target.files[0].name;
        //     $('.custom-file-label').html(fileName);
        // });
    });
</script>

@endsection