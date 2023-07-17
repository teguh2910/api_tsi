@extends('layout.auth')
@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="../../index2.html"><b>{{ env('APP_NAME') }}</b></a>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="login-box-msg">Register a new membership</p>
            <form action="{{ route('auth.daftar') }}" method="post">
                @csrf
                <div class="mb-1">
                    <input type="text" class="form-control" placeholder="Nama Depan" name="nama_depan" value="{{ old('nama_depan') }}">
                    @error('nama_depan')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="text" class="form-control" placeholder="Nama Belakang" name="nama_belakang" value="{{ old('nama_belakang') }}">
                    @error('nama_belakang')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="number" class="form-control" placeholder="Nomor KTP" name="nik" value="{{ old('nik') }}">
                    @error('nik')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="number" class="form-control" placeholder="Nomor Telfon" name="nomor_telepon" value="{{ old('nomor_telepon') }}">
                    @error('nomor_telepon')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="text" class="form-control" placeholder="Tempat Lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}">
                    @error('tempat_lahir')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="date" class="form-control" placeholder="Tanggal Lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                    @error('tanggal_lahir')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <select class="form-control" name="gender">
                        <option value="">Gender</option>
                        <option value="male">Laki-laki</option>
                        <option value="female">Perempuan</option>
                    </select>
                    @error('gender')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-1">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    @error('password')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
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
