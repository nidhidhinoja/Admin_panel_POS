<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    @include('layouts.invoice-dynamicCss')
</head>

<body>
    <div class="page">
        <div class="border">
            <div class="container">
                <span class="invoice-header">
                    Invoice
                    <div class="sub-Iheader">
                        Invoice no:- {{ $data['order_id'] }}<br>
                        Date:- {{ $data['order_date'] }}<br>
                        GSTIN:- {{ $data['shop_gstin'] }}
                    </div>
                </span>
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/shopkeeper_images/' . $data['shop_logo']))) }}"
                    alt="logo" width="100px" height="100px" class="invoice-logo">
            </div>
        </div>
        <div class="border">
            <div class="container">
                <div class="invoice-to-header">
                    Invoiced To :
                    <div class="invoice-to">
                        {{ $data['customer_name'] }}<br>
                        {{ $data['customer_address'] }}<br>
                        {{ $data['customer_num'] }}<br>
                        {{ $data['customer_city'] }}
                    </div>
                </div>
                <div class="pay-to-header">
                    Pay To :
                    <div class="pay-to">
                        {{ $data['shop_name'] }}<br>
                        {{ $data['shop_address'] }}<br>
                        {{ $data['shop_num'] }}<br>
                        {{ $data['shop_city'] }}
                    </div>
                </div>
            </div>
            <div class="table-height">
                <table class="product-table ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Description</th>
                            <th>Quantity</th>
                            <th>Unit</th>
                            <th>Price</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['products'] as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ number_format($product['price']) }}</td>
                                <td>{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footertext">
                <p><strong> Subtotal:-</strong> {{ $data['total_amount'] }}</p>
                <p><strong>Taxes:-</strong>500 </p>
                <p><strong>Total:-</strong>{{ $data['total_amount'] }}</p>
            </div>
            <div class="payment">
                <div class="payment-info-header">
                    Payment Information:
                    <div class="payment-info-text">
                        Payent method:-{{ $data['payment_method'] }}<br>
                        Bank Name - XXXX BANK,<br>
                        Account Number - XYZ23456789QWERTYUIOPAS
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            Thank you!
        </div>
</body>

</html>
