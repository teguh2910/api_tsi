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
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
                            Add Counselor
                        </button>
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
                            @foreach($counselors as $counselor)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $counselor->nama['nama_depan']." ". $counselor->nama['nama_belakang']}}</td>
                                <td>{{ $counselor->kontak['email'] }}</td>
                                <td>{{ $counselor->kontak['nomor_telepon'] }}</td>
                                <td>
                                    <a href="{{ route('counselor.show', ['id'=>$counselor->id]) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('counselor.destroy', ['id'=>$counselor->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Counselor Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('counselor.store') }}" method="post">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label for="staticEmail" class="col-sm-2 col-form-label">Users</label>
                                            <div class="col-sm-10">
                                                <select class="form-control form-control-sm" name="id_user">
                                                    <option value="">---pilih---</option>
                                                    @foreach($users as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama['nama_depan']." ". $data->nama['nama_belakang']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
