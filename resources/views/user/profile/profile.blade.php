@extends('layout.user')
@section('content')

    <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-5">
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-5">
                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">

                            <div class="card-body box-profile">
                                <div class="text-center ">
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
                                <strong><i class="fas fa-map-marker-alt mr-1"></i> Adderess</strong>
                                <p class="text-muted">
                                    @if(!empty($user->address))
                                        {{ $user->address['jalan'] }} No. {{ $user->address['nomor_rumah'] }} RT/RW : {{ $user->address['rukun_tetangga'] }} / {{ $user->address['rukun_warga'] }}<br>
                                        {{ $user->address['kelurahan']['nama_kelurahan'] }},  {{ $user->address['kecamatan']['nama_kecamatan'] }}, {{ ucwords(strtolower($user->address['kota']['nama_kota'])) }}, {{ ucwords(strtolower($user->address['provinsi']['nama_provinsi'])) }}
                                </p>
                                @endif
                                    <hr>
                                <strong><i class="fas fa-book mr-1"></i> Education</strong>
                                <p class="text-muted">
                                    @if(!empty($user->pendidikan))
                                        {{ $user->pendidikan['pendidikan'] }}
                                    @endif
                                </p>
                                <hr>
                                <strong><i class="fas fa-users"></i> Status Menikah</strong>
                                <p class="text-muted">
                                    @if($user->status_menikah != null)
                                        {{ $user->status_menikah['display'] }}
                                    @endif
                                </p>

                                <hr>

                                <strong><i class="fas fa-bed"></i> BPJS</strong>
                                <p class="text-muted">
                                    @if(!empty($user->bpjs_kesehatan))
                                        {{ $user->bpjs_kesehatan['nomor'] }} <br>
                                        {{ $user->bpjs_kesehatan['type'] }}
                                    @endif
                                </p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-lg-9 col-md-8 col-sm-6">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#observation" data-toggle="tab">Health Over View</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#laporan" data-toggle="tab">Resume</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#family" data-toggle="tab">Family</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="observation">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped table-sm" id="example1">
                                                    <thead class="bg-secondary">
                                                    <th>No</th>
                                                    <th>Observation</th>
                                                    <th>Value</th>
                                                    <th>Interpretation</th>
                                                    <th>Base Line</th>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($observation as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->coding['display'] }}<br> <small>{{ date('Y-m-d H:i', $data->time) }}</small> </td>
                                                            <td>{{ $data->value }} <br> <small>{{ $data->unit['display'] }}</td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="family">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped table-sm" id="exaple1">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>DOB</th>
                                                        <th>NIK</th>
                                                        <th>Gender</th>
                                                        <th>Hubungan</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($family as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama['nama_depan'] }}</td>
                                                            <td>{{ $data->lahir['tanggal'] }}</td>
                                                            <td>{{ $data->nik }}</td>
                                                            <td>{{ $data->gender }}</td>
                                                            <td>{{ $data->family['hubungan_keluarga'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="laporan">
                                        <table class="table table-sm table-striped table-responsive">
                                            <thead>
                                            <th>#</th>
                                            <th>Observation</th>
                                            <th>Time</th>
                                            <th>Value</th>
                                            <th>Unit</th>
                                            <th>Label</th>
                                            </thead>
                                            <tbody>
                                            @foreach($resume as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->coding->display }}</td>
                                                    <td>{{ date('d-m-Y H:i', $data->time) }}</td>
                                                    <td>{{ round($data->value,2) }}</td>
                                                    <td>{{ $data->unit->display }}</td>
                                                    <td>
                                                        @if($data->interpretation != null)
                                                            {{ $data->interpretation->display }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>

                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
@endsection
