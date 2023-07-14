<?php
$my_id      = "64ab60837fb2f5709001bbe2";
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
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="fas fa-inbox"></i> Inbox
                        <span class="badge bg-primary float-right">12</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-envelope"></i> Sent
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="far fa-file-alt"></i> Drafts
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-filter"></i> Junk
                        <span class="badge bg-warning float-right">65</span>
                    </a>
                </li>
                <?php
                $chat_rooms = \App\Models\ChatRoom::where([
                    'user1' => $my_id
                ])->orWhere([
                    'user2' => $my_id
                ])->get();
                    ?>
                @foreach($chat_rooms as $cr)
                    <?php
                        $user1 = \App\Models\User::find($cr->user1);
                        $user2 = \App\Models\User::find($cr->user2);
                        ?>
                    <li class="nav-item">
                        <a href="{{ url('message/'.$cr->_id) }}" class="nav-link">
                            <i class="fas fa-user-alt"></i>@if($cr->user1 == $my_id) {{ $user2->nama['nama_depan'] }}@else {{ $user1->nama['nama_depan'] }} @endif
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
                $counselor  = \App\Models\User::where('counselor', true)->get();
                    ?>
                @foreach($counselor as  $counselor)
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-danger"></i>
                            <strong> {{ $counselor->nama['nama_depan'] }} </strong>
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>

    </div>

</div>
