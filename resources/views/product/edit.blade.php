<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Update Product</title>

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
                                <h1>Product</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Product</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>
                <!-- <button style="float: right" class="btn btn-primary text-left mx-auto" id="addShopkeeperButton" onclick="toggleForm()">Add Shopkeeper</button> -->

                <!-- <h1>Edit shopkeeper</h1> -->

                <form action="{{ url('products', $product->id) }}" method="POST" id="ProductForm"
                     enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="container-fluid">
                        <div class="row">
                            @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                            @elseif(Session::has('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Update Product</h3>
                                        <button type="button" class="close" onclick="cancelForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Product
                                                Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="inputName" name="name"
                                                    value="{{ $product->name }}" class="form-control">
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label for="inputImage" class="col-sm-2 required">Current Product
                                                Image</label>
                                            <div class="col-sm-4">
                                                @if ($product->image)
                                                <img src="{{ asset('images/product_images/' . $product->image) }}"
                                                    width="95px" alt="">
                                                @else
                                                <p>No image available</p>
                                                @endif
                                            </div>
                                            <label for="inputImage" class="col-sm-2 required">Update Product
                                                Image</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="image" id="inputImage" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Product
                                                Price</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputPrice" name="price"
                                                    value="{{ $product->price }}" class="form-control">
                                            </div>
                                            <label for="inputProjectLeader"
                                                class="col-sm-2 col-form-label required">Product
                                                Category</label>
                                            <div class="col-sm-4">
                                                <div class="custom-file">
                                                    <select id="inputCategory" name="category_id" class="form-control"
                                                        required>
                                                        <option value="" disabled>Select one</option>
                                                        @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" {{ $category->id ==
                                                            $product->category_id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDescription"
                                                class="col-sm-2 col-form-label required">Product
                                                Description</label>
                                            <div class="col-sm-10">
                                                <textarea id="inputDescription" name="description" class="form-control"
                                                    rows="1">{{ $product->description }}</textarea>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- /.card-body -->

                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="button" onclick="cancelForm()" class="btn btn-default"
                                            style="background-color: red; color: white;">
                                            <i class="fas fa-times"></i> Close
                                        </button>
                                        <button type="submit" onclick="addShopkeeper()" class="btn btn-primary ml-2">
                                            <i class="fas fa-plus"></i> Update Product
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
                var form = document.getElementById("ProductForm");
                if (form.style.display === "none") {
                    form.style.display = "block";
                } else {
                    form.style.display = "none";
                }
            }

            function cancelForm() {
                var form = document.getElementById("ProductForm");
                form.style.display = "none";
                window.location.href = "{{ route('product.index') }}";
            }
            </script>
    </body>

</html>
