<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-2">Nama Agama</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" value="{{ old('name', $religion->name) }}">
            @error('name')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-2">Kitab Suci</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="kitab_suci" value="{{ old('kitab_suci', $religion->kitab_suci) }}">
            @error('kitab_suci')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>


</div>
