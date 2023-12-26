@extends('layouts.ManagerApp')

@section('title', 'Thêm thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('manager.member')}}">Nhân viên</a></li>
        <li class="breadcrumb-item" aria-current="page">Thêm nhân viên</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý nhân viên</li>

@endsection

{{-- @section('main-content')
<div class="separator"></div>
<div class="card w-50 m-auto shadow">
    <div class="card-body">
        <form action="{{route('manager.member.store')}}" method="post" id="frmQLVC">
            @csrf
            <div class="form-group">
                <label for="full_name">Tên nhân viên </label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="{{old('full_name')}}">
                @error('full_name')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="employee_id">Mã nhân viên </label>
                <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{old('employee_id')}}">
                @error('employee_id')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="identify_card">CMND/CCCD </label>
                <input type="text" name="identify_card" id="identify_card" class="form-control" value="{{old('identify_card')}}">
                @error('identify_card')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại </label>
                <input type="tel" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
                @error('phone')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                @error('email')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Ngày sinh </label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{old('date_of_birth')}}">
                @error('date_of_birth')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
                <div class="form-group">
                    <legend class="col-form-label">Giới tính </legend>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="gender" id="gender1" value="1" class="form-check-input"  {{old('gender') == 1 ? "selected" : ''}}>
                        <label for="gender1" class="form-check-label">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="gender" id="gender2" value="0" class="form-check-input"  {{old('gender') == 0 ? "selected" : ''}}>
                        <label for="gender2" class="form-check-label">Nữ </label>
                    </div>
                    @error('gender')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Tỉnh/ Thành phố</label>
                    <select name="province" id="province" class="custom-select">
                        <option value="{{old('province')}}">{{old('province') ? old('province') : ''}}</option>
                    </select>
                    @error('province')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Quận/ Huyện</label>
                    <select name="district" id="district" class="custom-select">
                        <option value="{{old('district')}}">{{old('district') ? old('district') : ''}}</option>
                    </select>
                    @error('district')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Phường/ Xã</label>
                    <select name="village" id="village" class="custom-select">
                        <option value="{{old('village')}}">{{old('village') ? old('village') : ''}}</option>
                    </select>
                    @error('village')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="address">Địa chỉ </label>
                    <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
                    @error('address')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>

                
                
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('manager.member')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Thêm</button>
        </form>
    </div>
</div>
@endsection --}}
@section('main-content')

<div class="separator"></div>
<div class="card w-50 m-auto shadow">
    <div class="card-body">
        <form action="{{route('manager.member.store')}}" method="post" id="frmQLVC">
            @csrf
            <div class="form-group">
                <label for="full_name">Tên nhân viên </label>
                <input type="text" name="full_name" id="full_name" class="form-control" value="{{old('full_name')}}">
                @error('full_name')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="employee_id">Mã nhân viên </label>
                <input type="text" name="employee_id" id="employee_id" class="form-control" value="{{old('employee_id')}}">
                @error('employee_id')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="identify_card">CMND/CCCD </label>
                <input type="text" name="identify_card" id="identify_card" class="form-control" value="{{old('identify_card')}}">
                @error('identify_card')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại </label>
                <input type="tel" name="phone" id="phone" class="form-control" value="{{old('phone')}}">
                @error('phone')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email </label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                @error('email')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Ngày sinh </label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="{{old('date_of_birth')}}">
                @error('date_of_birth')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
                <div class="form-group">
                    <legend class="col-form-label">Giới tính </legend>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="gender" id="gender1" value="1" class="form-check-input" {{old('gender') == 1 ? "checked" : ''}}>
                        <label for="gender1" class="form-check-label">Nam</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="gender" id="gender2" value="0" class="form-check-input" {{old('gender') == 0 ? "checked" : ''}}>
                        <label for="gender2" class="form-check-label">Nữ </label>
                    </div>
                    @error('gender')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Tỉnh/ Thành phố</label>
                    <select name="province" id="province" class="custom-select">
                        <option value="{{old('province')}}">{{old('province') ? old('province') : ''}}</option>
                    </select>
                    @error('province')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Quận/ Huyện</label>
                    <select name="district" id="district" class="custom-select">
                        <option value="{{old('district')}}">{{old('district') ? old('district') : ''}}</option>
                    </select>
                    @error('district')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Phường/ Xã</label>
                    <select name="village" id="village" class="custom-select">
                        <option value="{{old('village')}}">{{old('village') ? old('village') : ''}}</option>
                    </select>
                    @error('village')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
    
                <div class="form-group">
                    <label for="address">Địa chỉ </label>
                    <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}">
                    @error('address')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>

                
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('manager.member')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Thêm</button>
        </form>
    </div>
</div>
@endsection

@section('ex-script')
<script>
    $(document).ready(function () {
        console.log("yes")
        const tp = $('#province')
        const qh = $('#district')
        const px = $('#village')

        $.getJSON(`https://provinces.open-api.vn/api/?depth=3`, function (data) {
        console.log(data);
        console.log("yes")
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
@endsection