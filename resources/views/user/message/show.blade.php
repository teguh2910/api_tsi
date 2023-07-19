@extends('layout.user')
@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>
            <div class="col-md-9">
                <div class="card direct-chat direct-chat-success">
                    <div class="card-header">
                        <h3 class="card-title">{{ $partner->nama['nama_depan'] }}</h3>
                        <div class="card-tools">
                            <span title="3 New Messages" class="badge badge-primary">3</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                                <i class="fas fa-comments"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="direct-chat-messages h-100">
                            @foreach($chats as $c )
                                @php
                                    $sender = \App\Models\User::find($c->id_sender);
                                    $today = date('Y-m-d');
                                    $date_chat = date('Y-m-d', strtotime($c->created_at));
                                    if($date_chat == $today){
                                        $time = date('H:i', strtotime($c->created_at));
                                    }else{
                                        $time = date('Y-m-d H:i', strtotime($c->created_at));
                                    }

                                @endphp
                            <div class="direct-chat-msg @if($c->id_sender == $my_id)right @else left @endif">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name @if($c->id_sender == $my_id)float-right @else float-left  @endif">{{ $sender->nama['nama_depan']." ".$sender->nama['nama_belakang'] }}</span>
                                    <span class="direct-chat-timestamp @if($c->id_sender == $my_id)float-left @else float-right @endif">{{ $time }}</span>
                                </div>
                                <div class="direct-chat-text">
                                    {{ $c->message }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="card-footer mb-5">
                        <form action="{{ route('message.room.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="hidden" name="id_receiver" class="form-control" value="{{ $partner->_id }}">
                                <input type="hidden" name="id_chat_room" class="form-control" value="{{ $chat_room->_id }}">
                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">

                                <span class="input-group-append"><button type="submit" class="btn btn-primary">Send</button></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
