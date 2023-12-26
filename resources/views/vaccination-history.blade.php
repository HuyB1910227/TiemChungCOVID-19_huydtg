@extends('layouts.UserApp')

@section('title', 'Lịch sử tiêm chủng')

@section('main-content')
<div class="container-lg">
    <h3 class="titile">Lịch sử tiêm chủng</h3>
    <table class="table table-bordered mt-1">
        <tr>
            <th>Mũi số</th>
            <th>Tên vắc xin</th>
            <th>Lô vắc xin</th>
            <th>Ngày tiêm</th>
            <th>Cơ sở tiêm chủng</th>
            <th>Địa chỉ</th>
            <th>Hotline</th>
            <th>Trạng thái sau tiêm</th>
        </tr>
        @if (empty($histories))
        <tr>
            <td colspan="8" class="text-danger text-center">(*) Chưa có lịch sử tiêm</td>
        </tr>
        @else
            @foreach ($histories as $history)
            <tr>
                <td>{{$history->number_of_injection === "AD" ? "Mũi tiêm bổ sung" : "Mũi tiêm thứ ".$history->number_of_injection}}</td>
                <td>{{$history->vaccineLot->vaccine->name}}</td>
                <td>{{$history->vaccineLot->lot_code}}</td>
                <td>{{date("d/m/Y", strtotime($history->created_at))}}</td>
                <td>{{$history->schedule->immunizationUnit->name}}</td>
                <td>{{$history->schedule->immunizationUnit->address}}</td>
                <td>{{$history->schedule->immunizationUnit->hotline}}</td>
                <td>{{$history->status_after}}</td>
            </tr>
            @endforeach
            
        @endif
        
    </table>
</div>
@endsection