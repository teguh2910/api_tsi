<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-3">Nama Room </label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="room_name" value="{{ $zoom_master->room_name, old('room_name') }}">
            @error('room_name')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">ID Meeting & Passcode</label>
        <div class="col-sm-5">
            <input type="number" class="form-control" name="id_meeting" value="{{ $zoom_master->id_meeting, old('id_meeting') }}">
            @error('id_meeting')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
        <div class="col-sm-4">
            <input type="number" class="form-control" name="pass_code" value="{{ $zoom_master->pass_code, old('pass_code') }}">
            @error('pass_code')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">URL</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="url" value="{{ $zoom_master->url, old('url') }}">
            @error('url')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Kadaluarsa</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" name="expired" value="{{ $zoom_master->expired, old('expired') }}">
            @error('expired')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Status</label>
        <div class="col-sm-9">
            <select class="form-control" name="status">
                <option value="open">Open</option>
                <option value="block">Block</option>
            </select>
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Counselor</label>
        <div class="col-sm-9">
            <select class="form-control" name="counselor">
                <option>-----Pilih-----</option>
                @foreach($counselors as $user)
                    <option value="{{ $user->_id}}" @if($zoom_master->counselor == $user->_id) {{ "selected" }} @endif>{{ $user->nama['nama_depan'] }} {{ $user->nama['nama_belakang'] }}</option>
                @endforeach


            </select>
        </div>
    </div>

</div>
