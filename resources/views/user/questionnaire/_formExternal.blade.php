<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-3">Judul</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="judul" value="{{ old('judul') }}">
            @error('judul')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">URL</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="url" value="{{ old('url') }}">
            @error('url')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Tanggal Mulai</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}">
            @error('tanggal_mulai')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Tanggal Selesai</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}">
            @error('tanggal_selesai')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Status</label>
        <div class="col-sm-9">
            <select class="form-control" name="status">
                <option value="draft">Draft</option>
                <option value="publish">Publish</option>
            </select>
        </div>
    </div>

</div>
