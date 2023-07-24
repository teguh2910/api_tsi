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
                    <p class="login-box-msg text-success">{{ session('danger') }}</p>
                @else
                    <p class="login-box-msg">Enter email to create new OTP.</p>
                @endif
                <form action="{{ route('auth.do_activate') }}" method="post">
                    @csrf

                    <div class="mb-1">
                        <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Create New OTP</button>
                        </div>
                    </div>
                </form>
                    <hr>
                    <p class="mt-3 mb-0"><a href="{{ route('auth.activate') }}" class="text-center">Account Activation</a></p>
                    <p class="mb-1"><a href="{{ route('auth.login') }}">Login</a></p>
                    <p class="mb-0"><a href="{{ route('auth.register') }}" class="text-center">Register</a></p>
            </div>

        </div>
    </div>
@endsection
