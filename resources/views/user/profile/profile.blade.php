@extends('layout.user')
@section('content')

    <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row mb-5">
                    @include('user.profile.menu')
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
                                                    <td>
                                                        @if($data != null)
                                                            {{ $data->coding->display }}
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ date('d-m-Y H:i', $data->time) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ round($data->value,2) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            {{ $data->unit->display }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($data != null)
                                                            @if($data->interpretation != null)
                                                                {{ $data->interpretation->display }}
                                                            @endif
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
