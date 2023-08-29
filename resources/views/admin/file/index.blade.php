
@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-black"><b>Daftar User</b></div>

                        <div class="card-body">
                            <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">Add File</a>
                            <div class="row">
                                @foreach($files as $data)
                                    <div class="col-md-3">
                                        <div class="card">
                                            <img src="{{ $data->url }}" class="card-img-top">
                                            <div class="card-body">

                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>
            </div>
            <!-- /.container-fluid -->
    </section>
@endsection
