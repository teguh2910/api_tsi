@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>{{ env('APP_NAME') }}</b></a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                @if(session('gagal_login') != null)
                    <p class="login-box-msg text-danger">{{ session('gagal_login') }}</p>
                @elseif (session('success') != null)
                @else
                    <p class="login-box-msg">Sign in to start your session</p>
                @endif
                <form action="{{ route('auth.postLogin') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Email" value="{{ old('username') }}">
                        @error('username')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                    <hr>
                    <p class="mb-0"><a href="{{ route('auth.activate') }}" class="text-center">Account Activation</a></p>
                    <p class="mb-0"><a href="{{ route('auth.forgotPassword') }}">I forgot my password</a></p>
                    <p class="mb-0"><a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a></p>
            </div>

        </div>
    </div>
@endsection


