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
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header bg-dark"><b>Create Master {{ $title }}</b></div>
                                    <form action="{{ route('kits.store') }}" method="post">
                                        @csrf
                                        @include('admin.kits._form')
                                        <diV class="card-footer">
                                            <a href="{{ route('kits.index') }}" class="btn btn-warning">Back</a>
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
