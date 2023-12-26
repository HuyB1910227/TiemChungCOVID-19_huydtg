<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('user/vendor/bootstrap/css/bootstrap.min.css')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet"> --}}
    <title>Trang chủ</title>
</head>
<style>
    @page {
        size: auto;
        margin: 0mm;
        /* font-family:'Times New Roman', Times, serif, Helvetica */
    }
    body {
        margin: 0mm;
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 14px;
        
    }

    table{
        width: 100%;
        border-spacing: 0px;
    }
    
</style>
<body>
    <div style="height: 297mm; width: 210mm">
        <div style="background-color: rgb(0, 30, 68); padding: 5px">
        
            <h5 style="color:aliceblue; text-transform: uppercase;" >giấy chứng nhận tiêm vắc xin covid - 19 / covid 19 proof of vaccination</h5>
            
        </div>
        @php
            $user = Auth::guard('patient')->user();
        @endphp
        <div style="padding:10px">
                
                <h6 style="margin-top: 15px">Họ và tên / Full name: <b>{{$user->full_name}}</b></h6>
                <h6>Căn cước công dân/ Identify card: <b>{{$user->identify_card}}</b></h6>
                <h6>Ngày tiêm / Date of birth: <b>{{$user->date_of_birth}}</b></h6>
                <h6>Giới tính / Gender: <b>{{$user->gender == 1 ? "Nam" : "Nữ"}}</b></h6>
            <div style="padding: 5px">
                <h5 >Quản lý tiêm chủng / Vaccinations administered</h5>
                <div  style="height: 3px; background-color: rgb(0, 30, 68);"></div>
                <table border="1" style="margin-top: 5px;">
                    <tr>
                        <th>Mũi tiêm</th>
                        <th>Ngày tiêm</th>
                        <th>Vắc xin</th>
                        <th>Mã lô</th>
                    </tr>
                    @foreach (Auth::guard('patient')->user()->vaccinationHistories as $history)
                        <tr>
                            <td>
                                {{$history->number_of_injection}}
                            </td>
                            <td>
                                {{date("d-m-Y", strtotime($history->created_at))}}
                            </td>
                            <td>
                                {{$history->vaccineLot->vaccine->name}}
                            </td>
                            <td>
                                {{$history->vaccineLot->lot_code}}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div style="position: fixed; bottom: 0px; padding: 5px">
            <div>
                <p> Tài liệu này chứa thông tin chỉ dành cho cá nhân đã được nêu tên sử dụng và được cấp bởi tổ chức y tế thuộc tiemchungcovid19.vn nhằm xác nhận tiêm chủng phòng bệnh. Mọi hành vi sao chép hoặc phân phối nội dung sử dụng bởi mục đích trái phép đều bị nghiêm cấm.</p>
                <p> This document contains information only for the individual who has been named and issued by a health organization of tiemchungcovid19.vn to confirm vaccination against disease. Any copying or distribution of content for unauthorized use is strictly prohibited.</p>
            </div>
                
           
        </div>
    </div>
    
   
    
</body>

</html>