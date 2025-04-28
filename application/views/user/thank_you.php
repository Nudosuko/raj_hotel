<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .thank-you-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .thank-you-card {
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container thank-you-container">
    <div class="thank-you-card">
        <h1 class="text-success">✅ Your Order is Confirmed!</h1>
        <p class="lead">Your order will be ready in <strong>15 minutes</strong>.</p>

        <a href="<?= base_url() ?>user/index?table_no=<?= $_SESSION['table_id'] ?>" class="btn btn-primary btn-lg mt-3">
            <i class="bi bi-house-door"></i> Home
        </a>
    </div>
</div>

<!-- Bootstrap JS (Optional, for animations & interactions) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
