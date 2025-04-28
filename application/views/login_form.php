
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/icons/icon-48x48.png" />
	<title>Sign In | Raj Palace Admin</title>

	<link href="<?=base_url()?>assets/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back, Owner</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">
									<div class="text-center">
										<img src="<?=base_url()?>assets/img/avatars/avatar-1.webp" alt="Charles Hall" class="img-fluid rounded-circle" width="132" height="132" />
									</div>
									<form action="<?=base_url()?>login/process_login" method="post">
										<div class="mb-3">
											<label class="form-label">Email</label>
											<input class="form-control form-control-lg" type="email" name="email" placeholder="Enter your email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Enter your password" />
											<small>
          </small>
											<label class="form-check">
          </label>
										</div>
										<div class="text-center mt-3">
											<button type="submit" class="btn btn-lg btn-primary">Sign in</button>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="<?=base_url()?>assets/js/app.js"></script>

</body>

</html>

<!-- Create Table hotel(hotel_id INT PRIMARY KEY AUTO_INCREMENT,
hotel_name VARCHAR(100),
hotel_email VARCHAR(100),
hotel_mobile VARCHAR(15),
hotel_password VARCHAR(20)
);

INSERT INTO hotel(
hotel_name,
hotel_email,
hotel_mobile,
hotel_password)
VALUSE(
	'raj_hotel',
	'info@rajhotel.com',
	'9850465282',
	'raj@$#4695'
);



 -->
