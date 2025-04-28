<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<form action="<?=base_url()?>hotel/save_category" method="post">
    <div class="container p-5 pb-0 bg-white">
        <div class="row">
            <div class="col-md-12 mb-3">
                <h3>Add New Category</h3>
            </div>
            <div class="col-md-10">
                Enter Category Name
                <input type="text" name="category_name" class="form-control" placeholder="Veg/Non-Veg" required>
            </div>
            <div class="col-md-2">
                <br>
                <button class="btn btn-primary w-100">Save Category</button>
            </div>
        </div>
    </div>
</form>
<div class="container py-5 bg-light">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0 text-white">Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cats as $key => $row): ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td contenteditable="true" class="editable" data-id="<?= $row['category_id'] ?>">
                                        <?= $row['category_name'] ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url() ?>hotel/delete_category/<?= $row['category_id'] ?>" class="btn btn-danger btn-sm me-2">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </a>
                                        <button class="btn btn-success btn-sm btn-save" data-id="<?= $row['category_id'] ?>">
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        // Event listener for "Edit" button click
        $('.btn-save').on('click', function () {
            const $button = $(this);
            const categoryId = $button.data('id'); // Get the category ID
            const $editableCell = $button.closest('tr').find('.editable'); // Find the editable cell
            const newValue = $editableCell.text().trim(); // Get the updated value

            // Validate the new value
            if (newValue === "") {
                alert("Category name cannot be empty!");
                return;
            }

            // Disable button during AJAX call
            $button.prop('disabled', true);

            // AJAX call to save the updated category
            $.ajax({
                url: "<?= base_url('hotel/update_category') ?>",
                type: "POST",
                data: {
                    category_id: categoryId,
                    category_name: newValue,
                },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        alert("Category updated successfully!");
                    } else {
                        alert("Failed to update the category.");
                    }
                },
                error: function () {
                    alert("Error occurred while updating the category.");
                },
                complete: function () {
                    // Re-enable the button after the AJAX call is complete
                    $button.prop('disabled', false);
                },
            });
        });
    });
</script>



<!-- create table category(category_id int primary key Auto_increment,
category_name varchar(100),
hotel_id int); -->