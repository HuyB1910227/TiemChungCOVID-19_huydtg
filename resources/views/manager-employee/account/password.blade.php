@if (Auth::user()->hasRole('administrator'))
    
    @php
        $app = "layouts.AdminApp";
        // $breadcrumb = 'admin.profile';
        $routeUpdatePassword = "admin.password.update";
        // $routeUpdate = "admin.profile.update";
        
    @endphp
    

@elseif (Auth::user()->hasRole('manager'))
    @php
        $app = "layouts.ManagerApp";
        // $breadcrumb = 'manager.profile';
        $routeUpdatePassword = "manager.password.update";
        // $routeUpdate = "manager.profile.update";

    @endphp
@elseif (Auth::user()->hasRole('employee'))
    @php
        $app = "layouts.EmployeeApp";
        // $breadcrumb = 'employee.profile';
        $routeUpdatePassword = "employee.password.update";
        // $routeUpdate = "employee.profile.update";

    @endphp
@endif

@extends($app)
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="">Đổi mật khẩu</a></li>
    <li class="text-uppercase ml-auto font-weight-bold">Quản lý hồ sơ tài khoản</li>
    
@endsection

@section('main-content')
<div class="container-lg ">
    {{-- @php
        if(old('password'))
            echo "yes";
        else echo "no";
    @endphp --}}
    
    {{-- <h3 class="titile mb-2">Đổi mật khẩu</h3> --}}
    <form action="{{route($routeUpdatePassword)}}" method="POST" id="signupForm" style="width: 400px; margin: auto" class="card p-3">
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
                <div class="form-group ">
                    <label for="password">Mật khẩu cũ <span class="required-fill-in">*</span></label>
                    <div class="input-group">

                        <input type="password" class="form-control" id="password" name="password"
                             value="{{old('password')}}">
                            {{-- <div>{{old('password')}}</div> --}}
                    </div>
                    
                    @error('password')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="npwd">Mật khẩu mới <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="npwd" name="npwd"
                            placeholder="Nhập vào mật khẩu...." value="{{old('npwd')}}">
                    </div>
                    @error('npwd')
                        <div class="error-block mt-1">
                            <strong>{{$message}}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group ">
                    <label for="npwd">Nhập lại mật khẩu <span class="required-fill-in">*</span></label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="re_npwd" name="re_npwd"
                            placeholder="Nhập vào mật khẩu...." value="{{old('re_npwd')}}">
                    </div>
                    @error('re_npwd')
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
                    id="btnDangKy" >Cập nhật</button>
            </div>
        </div>
    </form>
</div>
@endsection