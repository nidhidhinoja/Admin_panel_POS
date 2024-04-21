<html>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    @include('layouts.invoiceCss')
</head>

<body>
    <div>
        <div class="border">
            <span class="invoice-type">
                INVOICE
            </span>
            <img class="invoice-logo"
                src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/shopkeeper_images/' . $data['shop_logo']))) }}"
                alt="" width="100px" height="100px">
                <div>
                    <table class="product-table">
                        <table>
                            <tr>
                                <th>FROM</th>
                                <th>BILL TO</th>
                                <th>INVOICE</th>
                            </tr>
                            <tr>
                                <td>{{ $data['shopkeeper_name'] }}</td>
                                <td>{{ $data['customer_name'] }}</td>
                                <td>Invoice number: {{ $data['order_id'] }}</td>
                            </tr>
                            <tr>
                                <td>{{ $data['shop_name'] }}</td>
                                <td>{{ $data['customer_address'] }}</td>
                                <td>--</td>
                            </tr>
                            <tr>
                                <td>{{ $data['shop_city'] }}</td>
                                <td>{{ $data['customer_city'] }}</td>
                                <td>--</td>
                            </tr>
                        </table>
                        <table class="f-height">
                            <tr>
                                <th>S.NO</th>
                                <th>NAME</th>
                                <th>QTY</th>
                                <th>PRICE</th>
                                <th>AMOUNT</th>
                            </tr>
                            @foreach ($data['products'] as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $product['product_name'] }}</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ number_format($product['price']) }}</td>
                                    <td>{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </table>
                    <div class="text">
                        <span class="invoice-total-text">
                            TOTAL :
                        </span>

                        <span class="invoice-total">
                            RS: {{ $data['total_amount'] }}/-
                        </span>
                    </div>
                    <table class="table-text">
                        <tr>
                            <td colspan="3">Payment Method: {{ $data['payment_method'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Tendered Amount: {{ $data['tendered_amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="3">Change: {{ $data['change'] }}</td>
                        </tr>
                    </table>
                </div>
        </div>
    </div>
    <div class="footer">
        Thank you!
    </div>
</body>

</html>
