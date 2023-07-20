@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <a href="" class="btn btn-sm btn-primary">Add New Patient</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm" id="example1">
                            <thead>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Detail</th>
                            </thead>
                            <tbody>
                            @foreach($pasien as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama['nama_depan']." ". $counselor->nama['nama_belakang']}}</td>
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
    </section>
@endsection
