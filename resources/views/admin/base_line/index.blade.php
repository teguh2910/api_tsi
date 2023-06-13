@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-info">
                            @include('layout.menu.admin.submenu.master')
                        </div>
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
                            <a href="{{ route('kits.create') }}" class="btn btn-sm btn-primary mb-1">Add Data</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Variabel</th>
                                <th>variabel 1</th>
                                <th>Nilai Variabel 1</th>
                                <th>Variabel 2</th>
                                <th>Nilai Variabel 2</th>
                                <th>Label</th>
                                </thead>
                                <tbody>
                                @foreach($base_line as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->variabel }}</td>
                                    <td>{{ $data->variabel_1 }}</td>
                                    <td>{{ $data->nilai_variabel_1 }}</td>
                                    <td>{{ $data->variabel_2 }}</td>
                                    <td>{{ $data->nilai_variabel_2 }}</td>
                                    <td>{{ $data->label }}</td>
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
