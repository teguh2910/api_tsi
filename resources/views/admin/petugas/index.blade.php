@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        @if(\Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                {!! \Session::get('success') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(\Session::has('danger'))
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                {!! \Session::get('danger') !!}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="card-body">
                            <a href="{{ route('petugas.create') }}" class="btn btn-sm btn-primary mb-1">Add Data</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($petugas['user'] as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->nama['nama_depan']." ".$data->nama['nama_belakang'] }}</td>
                                        <td>{{ $data->kontak['email'] }}</td>
                                        <td>{{ $data->kontak['nomor_telepon'] }}</td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-info">Detail</a>
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
