<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<style type="text/css">
	.choose_file{
		height: 30px;
		 width: 100px;
		 margin-left: 32%;
	}
</style>
<div class="container py-5 bg-light">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title  mb-0 text-white">Product List</h2>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Product Name</th>
                                <th>Product Price</th>
                                <th>Product Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($p_data as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td contenteditable="true" class="editable" data-id="<?= $row['product_id'] ?>" data-field="product_name">
                                        <?= $row['product_name'] ?>
                                    </td>
                                    <td contenteditable="true" class="editable" data-id="<?= $row['product_id'] ?>" data-field="product_price">
                                        ₹<?= number_format($row['product_price'], 2) ?>
                                    </td>
                                    <td>
                                        <img src="<?= base_url($row['product_image']) ?>" class="img-thumbnail " data-field="product_image" style="height: 150px; width: 150px;">
                                         <input type="file" class="form-control mt-2 image-upload choose_file" data-id="<?= $row['product_id'] ?>" accept="image/*" style="">
                                    </td>
                                    <td>
                                        <!-- Delete Button -->
                                        <a href="<?= base_url() ?>hotel/delete_product/<?= $row['product_id'] ?>" class="btn btn-danger btn-sm me-2">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                        <!-- Edit Button -->
                                       <button class="btn btn-success btn-sm btn-edit" data-id="<?= $row['product_id'] ?>">
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

<!-- JS for Editing and Saving -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
	$(document).ready(function(){
    $('.image-upload').on('change', function(e) {
        let product_id = $(this).data('id');
        let file = e.target.files[0];
        
        if (file) {
            let formData = new FormData();
            formData.append('product_id', product_id);
            formData.append('product_image', file);

            $.ajax({
                url: "<?= base_url('hotel/update_product_image') ?>",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(result) {
                    if (result.success) {
                        $(`img[data-field="product_image"][data-id="${product_id}"]`).attr('src', result.image_path);
                        alert('Image uploaded successfully');
                    } else {
                        alert(result.message || 'Image upload failed');
                    }
                },
                error: function() {
                    alert('Server error occurred');
                }
            });
        }
    });
});
$(document).ready(function () {
    let originalValue; // Variable to store the original value

    // Save the original value when the field gains focus
    $('.editable').on('focus', function () {
        originalValue = $(this).text().trim();
    });

    // Handle blur event
    $('.editable').on('blur', function () {
        let product_id = $(this).data('id');
        let field = $(this).data('field');
        let newValue = $(this).text().trim();

        // Check if the value has changed
        if (originalValue === newValue) {
            return; // Do nothing if there's no change
        }

        // Validate product price
        if (field === 'product_price') {
            newValue = newValue.replace(/[₹,]/g, '');
            if (isNaN(newValue) || newValue === '') {
                alert('Please enter a valid numeric price.');
                $(this).text(originalValue); // Revert to the original value
                return;
            }
        }

        // Mark the row as editable but wait for Edit confirmation
        const row = $(this).closest('tr');
        row.find('.btn-edit').prop('disabled', false); // Enable the Edit button
        row.addClass('pending-edit'); // Add a class to mark this row as edited
    });

    // Handle Edit button click
    $('.btn-edit').on('click', function () {
        const row = $(this).closest('tr');
        const product_id = $(this).data('id');
        const fields = row.find('.editable');
        let updateData = {};

        // Collect the edited values
        fields.each(function () {
            const field = $(this).data('field');
            const value = $(this).text().trim();

            // Validate product price
            if (field === 'product_price') {
                const numericValue = value.replace(/[₹,]/g, '');
                if (isNaN(numericValue) || numericValue === '') {
                    alert('Please enter a valid numeric price.');
                    return false;
                }
                updateData[field] = numericValue;
            } else {
                updateData[field] = value;
            }
        });

        // Add product ID to the data
        updateData['product_id'] = product_id;

        // AJAX call to save the changes
        $.post(
            "<?= base_url('hotel/update_product') ?>",
            updateData,
            function (response) {
                if (response.success) {
                    alert(response.message);
                    row.removeClass('pending-edit'); // Remove the edited class
                    row.find('.btn-edit').prop('disabled', true); // Disable the Edit button
                } else {
                    alert(response.message || "Failed to update the product.");
                }
            },
            'json'
        ).fail(function () {
            alert("An error occurred while updating the product.");
        });
    });
});
</script>
