@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Meetings</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm" id="example1">
                            <thead>
                            <th>#</th>
                            <th>Topic</th>
                            <th>Time</th>
                            <th>Attendee</th>
                            </thead>
                            <tbody>
                            @foreach($meetings as $data)
                                @php
                                $user = \App\Models\User::find($data->attendee)
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->topic }}</td>
                                    <td>{{ $data->date_time }}</td>
                                    <td>{{ $user->nama['nama_depan'] }}</td>
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
