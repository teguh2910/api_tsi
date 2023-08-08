@extends('layout.auth')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('home') }}"><h5 class="text-success">Home</h5></a>
            <a href="{{ url()->previous() }}"><h1 class="text-danger">FORBIDDEN</h1></a>
            <a href="{{ url()->previous() }}"><h5 class="text-success">Back</h5></a>

        </div>
    </div>
@endsection


