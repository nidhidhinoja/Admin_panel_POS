<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Add Category</title>

    <!-- Google Font: Source Sans Pro -->
    @include('layouts.css')
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row mb-2">

                        <div class="col-sm-6">
                            <h1>Category</h1>
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
            <!-- <button style="float: right" class="btn btn-primary text-left mx-auto" id="addCategoryButton" onclick="toggleForm()">Add Category</button> -->
            <section class="content">
                <form action="{{ route('categories.store') }}" method="POST" id="CategoryForm" style="display: none; "
                    enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Category</h3>
                                        <button type="button" class="close" onclick="cancelForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Category
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="name" id="inputName"
                                                    class="form-control">
                                            </div>
                                            <label for="inputProjectLeader" class="col-sm-2">Category Image</label>
                                            <div class="col-sm-4">
                                                <input type="file" name="image" id="inputProjectLeader"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputUnit" class="col-sm-2 col-form-label required">Unit</label>
                                            <div class="col-sm-4 ">
                                                <select name="unit" id="inputUnit" class="form-control">
                                                    <option value="" disabled selected>Select one</option>
                                                    <option value="piece">Piece</option>
                                                    <option value="kilogram">Kilogram (kg)</option>
                                                    <option value="litre">litres (l)</option>
                                                    <option value="gram">Gram (g)</option>
                                                    <option value="pound">Pound (lb)</option>
                                                    <!-- Add more options as needed -->
                                                </select>
                                            </div>
                                            @if (Auth::user()->role == 1)
                                                    <label for="inputShopkeeper" class="col-sm-2 col-form-label required">Shopkeeper</label>
                                                    <div class="col-sm-4">
                                                        <select name="shopkeeper_id" id="inputShopkeeper" class="form-control">
                                                            <option value="" disabled selected>Select shopkeeper</option>
                                                            @foreach($shopkeepers as $shopkeeper)
                                                                <option value="{{ $shopkeeper->id }}">{{ $shopkeeper->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                            @endif
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputDescription"
                                                class="col-sm-2 col-form-label required">Category
                                                Description</label>
                                            <div class="col-sm-4">
                                                <textarea id="inputDescription" name="description" class="form-control" rows="3"></textarea>
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
                                            <i class="fas fa-plus"></i> Add Category
                                        </button>
                                    </div>

                                    <!-- /.card-footer -->
                                </div>
                                <!-- /.card -->
                            </div>
                        </div>
                    </div>
                </form>
            </section>


            <script>
                function toggleForm() {
                    var form = document.getElementById("CategoryForm");
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
                    var form = document.getElementById("CategoryForm");
                    form.style.display = "none";
                }
            </script>

            <section class="content">
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
                                    <h3 class="card-title">DataTable Of Category</h3>
                                    <button style="float: right" class="btn btn-primary text-left mx-auto"
                                        id="addCategoryButton" onclick="toggleForm()">Add Category</button>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th> <!-- Serial number column -->
                                                <th>Category Name</th>
                                                <th>Category Image</th>
                                                <th>Category Description</th>
                                                @if (Auth::user()->role == 1)
                                                    <th>Shopkeeper Name</th>
                                                @endif
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categoriesWithProductCount as $index => $category)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $category->name }}</td>
                                                    <td><img class="category-image" src="{{ asset('images/category_images/' . $category->image) }}" alt=""></td>
                                                    <td>{{ $category->description }}</td>
                                                    @if (Auth::user()->role == 1)
                                                        @foreach ($shopkeepers as $shopkeeper)
                                                            @if ($category->shop_id == $shopkeeper->id)
                                                                <td>{{ $shopkeeper->name }}</td>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <td>
                                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline" onsubmit="return confirmDelete({{ $category->productCount }});">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
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
                                            <th>Category Name</th>
                                            <th>Category Image</th>
                                            <th>Category Description</th>
                                            @if (Auth::user()->role == 1)
                                                <th>Shopkeeper Name</th>
                                            @endif
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

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('layouts.js')
<!-- Page specific script -->
<script>
    function confirmDelete(productCount) {
        var confirmationMessage = 'Are you sure you want to delete this category?\n';
        confirmationMessage += 'This category contains ' + productCount + ' products.\n';
        confirmationMessage += 'Deleting the category will also delete all associated products.';

        return confirm(confirmationMessage);
    }

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
</body>

</html>
