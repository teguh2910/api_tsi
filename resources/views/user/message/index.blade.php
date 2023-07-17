@extends('layout.user')
@section('content')

    <section class="content">
            <div class="row">
                @include('admin.message.menu-message')
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Video Conference</h3>
                        </div>
                        <div class="card-body p-2">

                        </div>
                        <div class="card-footer">
                            <div class="card">
                                <div class="card-header">
                                    <input type="text" class="form-control">
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-sm btn-success">Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
