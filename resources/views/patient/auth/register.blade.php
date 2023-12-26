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
    <link rel="stylesheet" href="{{asset('user/vendor/fontawesome/css/all.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css"> --}}
    <title>Trang chủ</title>
    <style>
        body {
            font-family: roboto;

        }

        label {
            font-weight: bold;
        }

        .card-log-in {

            width: 1000px;
            border-radius: 10px;
            box-shadow: 2px 2px 10px grey;
            background-color: white;

        }

        .card-log-in h3 {
            color: #616AC6;


        }

        .error-block {
            color: red;
            /* font-weight: lighter; */
            
        }

        .error-block::first-letter {
            text-transform: capitalize;
            
        }
        

        span.required-fill-in {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body class="container-fluid " style="position: relative;">
    <div class="container mt-2">
        <div class="p-3 m-auto card-log-in">
            <div class="col-12">
                <h3 class="text-center font-weight-bolder ">ĐĂNG KÝ</h3>
            </div>
            <form action="{{route('patient.register')}}" method="POST" id="signupForm">
                @csrf
                <div class="row">

                    <div class="col-12 col-sm-6">

                        {{-- <div class="form-group">
                            <label for="name">Tên đăng nhập <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nhập vào họ tên...." value="{{old('name')}}">
                            </div>
                            @error('name')
                                <div class="error-block mt-1">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div> --}}
                        <div class="form-group">
                            <label for="full_name">Họ và tên <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                                
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name" name="full_name" placeholder="Nhập vào họ tên...." value="{{old('full_name')}}">

                            </div>
                            @error('full_name')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                                
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Nhập vào số điện thoại...." value="{{old('phone')}}" maxlength="10">

                            </div>
                            @error('phone')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Ngày sinh <span class="required-fill-in">*</span></label>
                            <input type="date" name="date_of_birth" id="date_of_birth" placeholder="" class="form-control @error('date_of_birth') is-invalid @enderror" value="{{old('date_of_birth')}}">
                            @error('date_of_birth')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <label class="col-form-label gioitinh">Giới tính <span class="required-fill-in">*</span></label>
                        <br>
                        
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" value="1" class="form-check-input" {{old('gender') == 1 ? 'checked' : '' }}>
                            <label for="gender1" class="form-check-label">Nam</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" name="gender" value="0" class="form-check-input" {{old('gender') == 0 ? 'checked' : '' }}>
                            <label for="gender2" class="form-check-label">Nữ </label>
                        </div>
                        @error('gender')
                        <div class="error-block mt-1">
                            <strong>Chưa chọn giới tính!</strong>
                        </div>
                        @enderror

                        <div class="form-group ">
                            <label for="identify_card">CMND/CCCD/BHYT <span class="required-fill-in">*</span></label>
                            <input type="text" name="identify_card" id="identify_card" placeholder="Nhập vào Căn cước công dân..." class="form-control @error('identify_card') is-invalid @enderror" value="{{old('identify_card')}}" maxlength="15">
                            @error('identify_card')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                                
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    placeholder="Nhập vào email...." value="{{ old('email') }}" >
        
                                    
                            </div>
                            @error('email')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
        
                        </div>
                        <div class="form-group">
                            <label for="career">Nghề nghiệp <span class="required-fill-in "></span></label>
                            <div class="input-group">
                                
                                <input type="text" class="form-control" id="career" name="career" placeholder="Nhập vào họ tên...." value="{{ old('career') }}">

                            </div>

                        </div>
                        

                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="">Tỉnh/ Thành phố <span class="required-fill-in">*</span></label>
                            <select name="txtTP" id="txtTP" class="custom-select @error('txtTP') is-invalid @enderror" >
                                <option value="{{old('txtTP')}}">{{old('txtTP') ? old('txtTP') : "-- Chọn --"}}</option>
                            </select>
                            @error('txtTP')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Quận/ Huyện <span class="required-fill-in">*</span></label>
                            <select name="txtQH" id="txtQH" class="custom-select @error('txtQH') is-invalid @enderror" >
                                <option value="{{old('txtQH')}}">{{old('txtQH') ? old('txtQH') : "-- Chọn --"}}</option>
                            </select>
                            @error('txtQH')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Phường/ Xã <span class="required-fill-in">*</span></label>
                            <select name="txtPX" id="txtPX" class="custom-select @error('txtPX') is-invalid @enderror" >
                                <option value="{{old('txtPX')}}">{{old('txtPX') ? old('txtPX') : "-- Chọn --"}}</option>
                            </select>
                            @error('txtPX')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="txtDiaChi">Địa chỉ <span class="required-fill-in">*</span></label>
                            <input type="text" name="txtDiaChi" id="txtDiaChi" placeholder="Nhập vào địa chỉ..." class="form-control @error('txtDiaChi') is-invalid @enderror" value="{{ old('txtDiaChi') }}">
                            @error('txtDiaChi')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>



                        <div class="form-group ">
                            <label for="password">Mật khẩu <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                                
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Nhập vào mật khẩu...." >
                            </div>
                            @error('password')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        <div class="form-group ">
                            <label for="password_confirm">Nhập lại mật khẩu <span class="required-fill-in">*</span></label>
                            <div class="input-group">
                               
                                <input type="password" class="form-control @error('password_confirm') is-invalid @enderror" id="password_confirm" name="password_confirm" placeholder="Nhập vào mật khẩu....">
                            </div>
                            @error('password_confirm')
                            <div class="error-block mt-1">
                                <strong>{{$message}}</strong>
                            </div>
                            @enderror
                        </div>
                        
                        
                        {{-- <div class="form-group ">
                            <label for="nbSoLanTiem">Số lần tiêm </label>
                            <div class="input-group">
                                
                                <input type="number" class="form-control" id="nbSoLanTiem" name="nbSoLanTiem" value="0" min="0">
                            </div>

                        </div>
                  
                        <div class="form-group ">
                            <label for="dtNgayTiemGanNhat">Ngày tiêm gần nhất </label>
                            <input type="date" name="dtNgayTiemGanNhat" id="dtNgayTiemGanNhat" placeholder="" class="form-control" readonly>

                        </div>
                        <label for="">Tên vắc xin tiêm gần nhất </label>
                        <select class="custom-select" name="slvaccineTiemGanNhat" disabled>
                            <option value="" selected>-- Chọn vacxin --</option>
                            <option value="0">Không rõ vaccine</option>

                            <?php foreach ($arrVac as $v) : ?>
                                <option value="<?= $v->layID() ?>"><?= $v->ten ?></option>
                            <?php endforeach; ?>
                        </select> --}}

                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        {{-- <a class="btn btn-light rounded-circle border border-primary text-primary " href="index.php"><i class="fa-solid fa-arrow-left"></i></a> --}}
                        <a class="btn   " href="{{url('/')}}"><< Trở về</a>

                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 mt-2 " name="btnDangKy" id="btnDangKy" >Đăng ký</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('user/vendor/jquery/jquery-3.6.1.min.js')}}"></script>

    <script src="{{url('/public/user/js/area.js')}}"></script>
    {{-- <script>
        $(document).ready(function () {
            const tp = $('#txtTinh')
            const qh = $('#txtQuan')
            const px = $('#txtPhuong')
    
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
    </script> --}}
</body>

</html>