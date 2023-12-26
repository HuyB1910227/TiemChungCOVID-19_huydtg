@extends('layouts.UserApp')
@section('title', 'Thông tin cá nhân')
@section('main-content')
<div class="container-lg ">
    <div class="row my-2">

        <div class="col-12">
            <div class="row">
                @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show col-12" role="alert">
                    <strong><i class="fa-regular fa-circle-check"></i> {{session('status')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div> 
                @endif
            </div>
            <div class="row">
                
                <div class="col">
                    
                    <div class="row">
                        <div class="col-12">
                            <div style="display: flex; align-items: center; ">
                                <div class="avatar-left">
                                    <img src="{{asset($patient->avatar)}}" alt="" class="rounded-circle mx-auto" width="150px" height="150px">
                                </div>
                                <div class="text-avatar-right">
                                    <h4>Xin chào!</h4>
                                    <h3 style="color: #616AC6; text-shadow: 1px 1px 2px #616AC6">{{$patient->full_name}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <form action="{{route('profile.update.avatar', $patient->id)}}" method="post" enctype="multipart/form-data">
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
                    <button class="btn btn-warning float-right text-light" data-toggle="modal" data-target="#exampleModal"><i class="fa-solid fa-pen-to-square"></i> Sửa thông tin cá nhân</button>
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
                            <td class="w-50">{{$patient->full_name}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Ngày sinh:</td>
                            <td>{{date("d/m/Y", strtotime($patient->date_of_birth))}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Giới tính:</td>
                            <td>{{$patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Số điện thoại:</td>
                            <td>{{$patient->phone}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">CMND/CCCD:</td>
                            <td>{{$patient->identify_card}}</td>
                        </tr>
                        @php
                            $addr = explode(' ; ', $patient->address)
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
                        <tr>
                            <td class="font-weight-bold">Nghề nghiệp:</td>
                            <td>{{$patient->career == null ? "Chưa cập nhật" : $patient->career}}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Yêu cầu tiêm bổ sung:</td>
                            <td>{{$patient->required_additional_dose == 1 ? "Có" : "Không"}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="col-12 col-md-6 mt-2">
            <div class="row bg-white justify-content-center pt-2">
                <h4>Thông tin khác</h4>
                <div class="col-12 p-0">
                    <table class="table table-striped mb-0">
                        
                        <tr>
                            <td class="font-weight-bold">Ngày tiêm gần nhất:</td>
                            <td>{{$patient->vaccinationHistories->number_of_injection ? }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Vắc xin đã tiêm gần nhất:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Hiệu lực:</td>
                            <td></td>
                        </tr>
                        
                        
                    </table>
                </div>
            </div>

        </div> --}}
    </div>
    {{-- <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false"> --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-show="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa thông tin cá nhân!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('profile.update', $patient->id)}}" method="post" id="frmTTCN">
                        @csrf
                        <div class="form-group">
                            <label for="txtHoTen">Họ và tên <span class="required-fill-in">*</span></label>
                            <input type="text" name="txtHoTen" id="txtHoTen" placeholder="" class="form-control" value="{{old("txtHoTen", $patient->full_name)}}">
                        </div>

                        <div class="form-group">
                            <label for="dtNgaySinh">Ngày sinh <span class="required-fill-in">*</span></label>
                            <input type="date" name="dtNgaySinh" id="dtNgaySinh" placeholder="" class="form-control" value="{{old("dtNgaySinh", $patient->date_of_birth)}}">
                        </div>
                        <legend class="col-form-label">Giới tính <span class="required-fill-in">*</span></legend>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="rdGioiTinh" value="1" class="form-check-input" {{old("rdGioiTinh", $patient->gender) == 1 ? "checked" : ""}}>
                            <label for="rdGioiTinh1" class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="rdGioiTinh" value="0" class="form-check-input" {{old("rdGioiTinh", $patient->gender) == 0 ? "checked" : ""}}>
                            <label for="rdGioiTinh2" class="form-check-label">Nữ </label>
                        </div>
                        
                        {{-- <div class="form-group">
                            <label for="txtCCCD">Số hộ chiếu/CMND/CCCD <span class="required-fill-in">*</span></label>
                            <input type="text" name="txtCCCD" id="txtCCCD" placeholder="" class="form-control" value="{{$patient->identify_card}}">
                        </div> --}}
                        
                        <div class="form-group">
                            <label for="">Tỉnh/ Thành phố <span class="required-fill-in">*</span></label>
                            <select name="txtTP" id="txtTP" class="custom-select">
                                <option value="{{old('txtTP') ? old('txtTP') : $addr[3]}}">{{old('txtTP') ? old('txtTP') : $addr[3]}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Quận/ Huyện <span class="required-fill-in">*</span></label>
                            <select name="txtQH" id="txtQH" class="custom-select">
                                <option value="{{old('txtQH') ? old('txtQH') : $addr[2]}}">{{old('txtQH') ? old('txtQH') : $addr[2]}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Phường/ Xã <span class="required-fill-in">*</span></label>
                            <select name="txtPX" id="txtPX" class="custom-select">
                                <option value="{{old('txtPX') ? old('txtPX') : $addr[1]}}">{{old('txtPX') ? old('txtPX') : $addr[1]}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="txtDiaChi">Địa chỉ <span class="required-fill-in">*</span></label>
                            <input type="text" name="txtDiaChi" id="txtDiaChi" placeholder="" class="form-control" value="{{old('txtDiaChi', $addr[0])}}">
                        </div>
                        <hr>
                        
                        <div class="form-group">
                            <label for="telSDT">Số điện thoại <span class="required-fill-in">*</span></label>
                            <input type="tel" name="telSDT" id="telSDT" placeholder="" class="form-control" value="{{old('telSDT', $patient->phone)}}">
                            @error('telSDT')
                                <div class="error-block mt-1">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="required-fill-in">*</span></label>
                            <input type="email" name="email" id="email" placeholder="" class="form-control" value="{{old('email', $patient->email)}}">
                            @error('email')
                                <div class="error-block mt-1">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="txtNgheNghiep">Nghề nghiệp</label>
                            <input type="text" name="txtNgheNghiep" id="txtNgheNghiep" placeholder="" class="form-control" value="{{old('txtNgheNghiep', $patient->career) == null ? "Chưa cập nhật" : $patient->career}}">
                        </div>
                        <div class="form-group">
                            <p class="text-danger">Lưu ý: Bạn không thể chỉnh sửa yêu cầu tiêm bổ sung, nếu xảy ra sai sót, hãy liên hệ đến cơ sở tiêm chủng của mũi tiêm gần nhất để được hỗ trợ! <br> Xem chi tiết lịch sử tiêm <a href="{{route('patient.vaccination.history')}}">tại đây</a> </p>
                        </div>
                        <button type="" class="btn btn-primary" name="btnLuuThayDoi" id="btnLuuThayDoi" hidden>Lưu thay đổi</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="btnKT">Cập nhật</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('ex-script')
<script>
$(document).ready(function () {
    @error('telSDT')
        $('#exampleModal').modal('show')
    @enderror
    @error('email')
        $('#exampleModal').modal('show')
    @enderror
    const tp = $('#txtTP');
    const qh = $('#txtQH');
    const px = $('#txtPX');
    // $.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
    //     console.log(data);
    //     $.each(data, function (index, elementType) {
            
    //         tp.append(`<option value="${elementType.name}">${elementType.name}</option>`);
            
    //     })
    //     if(tp.val() !== ""){
    //         var indexTP
    //         var arrQH
    //         var tenPX
    //         var indexQH
    //         var arrPX
    //         indexTP = data.indexOf(data.find((data) => data.name === tp.val()))
    //         console.log(indexTP)
    //         arrQH = data[indexTP].districts
    //         $.each(arrQH, function (index, elementQH) {
    //             qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
    //         })
    //         indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === qh.val()))
    //         arrPX = arrQH[indexQH].wards
    //         $.each(arrPX, function (index, elementPX) {
    //             px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
    //         })
    //         tp.on("change", function () {
    //             qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             px.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             var tenTP = $(this).val()
    //             indexTP = data.indexOf(data.find((data) => data.name === tenTP))
    //             console.log(indexTP)
    //             arrQH = data[indexTP].districts
    //             $.each(arrQH, function (index, elementQH) {
    //                 qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
    //             })

    //         })
    //         qh.on("change", function () {
    //             px.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             tenPX = $(this).val()
    //             indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
    //             arrPX = arrQH[indexQH].wards
    //             $.each(arrPX, function (index, elementPX) {
    //                 px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
    //             })
    //         })
    //     } else {
    //         var indexTP
    //         var arrQH
    //         tp.on("change", function () {
    //             qh.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             px.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             var tenTP = $(this).val()
    //             indexTP = data.indexOf(data.find((data) => data.name === tenTP))
    //             console.log(indexTP)
    //             arrQH = data[indexTP].districts
    //             $.each(arrQH, function (index, elementQH) {
    //                 qh.append(`<option value="${elementQH.name}">${elementQH.name}</option>`);
    //             })
    //         })
    //         qh.on("change", function () {
    //             px.find('option').remove().end().append('<option value="">--Chọn--</option>')
    //             var tenPX = $(this).val()
    //             var indexQH = arrQH.indexOf(arrQH.find((arrQH) => arrQH.name === tenPX))
    //             console.log(indexQH)
    //             var arrPX = arrQH[indexQH].wards
    //             $.each(arrPX, function (index, elementPX) {
    //                 px.append(`<option value="${elementPX.name}">${elementPX.name}</option>`);
    //             })
    //         })

    //     }
    // }).fail(function (error) {
    //     console.log(error)
    // });
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
    
})
</script>
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
$.validator.addMethod("reqVC", function(value) {
    var sc = new Date(value);
    var today = new Date();
    if ($("#nbSoLanTiem").val() == 0) {
        return true;
    }
    if ($("#nbSoLanTiem").val() != 0 && sc < today) {
        return true;
    }
    return false;
}, "Nhập vào ngày tiêm gần nhất");
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
            txtHoTen: {
                required: true,
                minlength: 8
            },

            dtNgaySinh: {
                required: true,
                minAge: 15,
            },
            txtTP: {
                required: true
            },
            txtQH: {
                required: true
            },
            txtPX: {
                required: true
            },
            txtDiaChi: {
                required: true
            },
            email: {
                required: true,
                // number: true,
                email: true


            },

            dtNgayTiemGanNhat: {
                reqVC: true,
            }
        },
        messages: {
            txtHoTen: {
                required: "Bạn chưa nhập vào họ và tên",
                minlength: "Họ và tên phải có ít nhất 8 ký tự!"
            },
            dtNgaySinh: {
                required: "Bạn chưa nhập vào ngày sinh",
                minAge: "Ngày sinh không hợp lệ!"
            },
            txtTP: {
                required: "Bạn chưa nhập tỉnh hoặc Thành Phố",
            },
            txtQH: {
                required: "Bạn chưa nhập Quận hoặc Huyện",
            },
            txtPX: {
                required: "Bạn chưa nhập Phường hoặc Xã",
            },
            txtDiaChi: {
                required: "Bạn chưa nhập địa chỉ",
            },
            txtCCCD: {
                required: "Bạn chưa nhập vào căn cước công dân",

                number: "Căn cước công dân sai định dạng"
            },
            email: {
                required: "Bạn chưa nhập vào email",
                // number: true,
                email: "Email không hợp lệ"
            }

        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("name") === "rdGioiTinh") {
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
    $('#btnKT').on("click", function() {
        $('#frmTTCN').valid();
        if ($('#frmTTCN').valid() == true) {
            $('#btnLuuThayDoi').trigger("click");
        }
    });
    $('#btnChangeAvatar').css('display', 'none');
    $('#fileToUpload').on("change", function() {
        if ($(this).val() != null) {
            $('#btnChangeAvatar').css('display', 'inline-block');
        }
    });
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
});
</script>

@endsection