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
}, "Ngày sinh không hợp lệ!");
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
    var t1 = 0;
    var t2 = 0;
    $('#txtTen').on("change", function() {
        var userName = $(this).val();
        $.ajax({
            url: 'scriptObject.php',
            type: 'POST',
            data: {
                'userName': userName
            },
            success: function(response) {
                var json = $.parseJSON(response);
                if (json.status == 'error'){
                    $('#error_tendangnhap').hide();
                    t1 = 0;
                }
                else if (json.status == 'success') {
                    $('#error_tendangnhap').show().text("Tên đăng nhập đã được sử dụng!");
                    t1 = 1; 
                }
            }
        });

    });

    $('#txtSoDienThoai').on("change", function() {
        var userContact = $(this).val();
        $.ajax({
            url: 'scriptObject.php',
            type: 'POST',
            data: {
                'userContact': userContact
            },
            success: function(response) {
                var json = $.parseJSON(response);
                if (json.status == 'error'){
                    $('#error_sdt').hide();
                    t2 = 0;
                }
                else if (json.status == 'success') {
                    $('#error_sdt').show().text("Số điện thoại đã được sử dụng!");
                    t2 = 1;
                }
            }
        });
    });

    $('#signupForm').validate({
        rules: {
            txtTen: {
                required: true,
                minlength: 8
            },
            txtHoTen: {
                required: true,
                minlength: 8
            },
            txtSoDienThoai: {
                required: true,
                rangelength: [10, 10],
                number: true
            },
            dtNgaySinh: {
                required: true,
                minAge: 18,
            },
            rdGioiTinh: {
                required: true
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
            txtCCCD: {
                required: true,
                number: true,
                lengthCC: true

            },
            pwd: {
                required: true,
                minlength: 8
            },
            re_pwd: {
                required: true,
                minlength: 8,
                equalTo: "#pwd"
            },
            dtNgayTiemGanNhat: {
                reqVC: true,
            }
        },
        messages: {
            txtTen: {
                required: "Bạn chưa nhập vào tên đăng nhập",
                minlength: "Tên đăng nhập phải có ít nhất 8 ký tự!"
            },
            txtHoTen: {
                required: "Bạn chưa nhập vào họ và tên",
                minlength: "Họ và tên phải có ít nhất 8 ký tự!"
            },
            txtSoDienThoai: {
                required: "Bạn chưa nhập vào số điện thoại",
                rangelength: "Tên đăng nhập phải có 10 ký tự số!",
                number: "Số điện thoại sai định dạng"
            },
            dtNgaySinh: {
                required: "Bạn chưa nhập vào ngày sinh",
                minAge: "Ngày sinh không hợp lệ!"
            },
            rdGioiTinh: "Bạn chưa chọn giới tính",
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
                rangelength: "Căn cước công dân phải có 8 hoặc 12 ký tự số!",
                number: "Căn cước công dân sai định dạng"
            },
            pwd: {
                required: "Bạn chưa nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 8 ký tự!",
            },
            re_pwd: {
                required: "Bạn chưa nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 8 ký tự!",
                equalTo: "Mật khẩu không trùng khớp với mật khẩu vừa nhập!"
            },
        },
        errorElement: "div",
        errorPlacement: function(error, element) {
            error.addClass("invalid-feedback");
            if (element.prop("name") === "rdGioiTinh") {
                error.insertAfter(element.parent("div").siblings("label.gioitinh"));
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
    $('input').on("keyup",function(){
        $('input').each(function(){
            if($(this).hasClass("is-invalid") || t1 == 1 || t2 == 1){
                $("#btnDangKy").attr("disabled", "disabled")
                return false;
            }
            $("#btnDangKy").removeAttr("disabled")
        })
    })
    var inputSLT = $('input[name="nbSoLanTiem"]');
    var inputNTGN = $('input[name="dtNgayTiemGanNhat"]');
    var inputVTGN = $('select[name="slvaccineTiemGanNhat"]');
    inputSLT.on("change", function() {
        if (inputSLT.val() == 0) {
            inputNTGN.val("0000-00-00")
            inputNTGN.attr("readonly", true)
            inputVTGN.val("")
            inputVTGN.attr('disabled', 'disabled')
        } else {
            inputNTGN.removeAttr("readonly")
            inputVTGN.removeAttr("disabled")
        }
    });
});