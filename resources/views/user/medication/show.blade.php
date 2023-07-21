@extends('layout.user')
@section('content')
    <section class="content">
        <div class="container-fluid">
            @if(\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {!! \Session::get('success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(\Session::has('danger'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {!! \Session::get('danger') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            {{ $medication->drug['name'] }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row justify-center">
                                                <div class="col-6">
                                                    <strong>Dosis</strong>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                        Jadwal
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <form action="{{ route('medication.schedule.store', ['id'=>$medication->id]) }}" method="post">
                                                                    @csrf
                                                                    <div class="modal-header bg-black">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Obat</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-4 col-form-label">Jam Pemberian</label>
                                                                            <div class="col-sm-4" mb-2>
                                                                                <input type="time" class="form-control" name="time">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-striped">
                                                <tr>
                                                    <td>Nama Obat</td>
                                                    <td>:</td>
                                                    <td>{{ $medication->drug['name'] }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Frequency</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $medication->frequency['frequency'] }}
                                                        @if($medication->frequency['unit_frequency'] == "Hourly")
                                                            {{ "Kali/Jam" }}
                                                        @elseif($medication->frequency['unit_frequency'] == "Daily")
                                                            {{ "Kali/Hari" }}
                                                        @elseif($medication->frequency['unit_frequency'] == "Weekly")
                                                            {{ "Kali/Minggu" }}
                                                        @endif
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>Dosis</td>
                                                    <td>:</td>
                                                    <td>
                                                        {{ $medication->dosage['dosage'] }} {{ $medication->dosage['unit_dosage'] }}
                                                    </td>
                                                </tr>
                                                @foreach($jadwal as $data)
                                                    <tr>
                                                        <td class="text-right">{{ $loop->iteration }}</td>
                                                        <td>:</td>
                                                        <td>{{ $data->time }}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <b>Riwayat Pemberian Obat</b>
                                        </div>
                                        <div class="card-body">

                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm table-striped">


                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection
