
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
                            <h1>Orders</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Orders</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Order List</h3>
                                    <div class="float-right">
                                        <label for="dateFrom" style="font-size: 20px;">From:</label>
                                        <input type="date" id="dateFrom" style="font-size: 20px;">
                                        <span id="dateFromError" class="text-danger" style="font-size: 14px;"></span>
                                        <label for="dateTo" style="font-size: 20px;">To:</label>
                                        <input type="date" id="dateTo" style="font-size: 20px;">
                                        <span id="dateToError" class="text-danger" style="font-size: 14px;"></span>
                                        <button class="btn btn-primary" onclick="applyDateFilter()">Apply</button>
                                    </div>
                                    <div id="validationAlert" class="alert alert-danger" style="display: none; font-size: 20px; font-weight: bold;"></div>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>Order Id</th>
                                                <th>Order Date</th>
                                                <th>Customer Name</th>
                                                <th>Total Amount</th>
                                                <th>print</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $index => $order)
                                            <tr>
                                                <td>
                                                    @if ($order->customer->shopkeeper)
                                                        <button class="btn btn-link plus-button" data-order-id="{{ $order->id }}">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <span>{{$order->order_id}}</span>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d-m-Y') }}</td>
                                                <td>{{ $order->customer->name }}</td>
                                                <td>{{ $order->total_amount }}</td>
                                                <td>
                                                    <a href="{{ route('order.print', ['id' => $order->id]) }}" class="btn btn-link">
                                                        <i class="fas fa-print fa-lg"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th colspan="4"></th>
                                                <th id="totalAmount"></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

</div>
<!-- ./wrapper -->
<!-- jQuery -->
@include('layouts.js')
<!-- Page specific script -->
<script>
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
<script>
    $(document).ready(function() {
        function toggleChildRow(button) {
            var row = $(button).closest('tr');
            var childRow = row.next('.child-row');
            var orderId = $(button).data('order-id');
            var url = '';

            if (childRow.length) {
                if (childRow.is(':visible')) {
                    $(button).html('<i class="fa fa-plus"></i>');
                    childRow.hide();
                } else {
                    $(button).html('<i class="fa fa-minus"></i>');
                    childRow.show();
                }
            } else {
                if ($(button).hasClass('plus-button')) {
                    url = '{{ route("order.show", ":id") }}'; // Use named route for plus button
                } else if ($(button).hasClass('minus-button')) {
                    url = '{{ url("/order") }}'; // Use /order URL for minus button
                }

                url = url.replace(':id', orderId); // Replace the placeholder with the orderId

                // Make an AJAX request to fetch the order details
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        var orderDetails = response.products;
                        var content = '';

                        if (orderDetails && orderDetails.length > 0) {
                            orderDetails.forEach(function(orderDetail, index) {
                                content += '<tr>' +
                                    '<td>' + (index + 1) + '</td>' +
                                    '<td>' + orderDetail.product_name + '</td>' +
                                    '<td>' + orderDetail.quantity + '</td>' +
                                    '<td>' + orderDetail.price + '</td>' +
                                    '</tr>';
                            });
                        } else {
                            content = '<tr><td colspan="4">No order details found.</td></tr>';
                        }

                        var childRowContent = '<tr class="child-row">' +
                            '<td colspan="7">' +
                            '<div class="child-row-content">' +
                            '<table class="table table-bordered">' +
                            '<thead>' +
                            '<tr>' +
                            '<th>#</th>' +
                            '<th>Product Name</th>' +
                            '<th>Quantity</th>' +
                            '<th>Price</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            content +
                            '</tbody>' +
                            '</table>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';

                        row.after(childRowContent);
                        $(button).html('<i class="fa fa-minus"></i>');
                    },
                    error: function(xhr, status, error) {
                        // Handle the error case
                    }
                });
            }
        }

        var table = $('#example1').DataTable({
            "responsive": true,
            "autoWidth": false,
            "order": [] // Disable initial sorting
        });

        $(document).on('click', '.plus-button, .minus-button', function() {
                toggleChildRow(this);
        });

        calculateTotals(); // Calculate and display the total amount and total number of orders initially
    });


function calculateTotals() {
    var totalAmount = 0;

    // Iterate through the visible table rows and sum the total amounts
    $('#example1 tbody tr:visible').each(function() {
        var amount = parseFloat($(this).find('td:nth-child(6)').text());
        if (!isNaN(amount)) {
            totalAmount += amount;
        }
    });

    // Update the total amount and total orders in the table footer
    $('#totalAmount').text(totalAmount.toFixed(2));
}

function applyDateFilter() {
    var dateFrom = document.getElementById("dateFrom").value;
    var dateTo = document.getElementById("dateTo").value;

    // Validate dates
    var isValid = validateDates(dateFrom, dateTo);

    if (!isValid) {
        return;
    }

    var rows = document.querySelectorAll("#example1 tbody tr");

    for (var i = 0; i < rows.length; i++) {
        var orderDate = rows[i].querySelector("td:nth-child(4)").textContent;
        orderDate = convertDateFormat(orderDate); // Convert date format

        if (isDateWithinRange(orderDate, dateFrom, dateTo)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
    calculateTotals();
}

function validateDates(dateFrom, dateTo) {
    var fromDate = new Date(dateFrom);
    var toDate = new Date(dateTo);
    var currentDate = new Date();

    // Check if the selected dates are valid
    if (fromDate > toDate) {
        showErrorPopover("dateFrom", "From date should not be greater than To date.");
        hideErrorPopover("dateTo");
        return false;
    }

    if (toDate > currentDate) {
        showErrorPopover("dateTo", "To date should not be in the future.");
        hideErrorPopover("dateFrom");
        return false;
    }

    hideErrorPopover("dateFrom");
    hideErrorPopover("dateTo");
    return true;
}

function convertDateFormat(dateString) {
    var parts = dateString.split("-");
    var year = parts[2];
    var month = parts[1];
    var day = parts[0];
    return year + "-" + month + "-" + day;
}

function isDateWithinRange(date, startDate, endDate) {
    var orderDate = new Date(date);
    var from = new Date(startDate);
    var to = new Date(endDate);

    // Add one day to include the end date in the range
    to.setDate(to.getDate() + 1);

    return orderDate >= from && orderDate < to;
}

function showErrorPopover(elementId, errorMessage) {
    var element = document.getElementById(elementId);
    element.setAttribute("data-toggle", "popover");
    element.setAttribute("data-trigger", "focus");
    element.setAttribute("data-placement", "top");
    element.setAttribute("data-content", errorMessage);
    $(element).popover("show");
}

function hideErrorPopover(elementId) {
    var element = document.getElementById(elementId);
    element.removeAttribute("data-toggle");
    element.removeAttribute("data-trigger");
    element.removeAttribute("data-placement");
    element.removeAttribute("data-content");
    $(element).popover("hide");
}



</script>
