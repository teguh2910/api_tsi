@extends('layout.admin')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

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
                            <a href="{{ route('questionnaire.create') }}" class="btn btn-sm btn-primary mb-1">Add Internal</a>
                            <a href="{{ route('questionnaire.create') }}" class="btn btn-sm btn-info mb-1">Add External</a>
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Questionnaire</th>
                                <th>Question</th>
                                <th>Responden</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($questionnaire as $data)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->judul }}</td>
                                        <td>{{ $data->question }}</td>
                                        <td>@if(isset($data->owner)) {{ $data->owner['name'] }}@endif</td>
                                        <td><a href="{{ route('questionnaire.show', ['id'=> $data->id]) }}" class="btn btn-sm btn-info">Detail</a></td>
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
