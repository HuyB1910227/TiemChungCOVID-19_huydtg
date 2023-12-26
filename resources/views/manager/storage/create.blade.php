@extends('layouts.ManagerApp')

@section('title', 'Thêm thành viên')
@section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{route('manager.lot')}}">Lô vắc xin</a></li>
        <li class="breadcrumb-item" aria-current="page">Thêm lô vắc xin</li>
        <li class="text-uppercase ml-auto font-weight-bold">Quản lý lô vắc xin</li>

@endsection

@section('main-content')
{{-- <h2 class="text-center text-uppercase"> thêm lô vắc xin</h2> --}}

<div class="separator"></div>
<div class="card w-50 m-auto ">
    <div class="card-body shadow">
        <form action="{{route('manager.lot.store')}}" method="post" id="">
            @csrf
            <div class="form-group">
                <label for="lot_code">Mã lô vắc xin</label>
                <input type="text" name="lot_code" id="lot_code" class="form-control" value="{{old('lot_code')}}">
                @error('lot_code')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="vaccine">Vắc xin</label>
                <select name="vaccine" id="vaccine" class="custom-select">
                    <option value="">--Chọn--</option>
                    @foreach ($vaccines as $vaccine)
                        <option value="{{$vaccine->id}}" {{old('vaccine') == $vaccine->id ? "selected" : ""}}>{{$vaccine->name}}</option>
                    @endforeach
                </select>
                @error('vaccine')
                <div class="error-block mt-1">
                    <strong>Chưa chọn vắc xin!</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="manufacturing_date">Ngày sản xuất </label>
                <input type="date" name="manufacturing_date" id="manufacturing_date" class="form-control" value="{{old('manufacturing_date')}}">
                @error('manufacturing_date')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="expired_date">Ngày hết hạn</label>
                <input type="date" name="expired_date" id="expired_date" class="form-control" value="{{old('expired_date')}}">
                @error('expired_date')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="transaction_date">Ngày nhập kho </label>
                <input type="date" name="transaction_date" id="transaction_date" class="form-control" value="{{old('transaction_date')}}">
                @error('transaction_date')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Số lượng</label>
                <input type="text" name="quantity" id="quantity" class="form-control" value="{{old('quantity')}}">
                @error('quantity')
                <div class="error-block mt-1">
                    <strong>{{$message}}</strong>
                </div>
                @enderror
            </div>
            
            <a class="btn btn-light rounded-circle border border-primary text-primary " href="{{route('manager.lot')}}"><i class="fa-solid fa-arrow-left"></i></a>
            <button name="btnSave" id="btnSave" class="btn btn-primary rounded-pill w-75 float-right" type="submit">Thêm</button>
        </form>
    </div>
</div>
@endsection

