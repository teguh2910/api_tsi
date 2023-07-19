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
                            <label class="col-sm-3">Tanggal</label>
                            <div class="col-sm-9">: {{ $meeting->date_time }}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label">ID Meeting</label>
                            <div class="col-sm-9">: {{ $meeting->id_meting }}</div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Passcode</label>
                            <div class="col-sm-9">: {{ $meeting->pas_code }}

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-sm-3 col-form-label">Url</label>
                            <div class="col-sm-9">: {{ $meeting->url }}</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>
        </div>
    </section>
@endsection
