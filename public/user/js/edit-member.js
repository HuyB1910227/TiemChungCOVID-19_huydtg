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

    $('#frmTSThanhVien').validate({
        rules: {

            rdDoTuoi: {
                required: true
            },
            txtHoTen: {
                required: true,
                minlength: 8
            },

            dtNgaySinh: {
                required: true,
                minAge: 6,
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

            dtNgayTiemGanNhat: {
                reqVC: true,
            }
        },
        messages: {

            rdDoTuoi: {
                required: "Chưa chọn độ tuổi"
            },
            txtHoTen: {
                required: "Bạn chưa nhập vào họ và tên",
                minlength: "Họ và tên phải có ít nhất 8 ký tự!"
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

                number: "Căn cước công dân sai định dạng"
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
    var rdDoTuoi = $('input[name=rdDoTuoi]');
    console.log(rdDoTuoi);
    rdDoTuoi.on('change', function() {

        var DoTuoi = $("input[type='radio'][name='rdDoTuoi']:checked").val();

        if (DoTuoi == 0) {
            console.log("vo");
            $("#txtCCCD").val('000000000000');
            $("#txtCCCD").attr("readonly");
        } else {
            $("#txtCCCD").val("");
            $("#txtCCCD").removeAttr("readonly");
        }

    });
});