<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-4">Grade</label>
        <div class="col-sm-8">
            <input type="number" class="form-control" name="grade" value="{{ old('grade', $education->grade) }}">
            @error('grade')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-4">Singkatan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="kode" value="{{ old('kode', $education->kode) }}">
            @error('kode')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-4">Nama Pendidikan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="pendidikan" value="{{ old('pendidikan', $education->pendidikan) }}">
            @error('pendidikan')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-4">Level Pendidikan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="level" value="{{ old('level', $education->level) }}">
            @error('level')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-4">Jenis Pendidikan</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" name="jenis" value="{{ old('jenis', $education->jenis) }}">
            @error('jenis')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
</div>
