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
                        <div class="row my-2 mx-2 justify-content-center">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header bg-black"><b>Show Master {{ $title }}</b></div>
                                    <div class="card-body">
                                        <div class="row mb-1">
                                            <label class="col-sm-2">System</label>
                                            <div class="col-sm-10">
                                                {{ $marital_status->system }}
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Marital Status</label>
                                            <div class="col-sm-10">
                                                {{ $marital_status->display }}
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label class="col-sm-2">Code</label>
                                            <div class="col-sm-10">
                                                {{ $marital_status->code }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label class="col-sm-2">Deskripsi</label>
                                            <div class="col-sm-10">
                                                {{ $marital_status->definition }}
                                            </div>
                                        </div>

                                    </div>
                                    <diV class="card-footer">
                                        <a href="{{ route('marital_status') }}" class="btn btn-warning">Back</a>
                                        <a href="{{ route('marital_status.edit', ['id'=>$marital_status->id]) }}" class="btn btn-success">Edit</a>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">
                                            Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('marital_status.destroy', ['id'=>$marital_status->id]) }}" method="post">
                                                        @csrf
                                                        <div class="modal-header bg-danger">
                                                            <h5 class="modal-title" id="staticBackdropLabel">Delete {{ $marital_status->marital_status }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="checkbox" name="hapus_data" required> Apakah anda yakin menghapus data ini??
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>

                                    </diV>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
    </section>
@endsection
