<?php 
	date_default_timezone_set("Asia/Kolkata");
	class User extends CI_Controller{
		public function index(){
			// print_r($_GET);
			$_SESSION['table_id']=$_GET['table_no'];
			$data['cats']= $this->My_model->get_cats();
			$data['products']=$this->My_model->get_products();
			// print_r($_SESSION['hotel_id']);
			$this->load->view('user/products',$data);
		}

		public function add_product_in_session(){
			$_SESSION['cart'][$_GET['product_id']] = $_GET['qty'];
			if ($_GET['qty'] == 0) {
				unset($_SESSION['cart'][$_GET['product_id']]);
			}
			echo json_encode(["status" => "success"]);
			// print_r($_GET);
		}

		public function send_to_kitchen(){
			// print_r($_SESSION['cart']);
			// // echo "table id";
			// print_r($_SESSION['table_id']);

			$order = [
			    "order_date" => date('Y-m-d'),
			    "table_id" => $_SESSION['table_id'],
			    "order_time" => date('H:i'),
			    "order_status" => "active"
			];
			
			// Check if there is an active order for the table
			$existing_order = $this->My_model->select_where("order_tbl", [
			    "table_id" => $_SESSION['table_id'], 
			    "order_status" => "active"
			]);
			
			// echo "<pre>";
			// print_r($existing_order);
			// echo "</pre>";
			
			if ($existing_order) {
			    // Use the existing order ID
			    $order_id = $existing_order[0]['order_id'];
			} else {
			    // Insert new order and get the new order ID
			    $order_id = $this->My_model->insert("order_tbl", $order);
			}
			
			// Insert products into order_product table
			foreach ($_SESSION['cart'] as $product_id => $qty) {
			    $product = $this->My_model->select_where("products", ["product_id" => $product_id]);
			    $product_price = $product[0]['product_price'];
			    $total = $product_price * $qty;
			
			    $order_product = [
			        "order_id" => $order_id, 
			        "product_id" => $product_id,
			        "qty" => $qty,
			        "product_price" => $product_price,
			        "total" => $total
			    ];
			    
			    $this->My_model->insert("order_product", $order_product);
			}
			
			redirect(base_url('user/thank_you'));
		}

		public function thank_you(){
			$_SESSION['cart']=[];
			$this->load->view("user/thank_you");
		}
	}
?>

<!-- Create TABLE order_tbl(order_id int primary key auto_increment,
	order_date date,
	table_id int,
	order_time varchar(10),
	order_status varchar(15)
); -->

<!-- CREATE TABLE order_product(order_product_id INT PRIMARY KEY AUTO_INCREMENT,
	order_id INT,
	product_id INT,
	qty INT,
	product_price INT,
	total INT
); -->