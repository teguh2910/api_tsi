<div class="card card-primary card-outline">
    <div class="card-header">
        <h3 class="card-title">Video Conference</h3>
    </div>
    <div class="card-body bg-secondary">
        <form action="{{ route('meeting.store_by_counselor') }}" method="post">
            @csrf
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Date Start</label>
                <div class="col-sm-5">
                    <input type="date" class="form-control" name="date_start">
                </div>
                <div class="col-sm-4">
                    <input type="time" class="form-control" name="time_start">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pasien</label>
                <div class="col-sm-9">
                    <select class="form-control" name="attendee">
                        <option>---Select---</option>
                        @foreach($users as $data)
                            <option value="{{ $data->id }}">{{ $data->nama['nama_depan'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9 text-right">
                    <button type="submit" class="btn btn-warning">Save</button>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <b>Meeting Hari Ini</b>
    </div>
    <div class="card-body bg-info">
        <table class="table table-sm">
            <thead>
            <th>#</th>
            <th>Topic</th>
            <th>Time</th>
            <th>Action</th>
            </thead>
            <tbody>
            @foreach($counselor_meeting as $meeting)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $meeting->topic }}</td>
                    <td>{{ date('H:i', $meeting->time) }}</td>

                    <td><a href="{{ route('meeting.show', ['id'=>$meeting->id]) }}" class="btn btn-sm btn-warning">Detail</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
