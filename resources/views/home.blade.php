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
                    @php
                        $user = Auth::user();
                    @endphp
                    @if ($user->hasRole('manager'))
                        <a href="{{route('manager.dashboard')}}">Đi đến trang quản lý</a>
                    @elseif ($user->hasRole('employee'))
                        <a href="{{route('employee.timetable')}}">Đi đến trang quản lý</a>
                    @elseif ($user->hasRole('administrator'))
                        <a href="{{route('admin.dashboard')}}">Đi đến trang quản lý</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
