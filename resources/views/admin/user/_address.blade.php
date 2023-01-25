<div class="col-md-6">
    <div class="card">
        <div class="card-header bg-success"><b>Alamat</b></div>
        <div class="card-body">
            <table class="table table-sm table-striped">
                <tr>
                    <th>Jenis Alamat</th>
                    <td>:</td>
                    <td>
                        <select class="form-control form-control-sm" name="jenis_alamat">
                            <option value="">---pilih---</option>
                            <option value="rumah">Rumah</option>
                            <option value="kontrakan">Kontrakan Sementara</option>
                            <option value="kantor">Kantor</option>

                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Provinsi</th>
                    <td>:</td>
                    <td>
                        <select class="form-control form-control-sm" name="provinsi" required>
                            <option value="">---pilih---</option>
                            @foreach($provinsi as $prov)
                                <option value="{{ $prov->id_prov }}" @if($prov->id_prov == $users->provinsi || $prov->id_prov == old('provinsi')) selected @endif>{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                    </td>

                </tr>
                <tr>
                    <th>Kota</th>
                    <td>:</td>
                    <td>
                        <select class="form-control form-control-sm" name="kota">
                            <option value="">---pilih---</option>
                            @foreach($provinsi as $prov)
                                <option value="{{ $prov->id_prov }}">{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Kecamatan</th>
                    <td>:</td>
                    <td>
                        <select class="form-control form-control-sm" name="kecamatan">
                            <option value="">---pilih---</option>
                            @foreach($provinsi as $prov)
                                <option value="{{ $prov->id_prov }}">{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Kelurahan</th>
                    <td>:</td>
                    <td>
                        <select class="form-control form-control-sm" name="kelurahan">
                            <option value="">---pilih---</option>
                            @foreach($provinsi as $prov)
                                <option value="{{ $prov->id_prov }}">{{ $prov->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>RT</th>
                    <td>:</td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="rt" value="{{ old('rt', $users->rt) }}">
                        @error('rt')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>RW</th>
                    <td>:</td>
                    <td>
                        <input type="text" class="form-control form-control-sm" name="rw" value="{{ old('rw', $users->rw) }}">
                        @error('rw')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <th>Kode Pos</th>
                    <td>:</td>
                    <td>
                        <input type="number" name="kode_pos" class="form-control form-control-sm" value="{{ $users->address['kode_pos'] }}">

                    </td>
                </tr>
                <tr>
                    <th>Jalan/Building</th>
                    <td>:</td>
                    <td>
                        <input type="text" name="street" class="form-control form-control-sm" value="{{ $users->address['street'] }}">
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>
