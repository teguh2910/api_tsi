@extends('layout.user')
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
                            <a href="{{ route('zoom.master.create') }}" class="btn btn-sm btn-primary mb-1">Add Data</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Rom Name</th>
                                <th>ID Meeting</th>
                                <th>Passcode</th>
                                <th>Expired</th>
                                <th>Status</th>
                                <th>Url</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($zoom_masters as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->room_name }}</td>
                                        <td>{{ $data->id_meeting }}</td>
                                        <td>{{ $data->pass_code }}</td>
                                        <td>{{ $data->expired }}</td>
                                        <td>{{ $data->status }}</td>
                                        <td>{{ $data->url }}</td>
                                        <td><a href="" class="btn btn-sm btn-info">Detail</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
