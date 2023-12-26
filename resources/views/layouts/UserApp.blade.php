<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendor/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/user/css/style_main.css">
    <link rel="stylesheet" href="../css/user/css/style_navbar.css">
    <link rel="stylesheet" href="../css/user/css/style_calendar.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> --}}
    

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" href="{{asset('user/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/style_calendar.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/style_main.css')}}">
    <link rel="stylesheet" href="{{asset('user/css/style_navbar.css')}}">
    <link rel="stylesheet" href="{{asset('user/vendor/fontawesome/css/all.css')}}">
    @yield('ex-css')
    <title>@yield('title')</title>
</head>

<body class="container-fluid">
    
    <header class="fixed-top">
        @if (auth('patient')->user())
        <div class="container-lg ">
            <nav class="navbar navbar-expand-md navbar-light row">
                <a class="navbar-brand" href="{{url('/')}}">V-Tiêm chủng</a>
                <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse sha" id="navbarNavDropdown">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('trang-chu')}}">Trang chủ<span
                                    class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown ">
                            <a class="nav-link" href="{{route('schedule')}}" >
                                Đăng ký tiêm
                            </a>
                            {{-- <div class="dropdown-menu shadow-lg">
                                <a class="dropdown-item" href="/V_TiemChung/user/pages/dangkytiemchung.php">Đăng ký tiêm
                                    cho cá nhân</a>
                                <a class="dropdown-item" href="/V_TiemChung/user/pages/dangkytiemchungnt.php">Đăng ký
                                    tiêm cho người thân</a>
                            </div> --}}
                        </li>

                        <li class="nav-item dropdown ">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                Quản lý
                            </a>
                            <div class="dropdown-menu shadow-lg">
                                <a class="dropdown-item" href="{{url('thong-tin-ca-nhan')}}">Thông tin cá
                                    nhân</a>
                                <a class="dropdown-item" href="{{url('chung-nhan-tiem')}}">Chứng
                                    nhận tiêm</a>
                                <a class="dropdown-item" href="{{url('lich-su-tiem-chung')}}">Lịch sử tiêm
                                    chủng</a>
                                <a class="dropdown-item" href="{{url('lich-su-dang-ky')}}">Đăng ký
                                    tiêm</a>
                                
                            </div>
                        </li>
                        <li class="nav-item dropdown ">
                            <div class="nav-link dropdown-toggle border " href="#" role="button" data-toggle="dropdown"
                                aria-expanded="false">
                                <span class="nav-log "><img src="{{asset(auth('patient')->user()->avatar)}}" alt="" class="rounded-circle"
                                        style="width:30px; height:30px"> &nbsp; {{auth('patient')->user()->full_name}}</span> |
                            </div>
                            <div class="dropdown-menu shadow-lg">
                                <a href="{{route('patient.logout')}}" class="dropdown-item "><i
                                        class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
                                <a href="{{url('tai-khoan')}}" class="dropdown-item "><i
                                        class="fa-solid fa-gear"></i> Sửa tài khoản</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        @else
        <div class="container-lg">
            <nav class="navbar navbar-expand-md navbar-light  row">
                <a class="navbar-brand" href="#">tiemchungcovid-19</a>
                <a class="btn rounded-pill ml-auto phone" href="tel:0932988029"><i class="fa-solid fa-phone"></i>
                    0932-988-029
                </a>
            </nav>
        </div>
        @endif
    </header>

    <main class="row">
        @yield('main-content')

    </main>
    <footer class="row text-white ">
        <div class="container-lg">
            <div class="row justify-content-center my-3">
                <div class="col-12 col-md-3">
                    <img src="{{asset('qr/img/qrcode.png')}}" alt="" width="200px" id="QRcode">
                </div>
                <div class="col-12 col-md-9">
                    <h4>Liên hệ với chúng tôi</h4>
                    <div class="row">
                        <div class="col-12 col-sm-6">

                            <h6 class="text-white my-3"><i class="fa-solid fa-phone fa"></i> &nbsp; + 0932-988-029</h6>
                            <h6 class="text-white my-3"><i class="fa-solid fa-envelope fa"></i> &nbsp;
                                huyb1910227@student.ctu.edu.vn</h6>
                        </div>
                        <div class="col-12 col-sm-6">
                            <h6 class="text-white my-3"><i class="fa-solid fa-globe fa"></i> &nbsp; www.tiemchungcovid-19.vn
                            </h6>
                            <h6 class="text-white my-3"><i class="fa-solid fa-location-dot fa"></i>&nbsp; 221/12, p.Long
                                Hòa, q.Bình Thủy, tp.Cần Thơ</h6>
                        </div>
                        <div class="col-12">
                            <i class="fa-brands fa-youtube fa-footer "></i>
                            <i class="fa-brands fa-square-facebook fa-footer "></i>
                            <i class="fa-brands fa-facebook-messenger fa-footer"></i>
                            <i class="fa-brands fa-twitter fa-footer "></i>
                            <i class="fa-brands fa-instagram fa-footer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    {{-- <script src="{{asset('user/vendor/jquery/jquery-3.6.1.min.js')}}"></script> --}}
    {{-- <script src="../vendor/bootstrap/js/bootstrap.min.js"></script> --}}
    <script src="{{asset('admin/vendor/jquery/jquery-3.6.1.min.js')}}"></script>
    <script src="{{asset('user/vendor/plugin_validate/jquery.validate.js')}}"></script>
    
    <script src="{{asset('user/vendor/bootstrap/js/bootstrap.js')}}"></script>
    @yield('ex-script')
</body>

</html>