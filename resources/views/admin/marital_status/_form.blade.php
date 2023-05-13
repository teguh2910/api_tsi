<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-2">System</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="system" value="{{ old('system', $marital_status->system) }}">
            @error('system')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-2">Marital Status</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="marital_status" value="{{ old('marital_status', $marital_status->display) }}">
            @error('marital_status')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-2">Code</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="code" value="{{ old('code', $marital_status->code) }}">
            @error('code')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-2">Deskripsi</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="description" value="{{ old('description', $marital_status->definition) }}">
            @error('description')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>

</div>
