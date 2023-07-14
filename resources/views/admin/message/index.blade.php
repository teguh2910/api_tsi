@extends('layout.user')
@section('content')

    <section class="content">
            <div class="row">
                @include('admin.message.menu-message')
                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Inbox</h3>
                        </div>
                        <div class="card-body p-2">
                            <?php
                                $x= 1;
                                ?>
                            @while($x < 10 )
                            <div class="row">
                                <div class="col-md-9 mr-auto">
                                    <div class="col-auto">
                                        <div class="card">
                                            <div class="card-body">
                                                pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat pesan yang baik adalah pesan yang dapat diterima akal sehat
                                            </div>
                                            <div class="card-footer">
                                                <small>Time : 2023-06-12 12:12:03</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto ml-auto">
                                    <div class="col-md-9">
                                        <div class="card">
                                            <div class="card-body bg-secondary">
                                                pesan yang baik adalah pesan yang dapat diterima akal sehat
                                                <p class="text-right">
                                                <small>Time : 2023-06-12 12:12:03</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <?php
                                    $x++
                                    ?>
                            @endwhile


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
