<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
        @include('layouts.posCss')
</head>

<body>
    <div class="main">
        <div class="border">
            <span class="invoice-type">
                INVOICE
            </span>
            <div class="invoice-number">
                Order No:- {{ $data['order_id'] }}
                Date:- {{ $data['order_date'] }}
            </div>
            <div class="shop-details">
                <img class="invoice-logo"
                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/shopkeeper_images/' . $data['shop_logo']))) }}"
                    alt="">
                <div class="shop-name">{{ $data['shop_name'] }}</div>
                <div class="shopkeeper-details">
                    {{ $data['shopkeeper_name'] }}<br>
                    {{-- {{ $data['shopkeeper_number'] }}<br>
                    {{ $data['shopkeeper_address'] }}<br>
                    {{ $data['shop_city'] }} --}}
                </div>
            </div>
            <div class="customer-details">
                <strong>BILL TO:</strong><br>
                {{ $data['customer_name'] }}<br>
                {{ $data['customer_address'] }}<br>
                {{ $data['customer_city'] }}
            </div>
            <div class="product-table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>S.NO</th>
                            <th>NAME</th>
                            <th>QTY</th>
                            <th>PRICE</th>
                            <th>AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['products'] as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
    <div class="footer">
        Thank you!
    </div>
</body>

</html>
