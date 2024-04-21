<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Add ShopKeeper</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.header')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Shopkeeper</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Shopkeeper</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <style>
                .required::before {
                    content: "*";
                    color: red;
                    margin-right: 5px;
                }
            </style>
            @if ($errors->any())
                <div id="error-alert" class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url('shopkeepers', $shopkeeper->id) }}" method="POST" id="ShopkeeperForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Shopkeeper</h3>
                                    <button type="button" class="close" onclick="cancelForm()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label required">Shopkeeper
                                            Name</label>
                                        <div class="col-sm-4">
                                            <input name='inputName' type="text" id="inputName" class="form-control"
                                                value="{{ $shopkeeper->name }}" required>
                                        </div>
                                        <label for="inputShopName" class="col-sm-2 col-form-label required">Shop
                                            Name</label>
                                        <div class="col-sm-4">
                                            <input name="inputShopName" type="text" id="inputShopName"
                                                class="form-control" value="{{ $shopkeeper->shop_name }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label required">Email</label>
                                        <div class="col-sm-4">
                                            <input name="inputEmail" type="email" id="inputEmail" class="form-control"
                                                value="{{ $shopkeeper->email }}" required>
                                        </div>
                                        <label for="inputPhoneNumber" class="col-sm-2 col-form-label required">Phone
                                            Number</label>
                                        <div class="col-sm-4">
                                            <input name="inputPhoneNumber" type="tel" id="inputPhoneNumber"
                                                class="form-control" value="{{ $shopkeeper->phone_number }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputAddress"
                                            class="col-sm-2 col-form-label required">Address</label>
                                        <div class="col-sm-4">
                                            <textarea name="inputAddress" id="inputAddress" class="form-control" rows="2" required>{{ $shopkeeper->address }}</textarea>
                                        </div>
                                        <label for="inputImage" class="col-sm-2">Current Logo</label>
                                        <div class="col-sm-4">
                                            @if ($shopkeeper->image)
                                                <img src="{{ asset('images/shopkeeper_images/' . $shopkeeper->image) }}"
                                                    width="95px" alt="">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputGST" class="col-sm-2 col-form-label required">GST
                                            Number</label>
                                        <div class="col-sm-4">
                                            <input name="inputGST" type="text" id="inputGST"
                                                class="form-control" value="{{ $shopkeeper->gst }}" required>
                                        </div>
                                        <label for="inputImage" class="col-sm-2">Update Logo</label>
                                        <div class="col-sm-4">
                                            <input type="file" name="image" id="inputProjectLeader"
                                                class="form-control">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="button" onclick="cancelForm()" class="btn btn-default"
                                        style="background-color: red; color: white;">
                                        <i class="fas fa-times"></i> Close
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-2">
                                        <i class="fas fa-plus"></i> Update Shopkeeper
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
    <script>
        function toggleForm() {
            var form = document.getElementById("ShopkeeperForm");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }

        function addCategory() {
            // code to add Category goes here
            cancelForm();
        }

        function cancelForm() {
        var form = document.getElementById("ShopkeeperForm");
        form.style.display = "none";
        window.location.href = "{{ route('shopkeepers.index') }}";
    }
    </script>
</body>

</html>
