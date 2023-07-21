@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="/"><b>{{ env('APP_NAME') }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                @if(session('success') != null)
                    <p class="login-box-msg text-success">{{ session('success') }}</p>
                @elseif(session('danger') != null)
                    <p class="login-box-msg text-danger">{{ session('danger') }}</p>
                @else
                    <p class="login-box-msg">Enter OTP and email from your email.</p>
                @endif

                <form action="{{ route('auth.do.reset.password') }}" method="post">
                    @csrf
                    <div class="mb-1">
                        <input type="number" class="form-control" placeholder="OTP" name="otp" value="{{ old('otp') }}">
                        @error('otp')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-1">
                        <input type="email" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-1">
                        <input type="password" class="form-control" placeholder="Passwor Confirm" name="password_confirmation">
                        @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Create New Password</button>
                        </div>

                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('auth.login') }}">Login</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('auth.register') }}" class="text-center">Register</a>
                </p>
            </div>

        </div>
    </div>
@endsection
