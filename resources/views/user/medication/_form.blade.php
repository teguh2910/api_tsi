<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-3">Kit Code</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="code" value="{{ old('code') }}">
            @error('code')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Kit Name</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="name" value="{{ old('name') }}">
            @error('name')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Owner</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="owner" value="{{ old('owner') }}">
            @error('owner')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Distributor</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="distributor" value="{{ old('distributor') }}">
            @error('distributor')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>
