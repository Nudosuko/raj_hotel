<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>       
        .order-container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            text-align: center;
        }
        .grand-total {
            font-size: 1.2rem;
            font-weight: bold;
/*            color: #d9534f;*/
        }
        iframe {
            display: block;
            margin: 20px auto; /* Centers horizontally */
            width: 50%;
            height: 300px;
            border: 2px solid #4e46e5;
        }

/* Print Styling for 58mm Thermal Printer */
@media print {
    body {
        width: 58mm !important;
        margin: 0 !important;
        padding: 1mm !important;
        font-size: 10px;
        font-family: "Courier New", monospace;
        line-height: 1.2;
        -webkit-print-color-adjust: exact;
    }

    .order-container {
        width: 100% !important;
        max-width: 58mm !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        box-shadow: none !important;
    }

    h3 {
        font-size: 13px;
        margin: 2px 0;
        padding-bottom: 2px;
        border-bottom: 1px dashed #000;
    }

    p {
        margin: 2px 0;
        padding: 1px 0;
        display: flex;
        justify-content: space-between;
    }

    p strong {
        min-width: 45%;
        display: inline-block;
    }

    .table {
        width: 100%;
        margin: 3px 0;
        border-collapse: collapse;
    }

    .table th {
        font-size: 10px;
        padding: 3px 1px;
        border-bottom: 1px dashed #000;
        text-align: left;
        background: transparent !important;
        color: #000 !important;
    }

    .table td {
        padding: 2px 1px;
        font-size: 10px;
        text-align: left;
    }

    .table-dark th {
        border-bottom: 2px dashed #000;
    }

    .grand-total {
        font-size: 11px;
        font-weight: bold;
        padding-top: 3px;
    }

    .badge {
        border: 1px solid #000;
        padding: 1px 3px;
        background: transparent !important;
        color: #000 !important;
    }

    @page {
        size: auto;
        margin: 0;
        margin-top: 2mm;
        margin-bottom: 2mm;
    }
}




       </style>
</head>
<body>

    <div class="container">
        <div class="order-container" id="order_details">
            <h3 class="text-center text-primary">Order Details</h3>

            <!-- Order Info -->
            <div class="mb-3">
                <p><strong>Order Date:</strong> <?= date("d-m-Y", strtotime($order_info['order_date'])) ?></p>
                <p><strong>Order Time:</strong><?=$order_info['order_time']?></p>
                <p><strong>Order Status:</strong> <span class="badge bg-success"><?=$order_info['order_status']?></span></p>
            </div>

            <!-- Product Table -->
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Sr.No.</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                    $ttl = 0;
                    foreach($order_products as $key => $row){
                        $ttl = $ttl + $row['total'];
                  ?>
                    <tr>
                        <td><?=$key+1?></td>
                        <td><?=$row['product_name']?></td>
                        <td>&#8377;<?=number_format($row['product_price'])?></td>
                        <td><?=$row['qty']?></td>
                        <td>&#8377;<?=number_format($row['total'])?></td>
                    </tr>
                   <?php
                    }
                   ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                        <td class="grand-total">&#8377; <?=number_format($ttl)?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
         <!-- Home Button -->
        <div class="text-center">
            <a href="<?=base_url()?>/hotel/index" class="btn btn-primary">Back to Home</a>
            <button onclick="print_order_details()" class="btn btn-primary">Print</button>
        </div>
            <iframe name="display-frame" style="width:50%; height:300px;"></iframe>
    </div>
</body>
</html>

<script type="text/javascript">
    function print_order_details() {
        // Clone the order details section
        const printContent = document.getElementById('order_details').cloneNode(true);
        
        // Create a new window for printing
        const printWindow = window.open('', 'display-frame');
        
        // Write necessary HTML and styles to the new window
        printWindow.document.write(`
            <html>
                <head>
                    <title>Order Receipt</title>
                    <style>
                        ${document.querySelector('style').innerHTML}
                        .btn { display: none !important; }
                        body { margin: 0; padding: 2mm; }
                    </style>
                </head>
                <body>
                    ${printContent.innerHTML}
                    <script>
                        setTimeout(function() {
                            window.print();
                            window.onafterprint = function() {
                                window.close();
                            };
                        }, 100);
                    <\/script>
                </body>
            </html>
        `);
        
        printWindow.document.close();
    }
</script>

<?php
// echo "<pre>";
// print_r($order_info);
// print_r($order_products);
?>

<!-- order_date
order_time
order_status

product_name x 3
product_price x 3
qty x 3
total x 3

grand_total -->