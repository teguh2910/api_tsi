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
                        <div class="card-body">
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#exampleModal">
                                Tambah Obat
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('medication.store') }}" method="post">
                                            @csrf
                                            <div class="modal-header bg-black">
                                                <h5 class="modal-title" id="exampleModalLabel">Tambah Obat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Nama Obat</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" required name="drug">
                                                            <option value="" selected>---pilih---</option>
                                                            @foreach($drugs as $drug)
                                                                <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Frekwensi</label>
                                                    <div class="col-sm-4" mb-2>
                                                        <input type="number" class="form-control" name="frequency">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" required name="unit_frequency">
                                                            <option value="Daily" selected>Kali Per Hari</option>
                                                            <option value="Hourly">Kali Per Jam</option>
                                                            <option value="Weekly">Kali Per Minggu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Dosis</label>
                                                    <div class="col-sm-4" mb-2>
                                                        <input type="number" class="form-control" name="dosage">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" required name="unit_dosage">
                                                            <option value="tab" selected>Tablet</option>
                                                            <option value="kap">Kapsul</option>
                                                            <option value="powder">Puyer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Obat Tersedia</label>
                                                    <div class="col-sm-4" mb-2>
                                                        <input type="number" class="form-control" name="qty">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" required name="unit_qty">
                                                            <option value="tab" selected>Tablet</option>
                                                            <option value="kap">Kapsul</option>
                                                            <option value="powder">Puyer</option>
                                                        </select>
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
                            <table class="table table-sm mt-2" id="example1">
                                <thead>
                                <th>#</th>
                                <th>Drug</th>
                                <th>Frequency</th>
                                <th>Dosage</th>
                                <th>Sisa Obat</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($medications as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->drug['name'] }}</td>
                                    <td>
                                        {{ $data->frequency['frequency'] }}
                                        @if($data->frequency['unit_frequency'] == "Hourly")
                                            {{ "Kali/Jam" }}
                                        @elseif($data->frequency['unit_frequency'] == "Daily")
                                            {{ "Kali/Hari" }}
                                        @elseif($data->frequency['unit_frequency'] == "Weekly")
                                            {{ "Kali/Minggu" }}
                                        @endif
                                    </td>
                                    <td>{{ $data->dosage['dosage'] }} {{ $data->dosage['unit_dosage'] }}</td>
                                    <td>{{ $data->qty['qty'] }}</td>
                                    <td><a href="{{ route('medication.show', ['id'=>$data->id]) }}" class="btn btn-sm btn-info">Detail</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </div>
            <!-- /.container-fluid -->
    </section>
@endsection
