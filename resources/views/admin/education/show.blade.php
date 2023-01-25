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
                        <div class="row mt-2 justify-content-center">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header bg-dark"><b>Update {{ $title }}</b></div>
                                    <form action="{{ route('education.update', ['id'=>$education->id]) }}" method="post">
                                        @csrf
                                        @include('admin.education._form')
                                        <diV class="card-footer">
                                            <a href="{{ route('education') }}" class="btn btn-warning">Back</a>
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#staticBackdrop">
                                                Delete
                                            </button>
                                        </diV>
                                    </form>

                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Delete Data {{ $education->pendidikan }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form method="post" action="{{ route('education.destroy', ['id'=>$education->id]) }}">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <input type="checkbox" name="hapus_data" required> Yakin hapus data {{ $education->pendidikan }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
    </section>
@endsection
