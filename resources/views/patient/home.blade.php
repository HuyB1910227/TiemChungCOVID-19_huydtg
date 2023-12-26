@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Kích hoạt tài khoản') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('Tài khoản đã được kích hoạt!') }}
                    <a href="{{route('userHomePage')}}">Đi đến trang chủ</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
