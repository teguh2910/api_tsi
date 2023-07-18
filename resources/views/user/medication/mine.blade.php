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
                                                    <label class="col-sm-4 col-form-label">Dosis</label>
                                                    <div class="col-sm-4" mb-2>
                                                        <input type="number" class="form-control" name="dosage">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" required name="unit">
                                                            <option value="Daily" selected>Kali Per Hari</option>
                                                            <option value="Hourly">Kali Per Jam</option>
                                                            <option value="Weekly">Kali Per Minggu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-4 col-form-label">Qty</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" name="qty">
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
                                <th>Dosis</th>
                                <th>Qty</th>
                                <th>Detail</th>
                                </thead>
                                <tbody>
                                @foreach($medications as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->drug['name'] }}</td>
                                    <td>
                                        {{ $data->dosage['frekwensi'] }}
                                        @if($data->dosage['unit'] == "Hourly")
                                            {{ "Kali/Jam" }}
                                        @elseif($data->dosage['unit'] == "Daily")
                                            {{ "Kali/Hari" }}
                                        @endif
                                    </td>
                                    <td>{{ $data->qty }}</td>
                                    <td><a href="" class="btn btn-sm btn-info">Detail</a></td>
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
