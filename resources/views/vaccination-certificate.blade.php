
@extends('layouts.UserApp')

@section('title', 'Chứng nhận tiêm chủng')
@section('ex-css')
@endsection
@section('main-content')
<div class="container-lg">
    <div class="text-center ">
        <h3 class="titile mb-1">Chứng nhận tiêm</h3>
    </div>
    <div class="row">
        <div class="row mx-auto">
            <div class="col rounded-0 jumbotron mb-0" style="background-color: #038032;">
                <p class="text-center display-4 text-white"><i class="fa-solid fa-shield-virus"></i></p>
                <hr>
                <h3 class="text-center text-uppercase text-white-50">Đã tiêm <span style="color: red"> 0{{count($patient->vaccinationHistories)}}</span> mũi vắc xin</h3>
                <hr>
            </div>
            <div class="col rounded-0 jumbotron mb-0">
                <h2 class="text-info">Thông tin cá nhân</h2>
                <table class="table">
                    <tr>
                        <td>Họ tên:</td>
                        <td>{{$patient->full_name}}</td>
                    </tr>
                    <tr>
                        <td>CMDN/CCCD:</td>
                        <td>{{$patient->identify_card}}</td>
                    </tr>
                    <tr>
                        <td>Giới tính:</td>
                        <td>{{$patient->gender == 1 ? "Nam" : "Nữ"}}</td>
                    </tr>
                    <tr>
                        <td>Ngày sinh: </td>
                        <td>{{date("d/m/Y", strtotime($patient->date_of_birth))}}</td>
                    </tr>
                </table>

            </div>
        </div>
    </div>
    
    <div class="row p-2">
        {{-- <h5>Quý khách có thể lưu trữ giấy chứng nhận tại đây: </h5> --}}
        @if (count($patient->vaccinationHistories) != 0)
            <br>
            <a class="btn btn-primary" href="{{route('generatePDF')}}"><i class="fa-regular fa-file-pdf"></i> Chứng Nhận PDF</a>
        @endif
    </div>
</div>
@endsection




