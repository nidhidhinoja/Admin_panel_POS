<style>
body {
  margin: 0;
  font-family: Arial, sans-serif;
}

.page {
  width: 210mm;
  height: 297mm;
  margin: 0 auto;
  box-sizing: border-box;
  padding: 20mm;
  position: relative;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
  overflow: hidden; /* Prevent content overflow */
}

.border {
  border: 1px solid #000000;
  padding: 20px;
  margin: 0 auto;
  max-width: 600px;
  text-align: center;
  position: relative;
  margin-bottom: 15px;
}

.container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.invoice-header {
  font-size: 30px;
  font-weight: 900;
  text-align: left;
  top: 0px;
}

.sub-Iheader {
  font-size: 15px;
  font-weight: 500;
  text-align: left;
}

.invoice-logo {
  margin: 0;
  float: right;
  object-fit: cover;
  overflow: hidden;
}

.invoice-to-header {
  font-size: 18px;
  font-weight: 800;
  text-align: left;
  margin-bottom: 8px;
}

.invoice-to {
  font-size: 14px;
  font-weight: 400;
  text-align: left;
  margin-bottom: 8px;
}

.pay-to-header {
  font-size: 18px;
  font-weight: 800;
  text-align: right;
  margin-bottom: 8px;
}

.pay-to {
  font-size: 15px;
  font-weight: 400;
  text-align: right;
  margin-bottom: 8px;
}

.product-table {
  border-collapse: collapse;
  margin: auto;
  table-layout: fixed;
  width: 100%;
}

.product-table th,
.product-table td {
  border: none;
  padding: 8px;
  text-align: center;
  white-space: nowrap; /* Prevent line breaks in table cells */
}

.product-table th {
  background-color: #f2f2f2;
}

.product-table tbody {
  max-height: calc(100vh - 400px); /* Adjust height to fit within the page */
  overflow-y: auto;
}

.product-table tbody tr {
  height: 20px;
}

.product-table tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

.product-table tbody td {
  border-bottom: 1px solid #ddd;
}

.product-table tbody tr:last-child td {
  border-bottom: none;
}

.table-footertext {
  border-bottom: 1px solid #000000;
  border-top: 1px solid #000000;
  font-size: 15px;
  font-weight: 400;
  text-align: right;
  margin-right: 5px;
  margin-left: 5px;
}

.payment {
  margin-top: 50px !important;
}

.payment-info-header {
  font-size: 18px;
  font-weight: 800;
  text-align: left;
  margin-bottom: 5px;
}

.payment-info-text {
  font-size: 15px;
  font-weight: 400;
  text-align: left;
  margin-bottom: 5px;
}

.footer {
  position: absolute;
  left: 0;
  width: 100%;
  text-align: center;
  font-size: 21px;
  font-weight: 700;
  margin-top: 5px;
}


</style>
