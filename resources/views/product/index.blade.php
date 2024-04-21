<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Project Add</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="path/to/adminlte.css">
    <script src="path/to/adminlte.js"></script>

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.css')

</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
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
            <!-- <button style="float: right" class="btn btn-primary text-left mx-auto" id="addProductButton" onclick="toggleForm()">Add Product</button> -->
            <section class="content">
                <style>
                    .required::before {
                        content: "*";
                        color: red;
                        margin-right: 5px;
                    }
                </style>

                <form action="{{ route('products.store') }}" method="POST" id="ProductForm" style="display: none;"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Product</h3>
                                        <button type="button" class="close" onclick="cancelForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Product
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputName" name="name"
                                                    class="form-control">
                                            </div>
                                            <!-- </div>
                                            <div class="form-group row"> -->
                                            <label for="inputImage" class="col-sm-2 required">Product Image</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="image" id="inputProjectLeader"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Product
                                                Price(per unit)</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputPrice" name="price"
                                                    class="form-control">
                                            </div>
                                            <!-- </div>
                                            <div class="form-group row"> -->
                                            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                    <label for="inputCategory" class="col-sm-2 col-form-label">Category</label>
                                                    <div class="col-sm-4">
                                                        <div class="custom-file">
                                                            <select id="inputCategory" name="category_id" class="form-control" required>
                                                                <option value="" disabled selected>Select one</option>
                                                                @foreach ($categories as $category)
                                                                        @if (auth()->user()->role == 1)
                                                                            @foreach ($shopkeepers as $shopkeeper)
                                                                            @if ($category->shop_id == $shopkeeper->id)
                                                                                <option value="{{ $category->id }}">{{ $category->name }} -> {{ $shopkeeper->name }}</option>
                                                                            @endif
                                                                            @endforeach
                                                                        @else
                                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                        @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                            </form>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDescription"
                                                class="col-sm-2 col-form-label required">Product Description</label>
                                            <div class="col-sm-10">
                                                <textarea id="inputDescription" name="description" class="form-control" rows="1"></textarea>
                                            </div>
                                        </div>

                                    </div>


                                    <!-- /.card-body -->

                                    <div class="card-footer d-flex justify-content-end">
                                        <button type="button" onclick="cancelForm()" class="btn btn-default"
                                            style="background-color: red; color: white;">
                                            <i class="fas fa-times"></i> Close
                                        </button>
                                        <button type="submit" onclick="addShopkeeper()"
                                            class="btn btn-primary ml-2">
                                            <i class="fas fa-plus"></i> Add Product
                                        </button>
                                    </div>
                                    {{-- /.card-footer --}}
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </form>

            </section>

            <script>
                function toggleForm() {
                    var form = document.getElementById("ProductForm");
                    if (form.style.display === "none") {
                        form.style.display = "block";
                    } else {
                        form.style.display = "none";
                    }
                }

                function addProduct() {
                    // code to add Product goes here
                    cancelForm();
                }

                function cancelForm() {
                    var form = document.getElementById("ProductForm");
                    form.style.display = "none";
                }
            </script>

            <section class="content">
                <style>
                    .visually-hidden {
                        position: absolute !important;
                        clip: rect(1px, 1px, 1px, 1px) !important;
                        padding: 0 !important;
                        border: 0 !important;
                        height: 1px !important;
                        width: 1px !important;
                        overflow: hidden !important;
                    }
                </style>
                <div class="container-fluid">
                    @if (Session::has('success'))
                        <div id="success-alert" class="alert alert-success" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @elseif(Session::has('error'))
                        <div id="error-alert" class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <button style="float: right" class="btn btn-primary text-left mx-auto"
                                        id="addProductButton" onclick="toggleForm()">Add Product</button>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th> <!-- Serial number column -->
                                                <th class="hidden visually-hidden" style="display: none;">time</th>
                                                <th>Product Name</th>
                                                <th>Product Image</th>
                                                <th>Product Price</th>
                                                @if (Auth::user()->role == 1)
                                                    <th>Shopkeeper Name</th>
                                                @endif
                                                <th>Category</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $product)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td> <!-- Display serial number -->
                                                    <td class="hidden visually-hidden" style="display: none;">
                                                        {{ $product->created_at }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>
                                                        <img class="category-image"
                                                            src="{{ asset('images/product_images/' . $product->image) }}"
                                                            alt="">
                                                    </td>
                                                    <td>₹ {{ $product->price }} per {{ $product->category->unit }}
                                                    </td>
                                                    @if (Auth::user()->role == 1)
                                                        @foreach ($shopkeepers as $shopkeeper)
                                                            @if ($product->category->shop_id == $shopkeeper->id)
                                                                <td>{{ $shopkeeper->name }}</td>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                <td>{{ $product->category->name }}</td>
                                                <td>{{ $product->description }}</td>
                                                    <td>
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline" id="deleteForm">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete()">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th> <!-- Serial number column -->
                                            <th class="hidden visually-hidden" style="display: none;"></th>
                                            <th>Product Name</th>
                                            <th>Product Image</th>
                                            <th>Product Price(per unit)</th>
                                            @if (Auth::user()->role == 1)
                                                <th>Shopkeeper Name</th>
                                            @endif
                                            <th>Category</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
        </div>
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
        reserved.
    </footer>

    <!-- jQuery -->
    @include('layouts.js')
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product?')) {
                // User confirmed, proceed with the form submission
                document.getElementById('deleteForm').submit();
            }
        }
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "order": [], // Disable initial sorting
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
</body>

</html>
