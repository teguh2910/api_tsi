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

            <div class="col-md-9">
                <div class="card">
                    <form action="{{ route('meeting.update', ['id'=>$meeting->id]) }}" method="post" class="bg-dark">
                        @csrf
                        <div class="card-header">
                            Persetujuan Meeting oleh Host
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Topic</label>
                                <div class="col-sm-9">
                                    <select class="form-control form-control-sm" name="zoom_master" readonly name="id_meeting">
                                        <option value="{{ $meeting->id }}">{{ $meeting->topic }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Tanggal</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local" class="form-control form-control-sm" readonly value="{{ $meeting->date_time }}">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">ID Meeting</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control form-control-sm" readonly value="{{ $meeting->id_meeting }}">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Passcode</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control form-control-sm" readonly value="{{ $meeting->pass_code }}">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Url</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" readonly value="{{ $meeting->url }}">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Zoom Master</label>
                                <div class="col-sm-9">
                                    <select class="form-control form-control-sm" name="zoom_master">
                                        <option>---pilih---</option>
                                        @foreach($zoom_master as $zoom)
                                            <option value="{{ $zoom->_id }}">
                                                {{ $zoom->room_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('meeting.show', ['id'=>$meeting->id]) }}" class="btn btn-danger">Back</a>
                            <button class="btn btn-success" type="submit">Validation</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>
        </div>
    </section>
@endsection
