<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<body style="overflow: scroll;">
    <form action="<?=base_url()?>hotel/save_table" method="post">
        <div class="container p-5 pb-0 bg-white">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <h3>Add New Table</h3>
                </div>
                <div class="col-md-10">
                    Enter Table No.
                    <input type="text" name="table_no" class="form-control" value="Table No. " required>
                </div>
                <div class="col-md-2">
                    <br>
                    <button class="btn btn-primary w-100">Save Table</button>
                </div>
            </div>
        </div>
    </form>
    <div class="container py-5 bg-light">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title mb-0 text-white">Table List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-bordered text-center align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Qr Code</th>
                                    <th>Table No.</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($table_data as $key => $row): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><button class="btn btn-primary" onclick="show_qr(<?=$row['table_id']?>)">QR</button></td>
                                        <td contenteditable="true" class="editable" data-id="<?= $row['table_id'] ?>">
                                            <?= $row['table_no'] ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url() ?>hotel/delete_table/<?= $row['table_id'] ?>" class="btn btn-danger btn-sm me-2">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                            <button class="btn btn-success btn-sm btn-save" data-id="<?= $row['table_id'] ?>">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!-- Add this modal HTML just before the closing body tag -->
    <div class="modal fade" id="qrModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <button type="button" class="btn-close btn-close-white" " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qrcode" class="d-flex justify-content-center mb-3"></div>
                    <button id="printQR" class="btn btn-success">
                        <i class="fas fa-print"></i> Print QR Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>





<!-- JS for Editing and Saving -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
    // Edit button click event
    $('.btn-save').on('click', function () {
        const tableId = $(this).data('id'); // Get the table ID
        const newValue = $(this).closest('tr').find('.editable').text().trim(); // Trim updated value

        // Validate input
        if (newValue === '') {
            alert("Table number cannot be empty.");
            return;
        }

        // AJAX call to save data
        $.post("<?= base_url('hotel/update_table') ?>", 
            { table_id: tableId, table_no: newValue }, 
            function (response) {
                if (response.success) {
                    alert("Table updated successfully!");
                } else {
                    alert("Failed to update the table.");
                }
            }, 
            'json'
        ).fail(function () {
            alert("Error occurred while saving.");
        });
    });
});
</script>










   <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <div id="qrcode"></div>
    <script>
        function show_qr(table_id){
            document.getElementById('qrcode').innerHTML = '';
        var qrcode = new QRCode("qrcode","<?=base_url()?>user/index?table_no="+table_id);
        } 
    </script> -->

   <!-- Update the JavaScript code -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
let currentQRCode = null;

function show_qr(table_id) {
    // Clear previous QR code
    document.getElementById('qrcode').innerHTML = '';
    
    // Generate new QR code with better options
    currentQRCode = new QRCode(document.getElementById("qrcode"), {
        text: "<?=base_url()?>user/index?table_no=" + table_id,
        width: 256,
        height: 256,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    
    // Show modal
    const qrModal = new bootstrap.Modal(document.getElementById('qrModal'));
    qrModal.show();
}

// Improved print functionality
document.getElementById('printQR').addEventListener('click', function() {
    const qrCodeImg = document.getElementById('qrcode').querySelector('img');
    if (!qrCodeImg) return;

    // Create a hidden iframe for printing
    const iframe = document.createElement('iframe');
    iframe.style.position = 'fixed';
    iframe.style.right = '0';
    iframe.style.bottom = '0';
    iframe.style.width = '0';
    iframe.style.height = '0';
    iframe.style.border = '0';
    
    document.body.appendChild(iframe);
    
    iframe.contentDocument.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>QR Code</title>
            <style>
                @media print {
                    body {
                        margin: 0;
                        padding: 20px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                    }
                    @page {
                        margin: 0.5cm;
                        size: auto;
                    }
                }
            </style>
        </head>
        <body>
            <img src="${qrCodeImg.src}" alt="QR Code"/>
        </body>
        </html>
    `);
    
    iframe.contentDocument.close();
    
    // Wait for image to load before printing
    const iframeImage = iframe.contentDocument.querySelector('img');
    iframeImage.onload = function() {
        iframe.contentWindow.focus();
        iframe.contentWindow.print();
        
        // Remove iframe after printing
        setTimeout(() => {
            document.body.removeChild(iframe);
        }, 100);
    };
});
</script>

<!-- Add these styles to your existing CSS -->
<style>
#qrcode img {
    margin: 0 auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 4px;
    background: white;
}

.modal-content {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.modal-header {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

#printQR {
    transition: all 0.3s ease;
}

#printQR:hover {
    transform: translateY(-2px);
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
</style>
