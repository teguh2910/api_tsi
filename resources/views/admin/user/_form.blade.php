<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success"><b>Identitas {{ $users->nama }}</b></div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>Nama Depan</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nama_depan" value="{{ old('nama_depan', $users->nama_depan) }}">
                                @error('nama_depan')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Nama Belakang</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nama_belakang" value="{{ old('nama_belakang', $users->nama_belakang) }}">
                                @error('nama_belakang')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Gelar Depan</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="gelar_depan" value="{{ old('gelar_depan', $users->gelar_depan)  }}">
                                @error('gelar_depan')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Gelar Belakang</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="gelar_belakang" value="{{ old('gelar_belakang', $users->gelar_belakang) }}">
                                @error('gelar_belakang')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="nik" value="{{ old('nik', $users->nik) }}">
                                @error('nik')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>:</td>
                            <td>
                                <select name="gender" class="form-control form-control-sm">
                                    <option value="">---pilih---</option>
                                    <option value="male" @if($users->gender == "male" || old('gender') == "male") selected @endif>Male</option>
                                    <option value="female" @if($users->gender == "female" || old('gender') == "female") selected @endif>Female</option>
                                </select>
                                @error('gender')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>

                        </tr>
                        <tr>
                            <th>Warga Negara</th>
                            <td>:</td>
                            <td>
                                <select name="warga_negara" class="form-control form-control-sm">
                                    <option value="">---pilih---</option>
                                    <option value="wni" @if($users->warga_negara == "wni" || old('warga_negara') == "wni") selected @endif>WNI</option>
                                    <option value="wna" @if($users->warga_negara == "wna" || old('warga_negara') == "wna") selected @endif>WNA</option>
                                </select>
                                @error('gender')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>

                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success"><b>Identitas</b></div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th>Tempat Lahir</th>
                            <td>:</td>
                            <td>
                                <input type="text" class="form-control form-control-sm" name="place_birth" value="{{ old('place_birth', $users->place_birth ) }}">
                                @error('place_birth')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>:</td>
                            <td>
                                <input type="date" class="form-control form-control-sm" name="birth_date" value="{{ old('birth_date', $users->birth_date) }}">
                                @error('birth_date')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>Status Pernikahan</th>
                            <td>:</td>
                            <td>
                                <select class="form-control form-control-sm" name="status_menikah">
                                    <option value="">---pilih---</option>
                                    @foreach($marital_status as $nikah)
                                        <option value="{{ $nikah->code }}">{{ $nikah->code }} {{ $nikah->display }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Agama</th>
                            <td>:</td>
                            <td>
                                <select class="form-control form-control-sm" name="status_menikah">
                                    <option value="">---pilih---</option>
                                    @foreach($agama as $data)
                                        <option value="{{ $data->_id }}">{{ $data->name }}</option>
                                    @endforeach
                                </select>
                                @error('agama')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Provinsi</th>
                            <td>:</td>
                            <td>
                                <select class="form-control form-control-sm" name="status_menikah">
                                    <option value="">---pilih---</option>
                                    @foreach($provinsi as $data)
                                        <option value="{{ $data->code }}">{{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>:</td>
                            <td>
                                <input type="number" class="form-control form-control-sm" name="nomor_telepon" value="{{ old('nomor_telepon', $users->nomor_telepon ) }}">
                                @error('nomor_telepon')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>:</td>
                            <td>
                                <input type="email" class="form-control form-control-sm" name="email" value="{{ old('email', $users->email) }}">
                                @error('email')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>



    </div>




</div>
