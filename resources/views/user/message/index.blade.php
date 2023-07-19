@extends('layout.user')
@section('content')

    <section class="content">
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                {!! \Session::get('success') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
            <div class="row">
                <div class="col-md-3">
                    @include('user.message.menu-message')
                </div>
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Video Conference</h3>
                        </div>
                        <div class="card-body bg-secondary">
                            <form action="{{ route('meeting.store_by_pasien') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Date Start</label>
                                    <div class="col-sm-5">
                                        <input type="date" class="form-control" name="date_start">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="time" class="form-control" name="time_start">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Konselor</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="host">
                                            <option>---Select---</option>
                                            @foreach($counselor as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama['nama_depan'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9 text-right">
                                        <button type="submit" class="btn btn-warning">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer">
                            <b>Meeting Hari Ini</b>
                        </div>
                        <div class="card-body bg-info">
                            <table class="table table-sm">
                                <thead>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Start</th>
                                </thead>
                                <tbody>
                                @foreach($my_meetings as $meeting)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $meeting->topic }}</td>
                                        <td><button class="btn btn-sm btn-primary">Start</button></td>
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
