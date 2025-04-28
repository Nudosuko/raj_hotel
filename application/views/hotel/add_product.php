<form action="<?= base_url() ?>hotel/save_product" method="post" enctype="multipart/form-data" id="productForm">
    <div class="container p-5 pb-0 bg-white">
        <div class="row mb-3">
            <div class="col-md-12">
                <h3>Add New Product</h3>
            </div>
        </div>
        <div class="row">
            <!-- Select Category -->
            <div class="col-md-6">
                <label class="form-label">Select Category</label>
                <select class="form-control" name="category_id" id="category" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php foreach ($cats as $row): ?>
                        <option value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <!-- Enter Product Name -->
            <div class="col-md-6">
                <label class="form-label">Enter Product Name</label>
                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" required>
            </div>
        </div>
        <div class="row mt-3">
            <!-- Price -->
            <div class="col-md-6">
                <label class="form-label">Price</label>
                <input type="number" class="form-control" name="product_price" id="price" placeholder="Enter Price" required>
            </div>
            <!-- Image -->
            <div class="col-md-6">
                <label class="form-label">Upload Image</label>
                <input type="file" class="form-control" name="product_image" id="product_image">
            </div>

        </div>
        <div class="row mt-3">
            <!-- Enter Prompt -->
            <div class="col-md-12">
                <label class="form-label">Enter Prompt for AI-Generated Image</label>
                <input type="text" class="form-control" name="prompt" id="prompt" placeholder="Describe the image you want (e.g., Sunset over mountains)">
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <button type="button" class="btn btn-primary" id="generateImage">Generate Image</button>
                <button type="button" class="btn btn-secondary" id="saveGeneratedImage">Upload this image</button>
                <button type="submit" class="btn btn-success">Save Product</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h4>Generated Image</h4>
                <div id="generatedImageContainer">
                    <!-- The generated image will be displayed here -->
                </div>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
        let generatedImageBlob = null; // Store the generated image as a blob
        let imageUrl = null; // Store the image URL

        // Save generated image to the form
        $('#saveGeneratedImage').on('click', function () {
            if (!generatedImageBlob) {
                alert('Generate an image first.');
                return;
            }

            // Convert the blob to Base64 and set it in a hidden input field
            const reader = new FileReader();
            reader.onloadend = function () {
                const base64String = reader.result.split(',')[1]; // Get Base64 string without the prefix
                if ($('#generatedImageInput').length === 0) {
                    $('#productForm').append('<input type="hidden" id="generatedImageInput" name="generated_image" value="' + base64String + '">');
                } else {
                    $('#generatedImageInput').val(base64String);
                }
                alert('Generated image added to the form. You can now submit.');
            };
            reader.readAsDataURL(generatedImageBlob); // Read blob as Base64
        });

        // Generate image on button click
        $('#generateImage').on('click', function () {
            const prompt = $('#prompt').val();
            if (!prompt) {
                alert('Please enter a prompt!');
                return;
            }

            // Clear the previous image and show a loading spinner
            $('#generatedImageContainer').html('<p>Generating image... Please wait.</p>');

            // Make AJAX request to Pollinations.AI API
            $.ajax({
                url: 'https://image.pollinations.ai/prompt/' + encodeURIComponent(prompt),
                method: 'GET',
                xhrFields: {
                    responseType: 'blob' // Set response type to blob for image data
                },
                success: function (response) {
                    // Store the image blob
                    generatedImageBlob = response;

                    // Create a URL for the image blob and display it
                    imageUrl = URL.createObjectURL(response);
                    $('#generatedImageContainer').html('<img src="' + imageUrl + '" class="img-fluid img-thumbnail" alt="Generated Image">');
                },
                error: function (xhr, status, error) {
                    $('#generatedImageContainer').html('<p>Failed to generate image. Please try again.</p>');
                    console.error("Error generating image:", error, xhr.responseText); // Log the error for debugging
                }
            });
        });
    });
</script>


<!-- CREATE TABLE `products` (
    `product_id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT,
    `product_name` VARCHAR(255),
    `product_price` DECIMAL(10, 2),
    `product_image` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); -->
