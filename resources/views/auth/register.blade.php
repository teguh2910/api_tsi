@extends('layout.auth')
@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>{{ env('APP_NAME') }}</b></a>
    </div>
    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            <form action="{{ route('auth.postLogin') }}" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Full name">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Password">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Retype password">
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div>

                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>

                </div>
            </form>

            <a href="{{ route('auth.login') }}" class="text-center">I already have a membership</a>
        </div>

    </div>
</div>
@endsection
