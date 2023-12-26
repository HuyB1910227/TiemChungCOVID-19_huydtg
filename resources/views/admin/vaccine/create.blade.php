@extends('layouts.AdminApp')

@section('title', 'Thêm vắc xin')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('admin.vaccine')}}">Vắc xin</a></li>
        <li class="breadcrumb-item" aria-current="page">Thêm vắc xin</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý vắc xin</li>

    @endsection

@section('main-content')
{{-- <h2 class="text-center"> Thêm vắc xin</h2> --}}
{{-- <p class="lead ml-2"> Đây là trang quản lý vắc xin.</p> --}}
{{-- <button class="btn btn-primary mb-0 ml-2">Thêm loại vắc xin</button> --}}
<div class="separator"></div>
<div class="card w-75 m-auto shadow">
    <div class="card-body">
        <form action="{{route('admin.vaccine.store')}}" method="post" id="frmQLVC">
            @csrf
            <div class="form-group">
                <label for="name">Tên vắc xin </label>
                <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                @error('name')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="basic_dose">Số mũi tiêm cơ bản</label>
                <input type="number" name="basic_dose" id="basic_dose" class="form-control" value="{{old('basic_dose')}}">
                @error('basic_dose')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="basic_injections_interval">Khoảng cách mũi cơ bản (đvt: ngày)</label>
                <input type="number" name="basic_injections_interval" id="basic_injections_interval" class="form-control" value="{{old('basic_injections_interval')}}">
                @error('basic_injections_interval')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="additional_dose">Số mũi tiêm bổ sung</label>
                <input type="number" name="additional_dose" id="additional_dose" class="form-control" value="{{old('additional_dose')}}">
                @error('additional_dose')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="additional_injections_interval">Khoảng cách mũi bổ sung (đvt: ngày)</label>
                <input type="number" name="additional_injections_interval" id="additional_injections_interval" class="form-control" value="{{old('additional_injections_interval')}}">
                @error('additional_injections_interval')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <label for="type_id">Loại vắc xin:</label>
                <div class="form-group">
                    <select name="type_id" id="type_id" class="custom-select">
                        <option value="">--Chọn--</option>
                        @foreach ($types as $type)
                            <option value="{{$type->id}}" {{old('type_id') == $type->id ? "selected" : ""}}>{{$type->name}}</option>
                            
                        @endforeach
                    </select>
                    @error('type_id')
                    <div class="error-block mt-1">
                        <strong>{{$message}}</strong>
                    </div>
                    @enderror
                </div>
            {{-- chọn vắc xin --}}
            <div class="form-group">
                <label for="">Chọn vắc xin thay thế phù hợp cho tiêm nhắc lại</label>
                <table class="table">
                    <tr>
                        <th>Chọn</th>
                        <th>Mã vắc xin</th>
                        <th>Tên vắc xin</th>
                    </tr>
                    @foreach ($vaccines as $vaccine)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_vaccine_id[]" value="{{$vaccine->id}}" >
                        </td>
                        <td>
                            {{$vaccine->id}}
                        </td>
                        <td>
                            {{$vaccine->name}}
                        </td>
                    </tr>
                    @endforeach
                    
                </table>
            </div>
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('admin.vaccine')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Thêm</button>
        </form>
    </div>
</div>
@endsection