<!DOCTYPE html>
<html>

<head>
  <title>@yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
  <link rel="stylesheet" href="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.min.css') }}">


  <link rel="stylesheet" href="{{asset('admin/css/style.css')}}">
  @yield('ex-css')
</head>

<body>

  <!-- Vertical navbar -->
  <div class="vertical-nav bg-white" id="sidebar" style="overflow-y: auto">
    {{-- <div class="py-4 px-3 mb-4 bg-light">
      <div class="media d-flex align-items-center">
        <img loading="lazy" src="{{asset('admin/js/script.js')}}" alt="..." width="80" height="80"
          class="mr-3 rounded-circle img-thumbnail shadow-sm">
        <div class="media-body">
          <h4 class="m-0">Carlet</h4>
          <p class="font-weight-normal text-muted mb-0">Employee</p>
        </div>
      </div>
    </div> --}}
    <div class="dropdown">
      <a class="btn float-right mt-1 mr-1" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-gears text-primary-fa fa-fw" style="font-size: 20px"></i>
      </a>
      <div class="dropdown-menu">
        {{-- <a class="dropdown-item" href="#">Sửa thông tin cá nhân</a> --}}
        <a class="dropdown-item" href="{{route('employee.password')}}">Đổi mật khẩu</a>
        {{-- <a class="dropdown-item" href="#">Something else here</a> --}}
      </div>
    </div>
    
    <div class="py-4 px-3 mb-4 bg-title">
      {{-- <div class="badge" style="">Sửa</div> --}}
      <div class="media d-flex align-items-center">
        <img src="{{asset(Auth::user()->employee->avatar)}}" alt="..." width="80" height="80"
          class="mr-3 rounded-circle shadow-sm">
        <div class="media-body">
          <h5 class="m-0">{{ Auth::user()->employee->full_name }}</h5>
          <p class="font-weight-normal text-muted mb-0">Nhân viên</p>
        </div>
      </div>
      
    </div>
    <p class="text-gray font-weight-bold text-uppercase px-3 small pb-1 mb-0">Lịch công tác</p>
    <ul class="nav flex-column bg-white mb-0">
      <li class="nav-item {{Request::is('nhan-vien/lich-cong-tac*') || Request::is('nhan-vien/lich-lam-viec*') ? 'active' : '' }}">
        <a href="{{route('employee.timetable')}}" class="nav-link">
          <i class="fa-regular fa-calendar-days mr-3 text-primary-fa fa-fw"></i>
          Kế hoạch tiêm
        </a>
      
      </li>
    </ul>
    <p class="text-gray font-weight-bold text-uppercase px-3 small pb-1 mb-0">Công tác tiêm chủng</p>
    <ul class="nav flex-column bg-white mb-0">
      <li class="nav-item {{Request::is('nhan-vien/phieu-dang-ky*') ? 'active' : '' }}">
        <a href="{{route('employee.vaccination.registration')}}" class="nav-link">
          <i class="fa-solid fa-file-pen mr-3 text-primary-fa fa-fw"></i>
          Đăng ký tiêm chủng
        </a>
      </li>
      <li class="nav-item {{Request::is('nhan-vien/xu-ly-tiem-chung*') ? 'active' : '' }}">
        <a href="{{route('employee.vaccination.execution')}}" class="nav-link">
          <i class="fa-solid fa-syringe mr-3 text-primary-fa fa-fw"></i>
          Xử lý tiêm chủng
        </a>
      </li>
      <li class="nav-item {{Request::is('nhan-vien/lich-su-tiem*') ? 'active' : '' }}">
        <a href="{{route('employee.vaccination.history')}}" class="nav-link">
          <i class="fa-solid fa-clock-rotate-left mr-3 text-primary-fa fa-fw"></i>
          Lịch sử tiêm chủng
        </a>
      </li>
    </ul>
    
  </div>
  <!-- End vertical navbar -->


  <!-- Page content holder -->
  <div class="page-content" id="content">
    <!-- Toggle button -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white">
      <button id="sidebarCollapse" type="button" class="btn btn-light"><i class="fa fa-bars m-2"></i></button>

      <a class="navbar-brand" href="#">tiemchungcovid-19</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse sha" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <form action="{{route('employee.profile', Auth::user()->id)}}" method="get">
              {{-- @csrf --}}
              <button class="btn btn-primary m-1 text-white" > <i class="fa-solid fa-id-card-clip"></i> Xem hồ sơ</button>
            </form>
            
            
          </li>
          <li class="nav-item">
            <a class="btn btn-primary m-1 text-white" href="{{url('nhan-vien/logout')}}"> <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
            
          </li>
        </ul>
            
      </div>

      {{-- <div class="collapse navbar-collapse ml-auto" id="navbarSupportedContent" >
        <a class="ml-auto btn btn-primary" href="{{url('nhan-vien/logout')}}">Đăng xuất</a>
        <a class="btn btn-primary " href="{{url('nhan-vien/logout')}}"> <i class="fa-solid fa-id-card-clip"></i> Hồ sơ cá nhân</a>
        <a class="btn btn-primary" href="{{url('nhan-vien/logout')}}"> <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
      </div> --}}

      {{-- <div class="ml-auto">
        <a class="btn btn-primary " href="{{url('nhan-vien/logout')}}"> <i class="fa-solid fa-id-card-clip"></i> Hồ sơ cá nhân</a>
        <a class="btn btn-primary" href="{{url('nhan-vien/logout')}}"> <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
        
      </div> --}}
    </nav>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
          @yield('breadcrumb')
          
          
      </ol>
    </nav>

    <!-- Demo content -->
    <div>
      <div class="loading" style="display:none" id="loading-indicator">
        <div class="loading-icon"></div>
      </div>
        @yield('main-content')
    </div>
    
    

  </div>
  <!-- End demo content -->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
    
    <script src="{{asset('admin/vendor/jquery/jquery-3.6.1.min.js')}}"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
    <script src="{{asset('user/vendor/plugin_validate/jquery.validate.js')}}"></script>
    <script src="{{asset('admin/js/script.js')}}"></script>
    <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    {{-- <script src="{{asset('user/vendor/plugin_validate/jquery.validate.js')}}"></script> --}}
    @yield('ex-script')
    <script>
      $(document).ready(function() {
        $('button.load').on('click', function() {
          $('#loading-indicator').show();
        });
        $('button.swal2-confirm').on('click', function() {
          console.log("yes");
          $('#loading-indicator').show();
        });
      });
    </script>
    
    
</body>

</html>