@extends('layouts.UserApp')
@section('title', 'Tài khoản')
@section('main-content')
<div class="container-lg ">
    <h3 class="titile mb-2">Sửa tài khoản</h3>
    <form action="{{route('patient.account.update')}}" method="POST" id="signupForm" style="width: 400px; margin: auto">
        @csrf
        <div class="row ">
            <div class="col-12 col-sm-12">
                @if(session('fail'))
                    <div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <strong><i class="fa-regular fa-circle-check"></i> {{session('fail')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                @endif
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show " role="alert">
                        <strong><i class="fa-regular fa-circle-check"></i> {{session('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div> 
                @endif
                <div class="form-group">
                    <label for="name">CMND/CCCD/BHYT <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="identify_card" name="identify_card"
                            placeholder="Nhập vào tên chứng minh nhân dân...." value="{{old('identify_card', $patient->identify_card)}}">
                    </div>
                   
                    @error('identify_card')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
               
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="changePass[]" id="changePass" value="1" {{ session('fail') !== null ? 'checked' : '' }}>
                    <label class="form-check-label" for="exampleRadios1">
                        Đổi mật khẩu
                    </label>
                </div>
                <div class="form-group d-none">
                    <label for="password">Mật khẩu cũ <span class="required-fill-in">*</span></label>
                    <div class="input-group">

                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Nhập vào mật khẩu...." value="{{old('password')}}">
                    </div>
                    {{-- <div class="text-danger mt-1">
                        <p id="error_mk"></p>
                    </div> --}}
                    @error('password')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group d-none">
                    <label for="npwd">Mật khẩu mới <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="npwd" name="npwd"
                            placeholder="Nhập vào mật khẩu...." {{old('npwd')}}>
                    </div>
                    @error('full_name')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group d-none">
                    <label for="npwd">Nhập lại mật khẩu <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="re_npwd" name="re_npwd"
                            placeholder="Nhập vào mật khẩu...." {{old('re_pwd')}}>
                    </div>
                    @error('full_name')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <hr>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-6">
                <a class="btn btn-light rounded-circle border border-primary text-primary "
                    href="trangchu.php"><i class="fa-solid fa-arrow-left"></i></a>
            </div> --}}
            <div class="col-6">
                <button type="submit" class="btn btn-primary rounded-pill w-100 mt-2 " name="btnDangKy"
                    id="btnDangKy">Cập nhật</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('ex-script')
    <script>
        $(document).ready(function() {
            var t1 = 0
            var t2 = 0
            var t3 = 0
            if ($('#changePass').is(":checked")) {
                    $('#password').parents("div.form-group").removeClass("d-none");
                    $('#npwd').parents("div.form-group").removeClass("d-none");
                    $('#re_npwd').parents("div.form-group").removeClass("d-none");
                } else {
                    $('#password').val(null);
                    $('#npwd').val(null);
                    $('#re_npwd').val(null);
                    $('#password').parents("div.form-group").addClass("d-none");
                    $('#npwd').parents("div.form-group").addClass("d-none");
                    $('#re_npwd').parents("div.form-group").addClass("d-none");
                }
            $('#changePass').on("change", function() {
                if ($(this).is(":checked")) {
                    $('#password').parents("div.form-group").removeClass("d-none");
                    $('#npwd').parents("div.form-group").removeClass("d-none");
                    $('#re_npwd').parents("div.form-group").removeClass("d-none");
                } else {
                    $('#password').val(null);
                    $('#npwd').val(null);
                    $('#re_npwd').val(null);
                    $('#password').parents("div.form-group").addClass("d-none");
                    $('#npwd').parents("div.form-group").addClass("d-none");
                    $('#re_npwd').parents("div.form-group").addClass("d-none");
                }
            });
            
            // $('#signupForm').validate({
            //     rules: {
            //         txtTen: {
            //             required: true,
            //             minlength: 8
            //         },
            //         npwd: {

            //             minlength: 8
            //         },
            //         re_npwd: {

            //             minlength: 8,
            //             equalTo: "#npwd"
            //         },

            //     },
            //     messages: {
            //         txtTen: {
            //             required: "Bạn chưa nhập vào tên đăng nhập",
            //             minlength: "Tên đăng nhập phải có ít nhất 8 ký tự!"
            //         },
            //         pwd2: {
            //             required: "Bạn chưa nhập mật khẩu",
            //         },

            //         npwd: {
            //             required: "Bạn chưa nhập mật khẩu",
            //             minlength: "Mật khẩu phải có ít nhất 8 ký tự!",
            //         },
            //         re_npwd: {
            //             required: "Bạn chưa nhập mật khẩu",
            //             minlength: "Mật khẩu phải có ít nhất 8 ký tự!",
            //             equalTo: "Mật khẩu không trùng khớp với mật khẩu vừa nhập!"
            //         },

            //     },
            //     errorElement: "div",
            //     errorPlacement: function(error, element) {
            //         error.addClass("invalid-feedback");
            //         if (element.prop("name") === "rdGioiTinh") {
            //             error.insertAfter(element.parent("div").siblings("label.gioitinh"));
            //         } else {
            //             error.insertAfter(element);
            //         }
            //     },
            //     highlight: function(element, errorClass, validClass) {
            //         $(element).addClass("is-invalid").removeClass("is-valid");
                    
            //     },
            //     unhighlight: function(element, errorClass, validClass) {
            //         $(element).addClass("is-valid").removeClass("is-invalid");
                    
            //     }
            // });
            // $('form').on("change", function() {
            //     $('input').each(function() {
            //         if ($(this).hasClass("is-invalid") || t1 == 1 || t2 == 1 || t3 == 1) {
            //             $("#btnDangKy").attr("disabled", "disabled")
            //             return false;
            //         }
            //         $("#btnDangKy").removeAttr("disabled")
            //     })
            // })
        });
    </script>
@endsection