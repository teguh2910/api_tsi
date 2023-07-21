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
                        <div class="row">
                            <label class="col-sm-2">Nama</label>
                            <div class="col-sm-10">{{ $counselor->nama['nama_depan']." ".$counselor->nama['nama_belakang']}}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2">Email</label>
                            <div class="col-sm-10">{{ $counselor->kontak['email'] }}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-2">Nomor Telepon</label>
                            <div class="col-sm-10">{{ $counselor->kontak['nomor_telepon'] }}</div>
                        </div>
                    </div>
                    <div class="card-header">
                        <b>Daftar Pasien Kelolaan</b>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('pasien.tbc.create.counselor', ['id'=>$counselor->id]) }}" class="btn btn-sm btn-primary mb-2">Add New Patient</a>
                        <table class="table table-sm">
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
                                    <a href="{{ route('pasien.tbc.destroy', ['id'=>$data->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('counselor.index') }}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
