<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Add ShopKeeper</title>


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
            <!-- <button style="float: right" class="btn btn-primary text-left mx-auto" id="addShopkeeperButton" onclick="toggleForm()">Add Shopkeeper</button> -->

            <section class="content">
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
                <form action="{{ route('shopkeepers.store') }}" method="POST" id="shopkeeperForm"
                    enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Shopkeeper</h3>
                                        <button type="button" class="close" onclick="cancelForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Shopkeeper
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input name="inputName" type="text" value="{{ old('inputName') }}"
                                                    id="inputName" class="form-control" required>
                                            </div>
                                            <label for="inputShopName" class="col-sm-2 col-form-label required">Shop
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input name="inputShopName" type="text"
                                                    value="{{ old('inputShopName') }}" id="inputShopName"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail"
                                                class="col-sm-2 col-form-label required">Email</label>
                                            <div class="col-sm-4">
                                                <input name="inputEmail" type="email" value="{{ old('inputEmail') }}"
                                                    id="inputEmail" class="form-control" required>
                                            </div>
                                            <label for="inputPhoneNumber" class="col-sm-2 col-form-label required">Phone
                                                Number</label>
                                            <div class="col-sm-4">
                                                <input name="inputPhoneNumber" type="tel"
                                                    value="{{ old('inputPhoneNumber') }}" id="inputPhoneNumber"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputAddress"
                                                class="col-sm-2 col-form-label required">Address</label>
                                            <div class="col-sm-10">
                                                <textarea name="inputAddress" id="inputAddress" class="form-control" rows="2" required>{{ old('inputAddress') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputPassword"
                                                class="col-sm-2 col-form-label required">Password</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input name="inputPassword" type="password" id="inputPassword"
                                                        class="form-control" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="showPasswordToggle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="inputConfirmPassword"
                                                class="col-sm-2 col-form-label required">Confirm Password</label>
                                            <div class="col-sm-4">
                                                <div class="input-group">
                                                    <input name="inputConfirmPassword" type="password"
                                                        id="inputConfirmPassword" class="form-control" required>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="showConfirmPasswordToggle">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputGST" class="col-sm-2 col-form-label required">GST
                                                Number</label>
                                            <div class="col-sm-4">
                                                <input name="inputGST" type="text" value="{{ old('inputGST') }}"
                                                    id="inputGST" class="form-control" required>
                                            </div>
                                            <label for="inputProjectLeader" class="col-sm-2">Logo</label>
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
                                            <i class="fas fa-plus"></i> Add Shopkeeper
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>


            </section>
            <script>
                function toggleForm() {
                    var form = document.getElementById("shopkeeperForm");
                    if (form.style.display === "none") {
                        form.style.display = "block";
                    } else {
                        form.style.display = "none";
                    }
                }

                function addShopkeeper() {
                    // code to add shopkeeper goes here

                    // Check if there are validation errors
                    var errorDiv = document.querySelector('.alert-danger');
                    if (errorDiv === null || errorDiv.style.display === "none") {
                        cancelForm();
                    }
                }

                function cancelForm() {
                    var form = document.getElementById("shopkeeperForm");
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
                                    <h3 class="card-title">DataTable Of ShopKeeper</h3>
                                    <button style="float: right" class="btn btn-primary text-left mx-auto"
                                        id="addShopkeeperButton" onclick="toggleForm()">Add Shopkeeper</button>
                                </div>

                                <!-- /.card-header -->
                                <div class="card-body">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th> <!-- Serial number column -->
                                                <!-- <th>Shopkeeper Name</th> -->
                                                <th class="hidden visually-hidden" style="display: none;">time</th>
                                                <th>Shopkeeper Name</th>
                                                <th>Shop Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>GST Number</th>
                                                <th>Logo</th>
                                                <!-- <th>Shopkeeper Image</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $serial = 1; @endphp
                                            <!-- Initialize serial number variable -->
                                            @foreach ($shopkeepers as $c)
                                                <tr>
                                                    <td>{{ $serial++ }}</td>
                                                    <!-- Increment and display serial number -->
                                                    <td class="hidden visually-hidden" style="display: none;">
                                                        {{ $c->created_at }}</td>
                                                    <td>{{ $c->name }}</td>
                                                    <td>{{ $c->shop_name }}</td>
                                                    <td>{{ $c->email }}</td>
                                                    <td>{{ $c->phone_number }}</td>
                                                    <td>{{ $c->address }}</td>
                                                    <td>{{ $c->gst }}</td>
                                                    <td><img class="category-image"
                                                            src="{{ asset('images/shopkeeper_images/' . $c->image) }}"
                                                            alt=""></td>
                                                    <td>
                                                        <div></div>
                                                        <a href="{{ route('shopkeepers.edit', $c->id) }}"
                                                            class="btn btn-primary btn-sm"><i
                                                                class="fas fa-pen"></i></a>
                                                        <form action="{{ route('shopkeepers.destroy', $c->id) }}" method="POST" style="display: inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete()"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th> <!-- Serial number column -->
                                                <th class="hidden visually-hidden" style="display: none;">time</th>
                                                <th>Shopkeeper Name</th>
                                                <th>Shop Name</th>
                                                <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Address</th>
                                                <th>GST Number</th>
                                                <th>Logo</th>
                                                <!-- <th>Shopkeeper Image</th> -->
                                                <th>Action</th>
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
    @include('layouts.js')
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
        // Add event listener to the Confirm Password field
        document.getElementById('inputConfirmPassword').addEventListener('input', validatePassword);

        function validatePassword() {
            var password = document.getElementById('inputPassword').value;
            var confirmPassword = document.getElementById('inputConfirmPassword').value;

            if (password !== confirmPassword) {
                document.getElementById('inputConfirmPassword').setCustomValidity("Passwords do not match");
            } else {
                document.getElementById('inputConfirmPassword').setCustomValidity("");
            }
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this product?')) {
                // User confirmed, proceed with the form submission
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
    <script>
        document.getElementById('showPasswordToggle').addEventListener('click', function() {
            var passwordInput = document.getElementById('inputPassword');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

        document.getElementById('showConfirmPasswordToggle').addEventListener('click', function() {
            var confirmPasswordInput = document.getElementById('inputConfirmPassword');

            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                confirmPasswordInput.type = 'password';
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    </script>
</body>

</html>
