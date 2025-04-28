<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="<?=base_url()?>assets/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Raj Palace Hotel</title>

	<link href="<?=base_url()?>assets/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?=base_url()?>">
          <span class="align-middle" style="letter-spacing: 2px;">Raj Palace Hotel</span>
        </a>

<ul class="sidebar-nav">
	<li class="sidebar-item active">
		<a class="sidebar-link" href="<?=base_url()?>">
       		<i class="align-middle" data-feather="sliders"></i> 
       		<span class="align-middle">Dashboard</span>
    	</a>
	</li>
	<li class="sidebar-item active">
		<a class="sidebar-link" href="<?=base_url()?>hotel/manage_table">
       		<i class="align-middle" data-feather="sliders"></i> 
       		<span class="align-middle">Manage Tables</span>
    	</a>
	</li>
	<li class="sidebar-item active">
		<a class="sidebar-link" href="<?=base_url()?>hotel/manage_category">
       		<i class="align-middle" data-feather="sliders"></i> 
       		<span class="align-middle">Manage Category</span>
    	</a>
	</li>
	<li class="sidebar-item active">
		<a class="sidebar-link" href="<?=base_url()?>hotel/add_product">
       		<i class="align-middle" data-feather="sliders"></i> 
       		<span class="align-middle">Add Product</span>
    	</a>
	</li>
	<li class="sidebar-item active">
		<a class="sidebar-link" href="<?=base_url()?>hotel/product_list">
       		<i class="align-middle" data-feather="sliders"></i> 
       		<span class="align-middle">Product List</span>
    	</a>
	</li>
</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                <i class="align-middle" data-feather="settings"></i>
              </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
				                <img src="<?=base_url()?>assets/img/avatars/avatar-1.webp" class="avatar img-fluid rounded me-1" alt="Charles Hall" />
              				</a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?=base_url()?>"><i class="align-middle me-1" data-feather="settings"></i> Change Password</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>