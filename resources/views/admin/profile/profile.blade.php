@extends('layout.admin')
@section('content')
    <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle w-30"
                                         src="{{ $user->foto['url'] }}"
                                         alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $user['nama']['nama_depan']." ".$user['nama']['nama_belakang'] }}</h3>

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
                                    Pesona Cilebut 2 Blok CB6 No. 30<br>
                                    Cilebut Barat,  Sukaraja, Kab. Bogor, Jawa Barat                </p>

                                <hr>
                                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                                <p class="text-muted">
                                    Ners <br>Universitas Binawan<br>2020-10-01                </p>

                                <hr>

                                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                                <p class="text-muted">
                                    PK1 Neurosains<br>
                                    Perawat Terampil                </p>

                                <hr>

                                <strong><i class="fas fa-bed"></i> Ruangan</strong>
                                <p class="text-muted">Komite Keperawatan</p>
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
                                    <li class="nav-item"><a class="nav-link" href="#obat" data-toggle="tab">Obat</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#laporan" data-toggle="tab">Laporan</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="observation">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-striped table-sm" id="exaple1">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Observation</th>
                                                        <th>Value</th>
                                                        <th>Interpretation</th>
                                                        <th>Base Line</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($observation as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->coding['display'] }}<br> <small>{{ date('Y-m-d H:i', $data->time) }}</small> </td>
                                                            <td>{{ $data->value }} <br> <small>{{ $data->unit['display'] }}</td>
                                                            <td>{{ $data->interpretation['display'] }}</td>
                                                            <td>
                                                                @if($data->base_line != null)
                                                                    {{ $data->base_line['min'] }} - {{ $data->base_line['max'] }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="obat">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                    Tambah Obat
                                                </button>

                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                                                <table class="table table-striped table-sm" id="exaple1">
                                                    <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Obat</th>
                                                        <th>Dosis</th>
                                                        <th>Sisa</th>
                                                        <th>Base Line</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($observation as $data)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->coding['display'] }}<br> <small>{{ date('Y-m-d H:i', $data->time) }}</small> </td>
                                                            <td>{{ $data->value }} <br> <small>{{ $data->unit['display'] }}</td>
                                                            <td>{{ $data->interpretation['display'] }}</td>
                                                            <td>
                                                                @if($data->base_line != null)
                                                                    {{ $data->base_line['min'] }} - {{ $data->base_line['max'] }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="laporan">
                                        <h5>Laporan</h5>
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
