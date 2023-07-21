@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-12">
                @if(\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {!! \Session::get('success') !!}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card mt-5">
                                <div class="card-header">
                                    <form>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label mt-2">No HP</label>
                                            <div class="col-sm-6 mt-2">
                                                <input type="text" class="form-control" name="nomor_telepon" value="@if(isset($_GET['nomor_telepon'])) {{ $_GET['nomor_telepon'] }} @endif">
                                            </div>
                                            <div class="col-sm-3 mt-2">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-body">
                                    @if(! empty($pasien))
                                        <form action="{{ route('pasien.tbc.search.counselor', ['id'=> $counselor->id]) }}" method="post">
                                            @csrf
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Nama</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="id_pasien">
                                                        <option value="{{ $pasien->id }}">{{ $pasien->nama['nama_depan'] }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">
                                                    <button type="submit" class="btn btn-primary">Save</button>
                                                    <a href="{{ route('pasien.tbc.mine') }}" class="btn btn-danger">My Patient</a>
                                                </label>

                                            </div>

                                        </form>
                                    @elseif(isset($_GET['nomor_telepon']))
                                        {{ "Pasien tidak ditemukan" }}
                                    @else
                                        {{ "Search Patien" }}
                                    @endif
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
