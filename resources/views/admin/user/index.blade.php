@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-black"><b>Daftar User</b></div>

                        <div class="card-body">
                            <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Add User</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Usia</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ date('d', strtotime($user->birth_date))."-".date('m', strtotime($user->birth_date))."-".date('y', strtotime($user->birth_date)) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->nomor_telepon }}</td>
                                        <td>
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
    </section>
@endsection
