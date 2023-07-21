@extends('layout.auth')
@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>{{ env('APP_NAME') }}</b></a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            @if(session('success') != null)
                <p class="login-box-msg text-success">{{ session('success') }}</p>
            @elseif(session('danger') != null)
                <p class="login-box-msg text-danger">{{ session('danger') }}</p>
            @else
                <p class="login-box-msg">
                    You forgot your password? Here you can easily retrieve a new password.
                </p>
            @endif

            <form action="{{ route('auth.getPassword') }}" method="post">
                @csrf
                <div class="mb-3">
                    <input type="number" class="form-control" placeholder="Nomor Telepon" name="nomor_telepon" value="{{ old('nomor_telepon') }}">
                    @error('nomor_telepon')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                    </div>

                </div>
            </form>
            <p class="mt-3 mb-1">
                <a href="{{ route('auth.login') }}">Login</a>
            </p>
                <p class="mb-1">
                    <a href="{{ route('auth.request.reset.password') }}">Reset Password</a>
                </p>
            <p class="mb-0">
                <a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a>
            </p>
        </div>

    </div>
</div>
@endsection
