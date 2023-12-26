@extends('layouts.AdminApp')

@section('title', 'Thêm vắc xin')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('admin.type')}}">Loại vắc xin</a></li>
        <li class="breadcrumb-item" aria-current="page">Sửa loại vắc xin</li>

        <li class="text-uppercase ml-auto font-weight-bold">Quản lý loại vắc xin</li>
@endsection

@section('main-content')
{{-- <h2 class="text-center"> Sửa loại vắc xin</h2> --}}
{{-- <div class="separator"></div> --}}
<div class="card w-50 m-auto">
    <div class="card-body">
        <form action="{{route('admin.type.update', $type->id)}}" method="post" id="frmQLVC">
            @csrf
            <div class="form-group">
                <label for="txtTenLoaiVaccine">Tên loại </label>
                <input type="text" name="txtTenLoaiVaccine" id="txtTenLoaiVaccine" class="form-control" value="{{old('txtTenLoaiVaccine', $type->name) }}">
                {{-- <p>{{old('txtTenLoaiVaccine')}}</p> --}}
                @error('txtTenLoaiVaccine')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="txtMoTa">Mô tả </label>
                <textarea type="text" name="txtMoTa" id="txtMoTa" class="form-control">{{old('txtMoTa', $type->description)}}</textarea>
                @error('txtMoTa')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('admin.type')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Cập nhật</button>
        </form>
    </div>
</div>
@endsection