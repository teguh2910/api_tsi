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
                    @if($user->counselor == true)
                        @include('user.meeting.meeting_counselor')
                    @else
                        @include('user.meeting.meeting_pasien')
                    @endif
                </div>
            </div>
        </section>
@endsection
