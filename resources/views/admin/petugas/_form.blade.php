<div class="card-body">
    <div class="row mb-1">

        <label class="col-sm-3">User</label>
        <div class="col-sm-9">
            <select class="form-control" required name="id_user">
                <option value=''>---pilih---</option>
                @foreach($users as $item)
                <option value='{{ $item->id }}'>{{ $item->nama['nama_depan']." ". $item->nama['nama_belakang']}}</option>
                @endforeach
            </select>
            @error('id_user')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Organisasi</label>
        <div class="col-sm-9">
            <select class="form-control" required name="id_organisation">
                <option value=''>---pilih---</option>
                @foreach($organisations as $item)
                    <option value='{{ $item->_id }}'>{{ $item->name}}</option>
                @endforeach
            </select>
            @error('tanggal_mulai')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>

    <div class="row mb-1">
        <label class="col-sm-3">Sebagai</label>
        <div class="col-sm-9">
            <select class="form-control" name="role" required>
                <option value=''>---pilih---</option>
                <option value="nakes">Petugas Kesehatan</option>
                <option value="kader">Kader Kesehatan</option>
                <option value="marketing">Marketing</option>
            </select>
        </div>
    </div>

</div>
