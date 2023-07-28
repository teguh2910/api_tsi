<div class="col-lg-3 col-md-4 col-sm-6 mb-5">
    <!-- Profile Image -->
    <div class="card card-primary card-outline">
        <div class="card-body box-profile" >
            <div class="text-center " data-toggle="modal" data-target="#updateFoto">
                @if($user->foto == null)
                    <img class="profile-user-img img-fluid img-circle w-30"
                         src="https://file.atm-sehat.com/storage/image/ZQC6SOX05hA0enLhvPWrEfVxMv9zzm9Sc7qp2EQO.jpg"
                         alt="User profile picture">
                @else
                    <img class="profile-user-img img-fluid img-circle w-30"
                         src="{{ $user->foto['url'] }}"
                         alt="User profile picture">
                @endif
            </div>
            <h3 class="profile-username text-center @if(! empty($user->tbc)) bg-warning @endif">
                {{ $user['nama']['nama_depan']." ".$user['nama']['nama_belakang'] }}
            </h3>
            <p class="text-muted text-center">{{ $user->nik }}</p>
            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Tempat Lahir</b> <a class="float-right text-success">{{ $user->lahir['tempat'] }}</a>
                </li>
                <li class="list-group-item">
                    <b>Tanggal Lahir</b> <a class="float-right text-success">{{ $user->lahir['tanggal'] }}</a>
                </li>
                <li class="list-group-item">
                    <b>Phone</b> <a class="float-right">{{ $user->kontak['nomor_telepon'] }}</a>
                </li>
                <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{ $user->kontak['email'] }}</a>
                </li>
            </ul>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="updateFoto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Your Foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- About Me Box -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">About Me</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <strong><i class="fas fa-book mr-1"></i> Education</strong>
            <p class="text-muted mb-1">
                @if(!empty($user->pendidikan))
                    {{ $user->pendidikan['pendidikan'] }}
                @endif
            </p>
            <hr class="mb-1 mt-1">
            <strong><i class="fas fa-users"></i> Status Menikah</strong>
            <p class="text-muted mb-0">
                @if($user->status_menikah != null)
                    {{ $user->status_menikah['display'] }}
                @endif
            </p>
            <hr class="mb-1 mt-1">
            <strong><i class="fas fa-bed"></i> BPJS</strong>
            <p class="text-muted mb-1">
                @if(!empty($user->bpjs_kesehatan))
                    {{ $user->bpjs_kesehatan['nomor'] }} <br>
                    {{ $user->bpjs_kesehatan['type'] }}
                @endif
            </p>
            <hr class="mb-1 mt-1">
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Adderess</strong>
            <p class="text-muted  mb-1">
                @if(!empty($user->address))
                    {{ $user->address['jalan'] }} No. {{ $user->address['nomor_rumah'] }} RT/RW : {{ $user->address['rukun_tetangga'] }} / {{ $user->address['rukun_warga'] }}<br>
                    {{ $user->address['kelurahan']['nama_kelurahan'] }},  {{ $user->address['kecamatan']['nama_kecamatan'] }}, {{ ucwords(strtolower($user->address['kota']['nama_kota'])) }}, {{ ucwords(strtolower($user->address['provinsi']['nama_provinsi'])) }}
            </p>
            @endif
        </div>
        <!-- /.card-body -->
        <div class="card-footer bg-primary">
            <a href="" class="btn btn-sm btn-primary">Update Profile</a>
        </div>



    </div>
    <!-- /.card -->
</div>
