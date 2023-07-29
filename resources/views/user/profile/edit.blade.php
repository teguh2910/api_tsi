@extends('layout.user')
@section('content')
    <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @elseif(\Session::has('danger'))
                    <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('danger') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row mb-5">
                    @include('user.profile.menu')
                    <div class="col-lg-9 col-md-8 col-sm-6">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <b>Update Profile</b>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('profile.update') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="col-sm-2">Nama Depan</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{ $user['nama']['nama_depan'] }}" name="nama_depan">
                                                @error('nama_depan')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label class="col-sm-2">Nama Belakang</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{ $user['nama']['nama_belakang'] }}" name="nama_belakang">
                                                @error('nama_belakang')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2">Tempat Lahir</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" value="{{ $user['lahir']['tempat'] }}" name="tempat_lahir">
                                                @error('tempat_lahir')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label class="col-sm-2">Tanggal Lahir</label>
                                            <div class="col-sm-4">
                                                <input type="date" class="form-control" value="{{ $user['lahir']['tanggal'] }}" name="tanggal_lahir">
                                                @error('tanggal_lahir')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2">Gender</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="gender">
                                                    <option value="female" @if($user->gender == "female") {{ "selected" }} @endif>Perempuan</option>
                                                    <option value="male" @if($user->gender == "male") {{ "selected" }} @endif>Laki-laki</option>
                                                </select>
                                                @error('gender')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label class="col-sm-2">Agama</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="agama">
                                                    @foreach($agama as $list)
                                                        <option value="{{ $list->name }}"
                                                        @if($user->agama !=null)
                                                            @if($list->id == $user->agama['id']) {{ "selected" }} @endif
                                                            @endif>{{ $list['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                @error('agama')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2">Status Menikah</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="status_menikah">
                                                    @foreach($marital_status as $list)
                                                        <option value="{{ $list->code }}" @if($list->code == $user->status_menikah['code']) {{ "selected" }} @endif>{{ $list->display }}</option>
                                                    @endforeach
                                                </select>
                                                @error('status_menikah')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label class="col-sm-2">Pendidikan</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="pendidikan">
                                                    @foreach($pendidikan as $list)
                                                        <option value="{{ $list->id }}"
                                                        @if($user->pendidikan != null)
                                                            @if($list->kode == $user->pendidikan['kode']){{ "selected" }}@endif
                                                            @endif>{{ $list['pendidikan'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('pendidikan')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-2">Suku</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control" name="suku" value="{{ $user->suku }}">
                                                @error('suku')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <label class="col-sm-2">Warga Negara</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" name="warga_negara">
                                                    <option value="WNI" @if($user->warga_negara == "WNI") {{ "selected" }} @endif>Indonesia</option>
                                                    <option value="WNA"  @if($user->warga_negara == "WNA") {{ "selected" }} @endif>Warga Negara Asing</option>
                                                </select>
                                                @error('warga_negara')
                                                <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Back</a>
                                        <button type="submit" class="btn btn-primary">Save Change</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
