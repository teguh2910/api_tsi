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
                                            <b>Dosis</b>
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
                                            </table>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <b>Jadwal</b>
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
