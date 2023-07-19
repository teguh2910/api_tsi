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
                    <div class="card-header">
                        {{ $meeting->topic }}
                    </div>
                    <div class="card-body">
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
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('message.index') }}" class="btn btn-danger">Back</a>
                        @if($user->counselor == true)
                            <a href="{{ route('meeting.validation', ['id'=>$meeting->id]) }}" class="btn btn-primary">Validasi</a>
                        @endif

                        @if(! empty($meeting->url))
                            <a href="{{ $meeting->url }}" class="btn btn-primary" target="_blank">Start</a>
                        @else
                            <a href="{{ route('meeting.show', ['id'=>$meeting->id]) }}" class="btn btn-warning">Tunggu Validasi</a>
                        @endif

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>
        </div>
    </section>
@endsection
