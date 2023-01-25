<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-2">Nama Suku</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="suku" value="{{ old('system', $ethnic->suku) }}">
            @error('suku')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>
