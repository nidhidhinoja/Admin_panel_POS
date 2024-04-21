<style>
    @page {
    size: 80mm 297mm;     /* Adjust the width and initial height as needed */
    margin: 0 auto;
    padding:2mm;
    }
    body {
        font-family: 'Roboto Condensed', sans-serif;
        margin: 0;
        padding: 10mm; /* Adjust the padding to fit the thermal paper size */
    }

    .border {
        max-width: 80mm; /* Adjust the max-width to fit the thermal paper size */
        padding: 10px;
        border: 1px solid #000;
        background-color: #fff; /* Set the background color of the invoice */
    }

    .invoice-type {
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .invoice-number {
        font-size: 14px;
        text-align: right;
        margin-bottom: 5px;
    }

    .invoice-logo {
        width: 60px; /* Adjust the width of the logo as needed */
        height: 60px; /* Adjust the height of the logo as needed */
        border-radius: 50%;
        object-fit: cover;
        display: block;
        margin: 0 auto;
        margin-bottom: 10px;
    }

    .shop-details {
        margin-bottom: 10px;
        text-align: center;
    }

    .shop-name {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .shopkeeper-details {
        font-size: 14px;
        margin-bottom: 5px;
    }

    .customer-details {
        font-size: 14px;
        margin-bottom: 10px;
        text-align: center;
    }

    .product-table-container {
        max-width: 60mm; /* Adjust the max-width to fit the thermal paper size */
        margin: 10px auto;
    }

    .product-table {
        width: 100%;
        font-size: 8px;
        border-collapse: collapse;
    }

    .product-table th,
    .product-table td {
        padding: 5px;
        text-align: left;
        border-bottom: 1px solid #000;
    }

    .product-table th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .text {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-top: 10px;
    }

    .invoice-total-text {
        font-weight: bold;
        font-size: 14px;
        margin-right: 5px;
    }

    .invoice-total {
        font-size: 14px;
    }

    .table-text td {
        font-size: 14px;
    }

    .footer {
        font-size: 14px;
        text-align: center;
        margin-top: 10px;
    }

    </style>
