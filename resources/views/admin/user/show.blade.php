@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header bg-black"><b>Identitas</b></div>
                                        <div class="card-body">
                                            <table class="table table-sm table-striped">
                                                <tr>
                                                    <th>Nama</th>
                                                    <td>:</td>
                                                    <td>@if(isset($users->gelar['gelar_depan']) and $users->gelar['gelar_depan'] !=''){{ $users->gelar['gelar_depan'] }}. @endif{{ $users->nama['nama_depan'] }} {{ $users->nama['nama_belakang'] }}@if(isset($users->gelar['gelar_belakang']) and $users->gelar['gelar_belakang'] !=''), {{ $users->gelar['gelar_belakang'] }}  @endif</td>
                                               </tr>
                                                <tr>
                                                    <th>NIK</th>
                                                    <td>:</td>
                                                    <td>{{ $users->nik }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th>
                                                    <td>:</td>
                                                    <td>{{ $users->gender }}</td>
                                                </tr>
                                                <tr>
                                                    <th>TTL</th>
                                                    <td>:</td>
                                                    <td>{{ $users->lahir['tempat'] }}, {{ date('d-m-Y', strtotime($users->lahir['tanggal'])) }}</td>
                                                </tr>

                                                <tr>
                                                    <th>Phone</th>
                                                    <td>:</td>
                                                    <td>{{ $users->kontak['nomor_telepon'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email</th>
                                                    <td>:</td>
                                                    <td>{{ $users->kontak['email'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>:</td>
                                                    <td>
                                                        @if(isset($users['status_menikah']))
                                                            {{ $users['status_menikah']['display'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Agama</th>
                                                    <td>:</td>
                                                    <td>
                                                        @if(isset($users['agama']))
                                                            {{ $users['agama']['name'] }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Suku</th>
                                                    <td>:</td>
                                                    <td>{{ $users['suku'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Warna Negara</th>
                                                    <td>:</td>
                                                    <td>{{ $users['warga_negara'] }}</td>
                                                </tr>
                                            </table>

                                        </div>

                                    </div>

                                </div>

                            </div>




                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('user.profile', ['id'=> $users->id]) }}" class="btn btn-success">Profile</a>
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Kembali</a>
                            <a href="{{ route('users.edit', ['id'=> $users->id]) }}" class="btn btn-success">Edit User</a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                Blokir
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger">
                                            <h5 class="modal-title" id="exampleModalLabel">Anda yakin blokir data ini</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('users.blokir', ['id'=>$users->id]) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <label>Input Your Password</label><br>
                                                <input type="password" name="password" class="form-control">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Blokir</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
    </section>
@endsection
