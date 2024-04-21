<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Customer Add</title>


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
                            <h1>Customer</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Customer</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <style>
                    .required::before {
                        content: "*";
                        color: red;
                        margin-right: 5px;
                    }
                </style>

                    <form action="{{ route('customer.store') }}" method="POST" id="CustomerForm" style="display: none;"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Customer</h3>
                                        <button type="button" class="close" onclick="cancelForm()">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label required">Customer
                                                Name</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputName" name="name"
                                                    class="form-control">
                                            </div>
                                            <label for="inputPhone" class="col-sm-2 required">Customer Phone</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="phone" id="inputPhone"
                                                    class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputAddress" class="col-sm-2 col-form-label">Customer Address</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputAddress" name="address"
                                                    class="form-control">
                                            </div>
                                            <label for="inputCity" class="col-sm-2 col-form-label">Customer City</label>
                                            <div class="col-sm-4">
                                                <input type="text" id="inputCity" name="city"
                                                    class="form-control">
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
                                            <i class="fas fa-plus"></i> Add Customer
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
                    var form = document.getElementById("CustomerForm");
                    if (form.style.display === "none") {
                        form.style.display = "block";
                    } else {
                        form.style.display = "none";
                    }
                }


                function cancelForm() {
                    var form = document.getElementById("CustomerForm");
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
                                        id="addCustomerButton" onclick="toggleForm()">Add Customer</button>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Phone Number</th>
                                                @if (Auth::user()->role == 1)
                                                    <th>Shopkeeper Name</th>
                                                @endif
                                                <th>Address</th>
                                                <th>City</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($customers as $index => $customer)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $customer->name }}</td>
                                                    <td>{{ $customer->phone_no }}</td>
                                                    @if (Auth::user()->role == 1)
                                                        @foreach ($shopkeepers as $shopkeeper)
                                                            @if ($customer->shop_id == $shopkeeper->id)
                                                                <td>{{ $shopkeeper->name }}</td>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    <td>{{ $customer->address }}</td>
                                                    <td>{{ $customer->city }}</td>
                                                    <td>
                                                        <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-pen"></i>
                                                        </a>
                                                        <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline" id="deleteForm">
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
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Phone Number</th>
                                            @if (Auth::user()->role == 1)
                                                <th>Shopkeeper Name</th>
                                            @endif
                                            <th>Address</th>
                                            <th>City</th>
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
            if (confirm('Are you sure you want to delete this customer?')) {
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
