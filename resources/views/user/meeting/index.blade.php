@extends('layout.user')
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Video Conference</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle text-warning"></i> Hari Ini
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle text-danger"></i>
                                    Akan Datang
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle text-primary"></i>
                                    Yang Lalu
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
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
