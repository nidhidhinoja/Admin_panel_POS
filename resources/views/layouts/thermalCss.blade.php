<style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: Arial, sans-serif; /* Change to your desired font */
    }
    @page{
        size: 80mm auto;     /* Adjust the width and initial height as needed */
    margin: 0 auto;
    padding:2mm;
    }
    .page {
        width: 80mm; /* Set the height to match the thermal print size */
        margin: 0 auto;
        box-sizing: border-box;
        padding: 5mm;
        position: relative;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }

    /* Add your other CSS styles for the page content */

    .border {
        padding: 1mm;
        max-width: 300px;
        text-align: center;
        position: relative;
        margin-bottom: 15px;
    }

    .shop-info {
        font-size: 15px;
        text-align: center;
        margin-bottom: 5px;
    }

    .sub-Iheader {
        font-size: 15px;
        font-weight: 500;
        text-align: left;
        margin-bottom: 5px;
    }

    .invoice-logo {
        margin: 0 auto;
        display: block;
        float: center;
        position: relative;
    }

    .customer-info {
        font-size: 15px;
        text-align: right;
        margin-bottom: 10px;
    }

    .ellipsis {
        max-width: 40px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }

    .custom-table th,
    .custom-table td {
        padding: 8px;
        border-bottom: 1px solid #dee2e6;
    }

    .custom-table thead th {
        text-align: left;
        font-weight: bold;
    }

    .custom-table tfoot td {
        text-align: right;
    }

    .custom-table tfoot tr:first-child td {
        border-top: 2px solid #dee2e6;
    }

    .in-footer {
        width: 100%;
        text-align: center;
        font-size: 18px;
        font-weight: 700;
        margin-top: 5px;
    }
</style>
