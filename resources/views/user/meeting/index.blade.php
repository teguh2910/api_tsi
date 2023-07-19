@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">

            <div class="col-md-3">
                @include('user.message.menu-message')
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Meetings</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Topic</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="topic">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Date Start</label>
                            <div class="col-sm-5">
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input type="time" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Konselor</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="host">
                                    <option>---Select---</option>
                                    <option value="123">KOnselor 1</option>
                                    <option value="123">KOnselor 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
