<style>
    body {
  margin: 0;
}

.page {
  width: 210mm;
  height: 297mm;
  margin: 0 auto;
  box-sizing: border-box;
  padding: 20mm;
  position: relative;
}

.border {
  border: 1px solid #ccc;
  padding: 20px;
  margin: 0 auto;
  max-width: 600px;
  text-align: center;
  position: relative;
}

.footer {
  position: absolute;
  left: 0;
  bottom: 50px; /* Adjust the value as needed to create space between the content and footer */
  width: 100%;
  text-align: center;
  font-size: 18px;
  font-weight: 700;
  margin-top: 20px; /* Add margin-top to create space between the content and footer */
}

.text {
  text-align: right;
  margin-bottom: 20px; /* Add margin-bottom to create space between the text and table */
}

.invoice-total-text {
  font-weight: 700;
  font-size: 20px;
}

.invoice-total {
  font-size: 20px;
}

.table-text {
  margin: 0 auto;
  max-width: 600px;
  text-align: center;
  margin-top: 20px; /* Add margin-top to create space between the text and table */
}


    .invoice-type {
        font-size: 50px;
        font-weight: 700;
        color: rgb(0, 0, 0);
    }

    .invoice-logo {
        float: right; /* Align the logo to the right side */
        border-radius: 50%;
        object-fit: cover;
        overflow: hidden;
    }

    table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ccc;
    }

    th {
        font-weight: 700;
    }

    .product-table {
        /* Custom styles for the product table */
        margin: 0 auto;
        width: 100%;
        max-width: 600px;
        background-color: #fff; /* Change background color to white */
        margin-top: 50px; /* Add margin-top to create space */
    }

    .product-table th {
        background: rgba(217, 225, 242, 1.0);
    }

    .product-table td {
        text-align: center;
    }

    .text {
        text-align: right;
    }


    .f-height{
        height:430px!important
     }

    /* Additional CSS for fixed spacing */
    .product-table tr:first-child {
        margin-bottom: 20px;
    }

    .product-table tr:not(:last-child) {
        margin-bottom: 10px;
    }
</style>
