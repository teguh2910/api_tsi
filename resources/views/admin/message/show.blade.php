@extends('layout.user')
@section('content')
    <?php
    $my_id      = "64ab60837fb2f5709001bbe2";
    ?>
    <section class="content">
        <div class="row">
            @include('admin.message.menu-message')
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Inbox</h3>
                    </div>
                    <div class="card-body p-2">
                        @foreach($chats as $ch)
                            <div class="row">
                                <div class="col-md-9 @if($ch->id_sender == $my_id) ml-auto @else mr-auto @endif">
                                    <div class="col-auto">
                                        <div class="card">
                                            <div class="card-body @if($ch->id_sender == $my_id)bg-secondary @endif">
                                                {{ $ch->message }}
                                                <br>
                                                <small>{{ date('H:i', strtotime($ch->created_at))   }}</small>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <div class="card">
                            <div class="card-header">
                                <input type="text" class="form-control">
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-sm btn-success">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
