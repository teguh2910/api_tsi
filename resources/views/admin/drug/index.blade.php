@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! \Session::get('success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(\Session::has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! \Session::get('danger') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
                                Tambah Obat
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('drugs.store') }}" method="post">
                                            @csrf
                                            <div class="modal-header bg-black">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Obat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Nama Obat</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Berat</label>
                                                    <div class="col-sm-4" mb-2>
                                                        <input type="number" class="form-control" name="totalVolume">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" required name="unit">
                                                            <option value="mg" selected>Mg</option>
                                                            <option value="gr">Gram</option>
                                                            <option value="iu">IU</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Sediaan</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" required name="doseForm">
                                                            <option value="tab" selected>Tablet</option>
                                                            <option value="kap">Kaplet</option>
                                                            <option value="caps">Kapsul</option>
                                                            <option value="syrup">Syrup</option>
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
                                <th>Nama Obat</th>
                                <th>Kekuatan</th>
                                <th>Satuan</th>
                                <th>Sediaan</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @foreach($drugs as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->totalVolume['volume'] }}</td>
                                        <td>{{ $data->totalVolume['unit'] }}</td>
                                        <td>{{ $data->doseForm }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" onclick="showConfirmation{{ $data->id }}()">Delete</button>
                                            <div class="modal fade" id="{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete {{ $data->name }}?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <a href="{{ route('drugs.destroy', ['id'=>$data->id]) }}" class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                function showConfirmation{{ $data->id }}() {
                                                    $('#{{ $data->id }}').modal('show');
                                                }
                                            </script>
                                        </td>
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
