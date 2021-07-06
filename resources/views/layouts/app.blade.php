<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', $settings ? $settings->name : 'Welcome') }}</title> --}}
    <title>{{ $settings ? $settings->name : 'Welcome' }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{ asset('plugins/fontawesome-free/css/all.min.css') }}>
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href={{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}>
    <!-- iCheck -->
    <link rel="stylesheet" href={{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}>
    <!-- JQVMap -->
    <link rel="stylesheet" href={{ asset('plugins/jqvmap/jqvmap.min.css') }}>
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href={{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}>
    <!-- Daterange picker -->
    <link rel="stylesheet" href={{ asset('plugins/daterangepicker/daterangepicker.css') }}>
    <!-- summernote -->
    <link rel="stylesheet" href={{ asset('plugins/summernote/summernote-bs4.css') }}>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    {{ $headerContent ?? '' }}
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('css/adminlte.min.css') }}>
    <!-- Custom style for RTL -->
    <link rel="stylesheet" href={{ asset('css/custom.css') }}>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
    <div class="wrapper">

        @include('layouts.navbar')
        @include('layouts.sidebar')

        <!-- Page Content -->
        <main class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header bg-white shadow">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <div class="m-0 text-dark text-right">
                                {{ $headerTitle ?? '' }}
                            </div>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <div class="position-relative mt-1">
                <x-custom-message variant="danger" :msg="session('errorMsg')"></x-custom-message>
                <x-custom-message variant="success" :msg="session('successMsg')"></x-custom-message>
                <x-custom-message variant="danger" :msg="$errors->any() ? $errors->all()[0] : ''">
                </x-custom-message>
            </div>

            <!-- Main content -->
            <section class="content pt-5">
                <div class="container-fluid">
                    {{ $slot }}
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </main>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src={{ asset('js/app.js') }}></script>
    <script src={{ asset('js/index.js') }}></script>

    <script src={{ asset('plugins/jquery/jquery.min.js') }}></script>
    <!-- jQuery UI 1.11.4 -->
    <script src={{ asset('plugins/jquery-ui/jquery-ui.min.js') }}></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 rtl -->
    <script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src={{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}></script>
    <!-- ChartJS -->
    <script src={{ asset('plugins/chart.js/Chart.min.js') }}></script>
    <!-- Sparkline -->
    <script src={{ asset('plugins/sparklines/sparkline.js') }}></script>
    <!-- JQVMap -->
    <script src={{ asset('plugins/jqvmap/jquery.vmap.min.js') }}></script>
    <script src={{ asset('plugins/jqvmap/maps/jquery.vmap.world.js') }}></script>
    <!-- jQuery Knob Chart -->
    <script src={{ asset('plugins/jquery-knob/jquery.knob.min.js') }}></script>
    <!-- daterangepicker -->
    <script src={{ asset('plugins/moment/moment.min.js') }}></script>
    <script src={{ asset('plugins/daterangepicker/daterangepicker.js') }}></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src={{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}></script>
    <!-- Summernote -->
    <script src={{ asset('plugins/summernote/summernote-bs4.min.js') }}></script>
    <!-- overlayScrollbars -->
    <script src={{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}></script>
    <!-- DataTables -->
    <script src={{ asset('plugins/read-excel-file.min.js') }}></script>
    <script src={{ asset('plugins/datatables/jquery.dataTables.js') }}></script>
    <script src={{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}></script>
    <script src={{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}></script>
    <script src={{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}></script>
    <script src={{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}></script>
    <script src={{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}></script>
    <script src={{ asset('plugins/jszip/jszip.min.js') }}></script>
    <script src={{ asset('plugins/pdfmake/pdfmake.min.js') }}></script>
    <script src={{ asset('plugins/pdfmake/vfs_fonts.js') }}></script>
    <script src={{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}></script>
    <script src={{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}></script>
    <script src={{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}></script>
    <script>
        function dataTablesFor(selector) {
            $('#' + selector).DataTable({
                'stateSave': true,
                'dom': 'lBfrtip',
                'language': {
                    search: '',
                    searchPlaceholder: "البحث عن",
                },
                buttons: [{
                        "extend": 'colvis',
                        "text": "<i class='fas fa-eye'></i>",
                        "title": '',
                        "collectionLayout": 'fixed two-column',
                        "className": "btn-sm btn-outline-dark",
                        "bom": "true",
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                        }
                    },
                    {
                        "extend": "csv",
                        "text": "<i class='fas fa-file-csv'></i>",
                        "title": '',
                        "filename": "Report Name",
                        "className": "btn-sm btn-outline-success",
                        "charset": "utf-8",
                        "bom": "true",
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                        }
                    },
                    {
                        "extend": "excel",
                        "text": "<i class='fas fa-file-excel'></i>",
                        "title": '',
                        "filename": "Report Name",
                        "className": "btn-sm btn-outline-danger",
                        "charset": "utf-8",
                        "bom": "true",
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                        },
                        exportOptions: {
                            columns: [':visible']
                        }
                    },
                    {
                        "extend": "print",
                        "text": "<i class='fas fa-file-pdf'></i>",
                        "title": '',
                        "filename": "Report Name",
                        "className": "btn-sm btn-outline-primary",
                        "charset": "utf-8",
                        "bom": "true",
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                        },
                        exportOptions: {
                            columns: [':visible']
                        }
                    },
                    {
                        "extend": "copy",
                        "text": "<i class='fas fa-copy'></i>",
                        "title": '',
                        "filename": "Report Name",
                        "className": "btn-sm btn-outline-info",
                        "charset": "utf-8",
                        "bom": "true",
                        init: function(api, node, config) {
                            $(node).removeClass("btn-secondary");
                        },
                        exportOptions: {
                            columns: [':visible']
                        }
                    }
                ],
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": false,
            }).buttons().container().appendTo('#' + selector + '_wrapper .col-md-6:eq(0)');

            $("#" + selector + "_next a").text("التالي");
            $("#" + selector + "_previous a").text("السابق");

            $("#" + selector + "_next a").click(() => {
                $("#" + selector + "_next a").text("التالي");
                $("#" + selector + "_previous a").text("السابق");
            })
            $("#" + selector + "_previous a").click(() => {
                $("#" + selector + "_next a").text("التالي");
                $("#" + selector + "_previous a").text("السابق");
            })
        }

    </script>
    {{ $scripts ?? '' }}
    <!-- AdminLTE App -->
    <script src={{ asset('js/adminlte.js') }}></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src={{ asset('js/dashboard.js') }}></script>
    <!-- AdminLTE for demo purposes -->
    <script src={{ asset('js/demo.js') }}></script>
</body>

</html>
