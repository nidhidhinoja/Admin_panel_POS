<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Update Category</title>

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
                            <h1>Update Category</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Category</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- <button style="float: right" class="btn btn-primary text-left mx-auto" id="addShopkeeperButton" onclick="toggleForm()">Add Shopkeeper</button> -->

            <!-- <h1>Edit shopkeeper</h1> -->

            <form action="{{ url('categories', $category->id) }}" method="POST" id="CategoryForm"
                enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="container-fluid">
                    @if (Session::has('success'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Update Category</h3>
                                    <button type="button" class="close" onclick="cancelForm()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Category Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="name" id="inputName"
                                                value="{{ $category->name }}" class="form-control">
                                        </div>
                                        <label for="inputProjectLeader" class="col-sm-2">Current Category
                                            Image</label>
                                        <div class="col-sm-4">
                                            @if ($category->image)
                                                <img src="{{ asset('images/category_images/' . $category->image) }}"
                                                    width="95px" alt="">
                                            @else
                                                <p>No image available</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputDescription" class="col-sm-2 col-form-label">Category
                                            Description</label>
                                        <div class="col-sm-4">
                                            <textarea id="inputDescription" name="description" class="form-control" rows="2">{{ $category->description }}</textarea>
                                        </div>
                                        <label for="inputProjectLeader" class="col-sm-2">Update Category
                                            Image</label>
                                        <div class="col-sm-4">
                                            <input type="file" name="image" id="inputProjectLeader"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputUnit" class="col-sm-2 col-form-label required">Unit</label>
                                        <div class="col-sm-4">
                                            <select name="unit" id="inputUnit" class="form-control" required>
                                                <option value="" disabled>Select one</option>
                                                <option value="piece" {{ $category->unit == 'piece' ? 'selected' : '' }}>Piece</option>
                                                <option value="kilogram" {{ $category->unit == 'kilogram' ? 'selected' : '' }}>Kilogram (kg)</option>
                                                <option value="litre" {{ $category->unit == 'litre' ? 'selected' : '' }}>Litres (l)</option>
                                                <option value="gram" {{ $category->unit == 'gram' ? 'selected' : '' }}>Gram (g)</option>
                                                <option value="pound" {{ $category->unit == 'pound' ? 'selected' : '' }}>Pound (lb)</option>
                                                <!-- Add more options as needed -->
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer d-flex justify-content-end">
                                    <button type="button" onclick="cancelForm()" class="btn btn-default"
                                        style="background-color: red; color: white;">
                                        <i class="fas fa-times"></i> Close
                                    </button>
                                    <button type="submit" class="btn btn-primary ml-2">
                                        <i class="fas fa-plus"></i> Update Category
                                    </button>

                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
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
            var form = document.getElementById("CategoryForm");
            if (form.style.display === "none") {
                form.style.display = "block";
            } else {
                form.style.display = "none";
            }
        }



        function cancelForm() {
        var form = document.getElementById("CategoryForm");
        form.style.display = "none";
        window.location.href = "{{ route('categories.index') }}";
    }
    </script>
</body>

</html>
