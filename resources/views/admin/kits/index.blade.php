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
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-1" data-toggle="modal" data-target="#exampleModal">
                                Add Data
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary">
                                            <h5 class="modal-title" id="exampleModalLabel">Creating New Kit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('kits.store') }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Code</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="code">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" name="name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Owner</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="owner">
                                                            <option value="">----select----</option>
                                                            @foreach($customer as $data)
                                                                <option value="{{ $data->code }}">{{ $data->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3">Distributor</label>
                                                    <div class="col-sm-9">
                                                        <select class="form-control" name="distributor">
                                                            <option value="">----select----</option>
                                                            @foreach($customer as $data)
                                                                <option value="{{ $data->code }}">{{ $data->name }}</option>
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
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Owner</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($kits as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->code }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>@if(isset($data->owner)) {{ $data->owner['name'] }}@endif</td>
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
