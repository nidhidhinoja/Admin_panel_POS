<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    @include('layouts.thermalCss')
</head>
<div class="page">
    <div class="border">
        <div class="shop-info">
            <img class="invoice-logo"
            src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/shopkeeper_images/' . $data['shop_logo']))) }}"
            alt="logo" width="150px" height="100px">
            <strong>{{ $data['shop_name'] }}</strong><br>
            {{ $data['shop_address'] }}<br>
            {{ $data['shop_city'] }}<br>
            {{ $data['shop_num'] }}<br>
            GSTIN:{{ $data['shop_gstin'] }}
        </div>
    </div>
    <div class="sub-Iheader">
        Invoice no:-{{ $data['order_id'] }}<br>
        Date:- {{ $data['order_date'] }}<br>
        Payment method:- {{ $data['payment_method'] }}<br><br>
    </div>
    <div class="customer-info">
        {{ $data['customer_name'] }}<br>
        {{ $data['customer_num'] }}<br>
        {{ $data['customer_address'] }}<br>
        {{ $data['customer_city'] }}
    </div>
    <table class="custom-table">
        <thead>
            <tr>
                <th class="left">NAME</th>
                <th class="right">QTY</th>
                <th class="right">AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['products'] as $product)
            <tr>
                <td class="ellipsis left">{{ $product['product_name'] }}</td>
                <td class="ellipsis right">{{ $product['quantity'] }}</td>
                <td class="ellipsis right">{{ number_format($product['price'] * $product['quantity'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Subtotal:</td>
                <td class="right">{{ $data['total_amount'] }}</td>
            </tr>
            <tr>
                <td colspan="2">Discount:</td>
                <td class="right">0</td>
            </tr>
            <tr>
                <td colspan="2">Total:</td>
                <td class="right">{{ $data['total_amount'] }}</td>
            </tr>
        </tfoot>
    </table>
    <hr>
    <div class="in-footer">
        Keep Shopping Thank You...
    </div>
</div>
</body>
</html>
