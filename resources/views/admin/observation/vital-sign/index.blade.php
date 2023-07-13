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
                                <th>Interpretation</th>
                                <th>Time</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>
                                @foreach($observation as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            {{ $data->coding['display'] }} <br>
                                            @if(! empty($data->pasien))
                                                {{ $data->pasien['nama']['nama_depan']. " ".$data->pasien['nama']['nama_belakang'] }}
                                            @endif
                                        </td>
                                        <td>{{ $data->coding['code'] }}</td>
                                        <td>{{ round($data->value, 2) }} <br> <small>{{ $data->unit['display'] }}</small></td>
                                        <td>
                                            @if(! empty($data->interpretation))
                                                {{ $data->interpretation['display'] }}
                                            @endif
                                        </td>
                                        <td>{{ date('Y-m-d', $data->time) }} <br> <small>{{ date('H:i:s', $data->time) }}</small> </td>
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
