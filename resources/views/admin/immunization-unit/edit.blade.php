@extends('layouts.AdminApp')

@section('title', 'Thêm cơ sở')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('admin.immunizationUnit')}}">Cơ sở tiêm chủng</a></li>
        <li class="breadcrumb-item" aria-current="page">cập nhật cơ sở</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý cơ sở</li>

@endsection

@section('main-content')
{{-- <h2 class="text-center"> Sửa cơ sở</h2> --}}
{{-- <p class="lead ml-2"> Đây là trang quản lý vắc xin.</p> --}}
{{-- <button class="btn btn-primary mb-0 ml-2">Thêm loại vắc xin</button> --}}
<div class="separator"></div>
<div class="card w-50 m-auto shadow">
    <div class="card-body">
        
        <form action="{{route('admin.immunizationUnit.update', $immunizationUnit)}}" method="post" id="frmQLVC">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Tên cơ sở: </label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name', $immunizationUnit->name)}}">
                @error('name')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="operating_license" class="form-label">Mã giấy phép hoạt động: </label>
                <input type="text" name="operating_license" id="operating_license" class="form-control" value="{{old('operating_license', $immunizationUnit->operating_license)}}">
                @error('operating_license')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="hotline" class="form-label">Hotline: </label>
                <input type="text" name="hotline" id="hotline" class="form-control" value="{{old('hotline', $immunizationUnit->hotline)}}">
                @error('hotline')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Tỉnh/ Thành phố</label>
                <select name="province" id="province" class="custom-select">
                    {{-- {{old('province') ? '<option value="{Ơold(\'province\')">--Chọn--</option>' : ""}} --}}
                    <option value="{{old('province', $addressOfIU[3])}}">{{old('province', $addressOfIU[3]) ? old('province', $addressOfIU[3]) : ''}}</option>
                    {{-- <option value="">--Chọn--</option> --}}
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
                    {{-- <option value="">--Chọn--</option> --}}
                    <option value="{{old('district', $addressOfIU[2])}}">{{old('district', $addressOfIU[2]) ? old('district', $addressOfIU[2]) : ''}}</option>
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
                    {{-- <option value="">--Chọn--</option> --}}
                    <option value="{{old('village', $addressOfIU[1])}}">{{old('village', $addressOfIU[1]) ? old('village', $addressOfIU[1]) : ""}}</option>

                </select>
                @error('village')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="address">Địa chỉ </label>
                <input type="text" name="address" id="address" class="form-control" value="{{old('address', $addressOfIU[0])}}">
                @error('address')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Trạng thái hoạt động</label>
                <select name="status" id="status" class="custom-select">
                    <option value="0" {{old('status', $immunizationUnit->status) == 0 ? "selected" : ""}}>Không hoạt động</option>
                    <option value="1" {{old('status', $immunizationUnit->status) == 1 ? "selected" : ""}}>Hoạt động</option>
                </select>
              
            </div>
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('admin.immunizationUnit')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Cập nhật</button>
        </form>
    </div>
</div>
@endsection

@section('ex-script')
    {{-- <script src="{{asset('admin/js/area.js')}}"></script> --}}
    <script>
        $(document).ready(function () {
            const tp = $('#province')
            const qh = $('#district')
            const px = $('#village')

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
    </script>
@endsection