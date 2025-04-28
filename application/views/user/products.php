<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap 4 Product List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-info img {
            height: 50px;
            width: 50px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }

        .qty-controls {
            display: flex;
            align-items: center;
        }

        .qty-input {
            width: 50px;
            text-align: center;
        }

        .tab-button {
            margin-bottom: 10px;
        }

        .active-button {
            background-color: #007bff !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <!-- Category Buttons -->
        <div class="d-flex justify-content-center flex-wrap mb-3">
            <?php foreach ($cats as $key => $row) { ?>
                <button 
                    class="btn btn-outline-primary mx-1 tab-button <?= $row['category_name'] === 'Veg' ? 'active-button' : '' ?>" 
                    onclick="showProducts(<?= $row['category_id'] ?>, this)">
                    <?= $row['category_name'] ?>
                </button>
            <?php } ?>
        </div>

        <!-- Products -->
        <div id="product-container">
            <?php foreach ($products as $row) { 

                if(isset($_SESSION['cart'][$row['product_id']]))
                    $qty = $_SESSION['cart'][$row['product_id']];
                else
                    $qty= 0;

                ?>
                <div class="product-card box_cat<?= $row['category_id'] ?>" style="display: <?= $row['category_name'] === 'Veg' ? 'flex' : 'none' ?>;">
                    <div class="product-info">
                        <img src="<?= base_url($row['product_image']) ?>" alt="<?= $row['product_name'] ?>" class="img-fluid">
                        <div>
                            <h5 class="mb-0"><?= $row['product_name'] ?></h5>
                            <p class="text-primary mb-0">₹<?= number_format($row['product_price'], 2) ?></p>
                        </div>
                    </div>

                    <div class="qty-controls">
                                <button class="btn btn-outline-secondary btn-danger btn-sm"
                                onclick="decreaseQty(this,<?=$row['product_id']?>)
                                ">-</button>
                                <input type="text" class="form-control qty-input mx-1" value="<?=$qty?>"  readonly  autocomplete="off">
                                <button class="btn btn-outline-secondary  btn-success btn-sm"
                                onclick="increaseQty(this,<?=$row['product_id']?>)
                                ">+</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <a href="<?=base_url("user/send_to_kitchen")?>">
        <button class=" btn btn-primary btn-lg" style="width:90%; position:fixed; z-index: 999; bottom: 10px; left:5%" >Add To Kitchen</button>
    </a>
    <div class="product-card box_cat<?= $row['category_id'] ?>" 
     data-product-id="<?= $row['product_id'] ?>" 
     style="display: <?= $row['category_name'] === 'Veg' ? 'flex' : 'none' ?>;"></div>
        <!-- <button style="width: 90%; position: fixed; z-index: 999; bottom: 10px; left: 5%;" class="btn btn-primary btn-lg mb-3">Add to Kitchen</button>
    </div> -->
    <script>
        function showProducts(categoryId, button) {
            document.querySelectorAll('.product-card').forEach(box => {
                box.style.display = 'none';
            });
            document.querySelectorAll(`.box_cat${categoryId}`).forEach(box => {
                box.style.display = 'flex';
            });
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active-button');
            });
            button.classList.add('active-button');
        }

        function increaseQty (button, product_id)
        {
            const input = button.previousElementSibling; 
            input.value = parseInt(input.value) + 1;
            $.ajax({
                 "url":"<?=base_url() ?>user/add_product_in_session",
                 "data":{"product_id":product_id, "qty": input.value}
                 }).done(function(res)
                {
                    console.log(res);
                });
            }

        function decreaseQty (button, product_id) { 
            const input = button.nextElementSibling;
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value)-1;

                $.ajax({
                 "url":"<?=base_url() ?>user/add_product_in_session",
                 "data":{"product_id":product_id, "qty": input.value}
                 }).done(function(res)
                {
                    console.log(res);
                });


            }
        }
    </script>
</body>
</html>

