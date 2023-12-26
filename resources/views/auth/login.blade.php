<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> --}}
    <title>Trang chủ</title>
    <style>
        body{
            font-family: roboto;
        }
        .card-log-in {
            width: 500px;
            border-radius: 10px;
            box-shadow: 1px 2px 10px grey;
            
        }
        .card-log-in h3{
            color: #616AC6;
        }
        .card-log-in label{
            font-weight: bolder;
        }
        span.required-fill-in{
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="container-fluid">
    @if (Auth::check())
    <div class="row p-5">
        <div class="p-3 card-log-in m-auto">
            {{ __("Tài khoản đã được đăng nhập được đăng nhập")}}
            @php
            $user = Auth::user();
            @endphp
            @if ($user->hasRole('manager'))
                <a href="{{route('managerDashboard')}}">Đi đến trang quản lý</a>
            @elseif ($user->hasRole('employee'))
                <a href="{{route('employeeDashboard')}}">Đi đến trang quản lý</a>
            @endif
        </div>
        </div>
    @else

        <div class="row p-5">
        <div class="p-3 card-log-in m-auto">
            <div class="col-12">
                <h3 class="text-center font-weight-bolder text-black-25">ĐĂNG NHẬP</h3>
                
            </div>
            <div>
                <span class="text-danger"></span>
            </div>
            <form method="POST" id="frmDangNhap" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                        </div>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                            placeholder="Nhập vào email...." value="{{ old('email') }}" >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>


                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                        </div>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Nhập vào mật khẩu...." value="">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill w-100" name="btnDangNhap">Đăng nhập</button>
                <hr>
                <div class="form-group align-content-center">
                    @if (Route::has('password.request'))
                        <a class="btn btn-link " href="{{ route('password.request') }}">
                            {{ __('Quên mật khẩu?') }}
                        </a>
                    @endif
                    <div class="btn float-right">Liên hệ:
                        <a href="tel:0932988029">0932 988 029</a>
                    </div>
                </div>
                
            </form>
            {{-- <br> --}}
            {{-- <p class="text-center">Bạn chưa có tài khoản? Hãy đăng ký ngay</p> --}}
            {{-- <a class="btn btn-light text-dark-10 w-100 rounded-pill" href="{{ route('register') }}">Đăng ký</a> --}}
        </div>
        </div>
        
    @endif
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        $('#frmDangNhap').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password:  { required: true},
                
            },
            messages: {
                email: {
                    required: "Bạn chưa nhập vào email",
                    email: "Địa chỉ email không hợp lệ"
                  
                },
                password: {
                    required: "Bạn chưa nhập mật khẩu", 
                },
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback");
                if (element.prop("type") === "radio") {
                    error.insertAfter(element.siblings("label"));
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
    });
</script>


</body>

</html>