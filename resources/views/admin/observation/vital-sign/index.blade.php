@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-black"><b>{{ $title }}</b></div>

                        <div class="card-body">
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Nama Observasi</th>
                                <th>Code</th>
                                <th>Hasil</th>
                                <th>Unit</th>
                                <th>Time</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>
                                @foreach($observation as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->coding['display'] }}</td>
                                        <td>{{ $data->coding['code'] }}</td>
                                        <td>{{ round($data->value, 2) }}</td>
                                        <td>{{ $data->unit['display'] }}</td>
                                        <td>{{ date('Y-m-d H:i:s', $data->time) }}</td>
                                        <td><a href="" class="btn btn-sm btn-info">Detail</a></td>
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
