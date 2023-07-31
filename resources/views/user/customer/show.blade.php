@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <b>{{ $title }}</b>
                    </div>
                    <div class="card-body">
                        <a href="" class="btn btn-sm btn-primary mb-2">Add Data</a>
                        <table class="table table-sm table-striped">
                            <thead>
                            <th>#</th>
                            <th>Name</th>
                            <th>PIC</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Detail</th>
                            </thead>
                            <tbody>
                            @foreach($kits as $list)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><a href="{{ route('customers.show', ['id'=>$list->id]) }}" class="btn btn-sm btn-primary">Detail</a></td>
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
