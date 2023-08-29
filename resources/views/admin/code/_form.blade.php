<div class="card-body">
    <div class="row mb-1">
        <label class="col-sm-3">Code</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="code" value="{{ $code->code, old('code') }}">
            @error('code')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">System</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="system" value="{{ $code->system, old('system') }}">
            @error('system')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Display</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" name="display" value="{{ $code->display, old('display') }}">
            @error('display')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>
    <div class="row mb-1">
        <label class="col-sm-3">Category</label>
        <div class="col-sm-9">
            <select class="form-control" name="category">

                @foreach($category as $list)
                    <option value="{{ $list->code }}"
                    @if($code->category != null)
                        @if($code->category['code'] == $list->code) {{ "selected" }} @endif
                    @endif>{{ $list->display }}
                    </option>
                @endforeach
            </select>
            @error('display')
            <small class="text-danger">{{$message}}</small>
            @enderror
        </div>
    </div>


</div>
