@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
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
                    <div class="card">
                        <div class="card-header bg-info">
                            @include('layout.menu.admin.submenu.master')
                        </div>
                        <div class="row mt-2 justify-content-center">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header bg-dark"><b>Create Master {{ $title }}</b></div>
                                    <form action="{{ route('code.store') }}" method="post">
                                        @csrf
                                        @include('admin.code._form')
                                        <diV class="card-footer">
                                            <a href="{{ route('code.index') }}" class="btn btn-warning">Back</a>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </diV>
                                    </form>
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
