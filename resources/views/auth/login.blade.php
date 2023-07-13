@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session {{ $_SERVER['HTTP_USER_AGENT'] }}</p>
                <form action="{{ route('auth.postLogin') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="email" class="form-control" name="username" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
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

                <p class="mb-1">
                    <a href="{{ route('auth.forgotPassword') }}">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('auth.register') }}" class="text-center">Register a new membership</a>
                </p>
            </div>

        </div>
    </div>
@endsection


