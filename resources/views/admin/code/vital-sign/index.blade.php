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

                        <div class="card-body">
                            <a href="{{ route('code.create') }}" class="btn btn-sm btn-primary mb-3">Add Data</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Display</th>
                                <th>System</th>
                                <th>Aksi</th>
                                </thead>
                                <tbody>
                                @foreach($code as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->code }}</td>
                                        <td>{{ $data->display }}</td>
                                        <td>{{ $data->system }}</td>
                                        <td><a href="{{ route('code.show', ['id'=>$data->id]) }}" class="btn btn-sm btn-info">Detail</a></td>
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
