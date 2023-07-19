<?php
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
?>

<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Convention</h3>
            <br>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">

                <?php
                $chat_rooms = ChatRoom::where([
                    'user1' => Auth::id()
                ])->orWhere([
                    'user2' => Auth::id()
                ])->get();
                    ?>
                @foreach($chat_rooms as $cr)
                    <?php
                        $user1 = User::find($cr->user1);
                        $user2 = User::find($cr->user2);
                        ?>
                    <li class="nav-item">
                        <a href="{{ url('message/'.$cr->_id) }}" class="nav-link">
                            <i class="fas fa-user-alt"></i>
                            @if($cr->user1 == Auth::id()) {{ $user2->nama['nama_depan'] }}
                            @else {{ $user1->nama['nama_depan'] }}
                            @endif
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Konselor TBC</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <?php
                $counselor  = User::where('counselor', true)->get();
                    ?>
                @foreach($counselor as  $counselor)
                    <li class="nav-item">
                        <a href="{{ route('message.user', ['id'=>$counselor->_id]) }}" class="nav-link">
                            <i class="far fa-circle text-danger"></i>
                            <strong> {{ $counselor->nama['nama_depan'] }} </strong>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Video Conference</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-warning"></i> Hari Ini
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-danger"></i>
                        Akan Datang
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-circle text-primary"></i>
                        Yang Lalu
                    </a>
                </li>
            </ul>
        </div>

    </div>

</div>
