<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="icon" href="https://ppni.or.id/simk/image/LOGO-PPNI.png">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- DataTables -->
    <link rel="stylesheet"
          href="{{ asset('css/app.css') }}">
    <link rel="stylesheet"
          href="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
          href="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet"
          href="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://rspon.net/ppni/assets/AdminLTE/dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

    @include('layout.menu.user.navbar')
    <!-- /.navbar -->
    <!-- Main Sidebar Container -->
    @include('layout.menu.user.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ $title }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">{{ $class }}</a></li>
                            <li class="breadcrumb-item active">{{ $sub_class }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        @yield('content')
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 2.0.0    </div>
        <strong>Copyright &copy; 2014-2022 <a href="{{ route('home') }}">{{ env('APP_NAME') }}</a>.</strong> All rights reserved.
    </footer>

</div>    <!-- ./wrapper -->

<!-- jQuery -->
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js">
</script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js">
</script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/jszip/jszip.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/pdfmake/pdfmake.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/pdfmake/vfs_fonts.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="https://rspon.net/ppni/assets/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="https://rspon.net/ppni/assets/AdminLTE/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="https://rspon.net/ppni/assets/AdminLTE/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": true, "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            "buttons": ["excel", "pdf"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
</body>

</html>
