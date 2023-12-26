@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Xác minh tài khoản email của bạn') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Đã gửi đường dẫn xác minh vào địa chỉ email của bạn!') }}
                        </div>
                    @endif

                    {{ __('Trước khi sử dụng tài khoản của bạn, vui lòng kiểm tra địa chỉ email cho việc xác minh.') }}
                    {{ __('Nếu email của bạn không nhận được tin nhắn, vui lòng:') }}
                    @if(auth('patient')->user())
                        <form class="d-inline" method="POST" action="{{ route('patient.verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline ">{{ __('nhấn vào đây để gửi lại!') }}</button>
                        </form>
                    @else 
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline ">{{ __('nhấn vào đây để gửi lại!') }}</button>
                        </form>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
