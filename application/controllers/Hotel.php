<?php

class Hotel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['hotel_id'])) {
            redirect(base_url('login'));
            exit;
        }
    }

    // Load the navbar view
    protected function navbar() {
        $this->load->view('hotel/navbar');
    }

    // Load the footer view
    protected function footer() {
        $this->load->view('hotel/footer');
    }

    // Default index method
    public function index() {
        $this->navbar();

        // $cond=["hotel_id" => $_SESSION['hotel_id']];
        $data['tables']= $this->My_model->select("hotel_table");
       
        $day_total = [];
        $amounts = [];
        for($i = 0; $i<7; $i++){
            $d = date('Y-m-d', strtotime("-$i day"));
            $dates[]=$d;

            $sql = "SELECT 
                    SUM((SELECT SUM(total) FROM order_product WHERE order_tbl.order_id = order_product.order_id)) as ttl
                    FROM order_tbl WHERE order_date= '$d'";

            $day_total = $this->db->query($sql)->result_array();
         
            $amounts[] = (int)$day_total[0]['ttl'];
        }
        $data['x_axis'] = $dates;
        $data['y_axis'] = $amounts;


        $this->load->view('hotel/index',$data);
        $this->footer();
    }

    // Manage table view
    public function manage_table() {
        $this->navbar();
        $cond=["hotel_id" => $_SESSION['hotel_id']];
        $data['tables']= $this->My_model->select_where("hotel_table",$cond);
        $data['table_data'] = $this->My_model->select("hotel_table");
        $this->load->view('hotel/manage_table', $data);
        $this->footer();
    }

    // Save table method
    public function save_table() {
        $_POST['hotel_id'] = $_SESSION['hotel_id'];
        $cond = [
            'hotel_id' => $_SESSION['hotel_id'],
            'table_no' => $_POST['table_no']
        ];

        $match = $this->My_model->select_where('hotel_table', $cond);

        if (!empty($match)) {
            // Table already exists
            $this->session->set_flashdata('message', 'Table already exists.');
            redirect(base_url('hotel/manage_table'));
        } else {
            // Insert new table
            $this->My_model->insert('hotel_table', $_POST);
            $this->session->set_flashdata('message', 'Table saved successfully.');
            redirect(base_url('hotel/manage_table'));
        }
    }

    // Delete table method
    public function delete_table($table_id) {
        $cond = ['table_id' => $table_id];
        $this->My_model->delete("hotel_table", $cond);
        redirect(base_url('hotel/manage_table'));
    }

    // Update table method
    public function update_table() {
        $table_id = $this->input->post('table_id');
        $table_no = $this->input->post('table_no');

        if (!empty($table_id) && !empty($table_no)) {
            $this->My_model->update('hotel_table', ['table_no' => $table_no], ['table_id' => $table_id]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }

     public function manage_category() {
        $this->navbar();
        $data['cats']=$this->My_model->get_cats();
        $this->load->view('hotel/manage_category', $data);
        $this->footer();
    }

    // Save category method
    public function save_category() {
        $_POST['hotel_id'] = $_SESSION['hotel_id'];
        $this->My_model->insert("category", $_POST);
        redirect(base_url('hotel/manage_category'));
    }

    // Update category method
    public function update_category() {
	    $category_id = $this->input->post('category_id');
	    $category_name = $this->input->post('category_name');

	    if (!empty($category_id) && !empty($category_name)) {
	        $this->My_model->update('category', ['category_name' => $category_name], ['category_id' => $category_id]);
	        echo json_encode(['success' => true]);
	    } else {
	        echo json_encode(['success' => false]);
	    }
	}


    // Delete category method
    public function delete_category($category_id){
        $cond = ['category_id' => $category_id];
        $this->My_model->delete("category", $cond);
        redirect(base_url('hotel/manage_category'));
    }

    // Add product view
    public function add_product() {
        $this->navbar();
        $data['cats']=$this->My_model->get_cats();  
        $this->load->view('hotel/add_product',$data);
        $this->footer();
    }

     // Function to generate an image
    public function generate_image() {
        // Input prompt (you can pass this via form or query parameters)
        $prompt = $this->input->post('prompt'); // Example: "Sunset over mountains"
        
        if (empty($prompt)) {
            echo "Please provide a valid prompt.";
            return;
        }

        // API URL
        $apiUrl = "https://image.pollinations.ai/prompt/" . urlencode($prompt);

        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute API request
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Check if the response is successful
        if ($http_code == 200) {
            // Display the image or save it
            header("Content-Type: image/jpeg");
            echo $response;
        } else {
            echo "Failed to generate the image. HTTP Status Code: $http_code";
        }
    }

    // Save Product
    // public function save_product(){
    //     echo"<pre>";
    //     print_r($_POST);
    //     print_r($_FILES);
    //     echo"</pre>";
    // }

    // Save product
    public function save_product() {
        $this->load->library('upload');

        // Get form data
        $category_id = $this->input->post('category_id');
        $product_name = $this->input->post('product_name');
        $product_price = $this->input->post('product_price');

        $product_image = null;

        // Handle image upload (either manually uploaded or generated)
        if (!empty($_FILES['product_image']['name'])) {
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';

            $this->upload->initialize($config);

            if ($this->upload->do_upload('product_image')) {
                $upload_data = $this->upload->data();
                $product_image = 'uploads/products/' . $upload_data['file_name'];
            } else {
                echo $this->upload->display_errors();
                return;
            }
        } elseif ($this->input->post('generated_image')) {
            // Decode the Base64 string and save the file
            $generated_image_data = base64_decode($this->input->post('generated_image'));
            $image_path = './uploads/products/generated_' . time() . '.png';
            file_put_contents($image_path, $generated_image_data);
            $product_image = $image_path;
        }

        // Prepare data to insert into the database
        $product_data = [
            'hotel_id' => $_SESSION['hotel_id'],
            'category_id' => $category_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
        ];
        // echo "<pre>";
        // print_r($product_data);
        // echo "</pre>";
        // Insert the product data into the 'products' table
        $this->My_model->insert('products', $product_data);
        echo"data inserted";

        // Redirect to the products page or any other page
        redirect(base_url('hotel/add_product'));
    }

    // Product List
    function product_list(){
        $this->navbar();
        $p_list['p_data']=$this->My_model->get_products();
        $p_list['cats']=$this->My_model->get_cats();
            // echo "<pre>";
            //     print_r($p_list);
            // echo "</pre>";
        $this->load->view('hotel/product_list',$p_list);
        $this->footer();
    }
    
    //Delete product
    public function delete_product($product_id){
        $cond = ['product_id' => $product_id];
        $this->My_model->delete("products", $cond);
        redirect(base_url('hotel/product_list'));
    }

        // Update product
        public function update_product() {
            $product_id = $this->input->post('product_id');
            $product_name = $this->input->post('product_name');
            $product_price = $this->input->post('product_price');
            $product_image = $this->input->post('product_image');

            // Validate input
            if (!empty($product_id)) {
                $product_data = [];
                
                // Only add fields that are provided
                if (!empty($product_name)) {
                    $product_data['product_name'] = $product_name;
                }
                if (!empty($product_price)) {
                    // Ensure the price is numeric
                    if (is_numeric($product_price)) {
                        $product_data['product_price'] = $product_price;
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Invalid price format']);
                        return;
                    }
                }
                if (!empty($product_image)) {
                    $product_data['product_image'] = $product_image;
                }

                // Prepare condition for WHERE clause
                $cond = ['product_id' => $product_id];

                // Call the model function to update the database
                $updated = $this->My_model->product_update('products', $product_data, $cond);

                // Check if the update was successful
                if ($updated) {
                    echo json_encode(['success' => true, 'message' => 'Product updated successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Database update failed']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid input']);
            }
        }

        public function update_product_image() {
        $product_id = $this->input->post('product_id');
        
        // Configure upload settings
        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE; // Generates a random encrypted filename

        $this->load->library('upload', $config);

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        if ($this->upload->do_upload('product_image')) {
            $upload_data = $this->upload->data();
            $image_path = 'uploads/products/' . $upload_data['file_name'];

            // Update database with new image path
            $update_data = ['product_image' => $image_path];
            $cond = ['product_id' => $product_id];
            $updated = $this->My_model->product_update('products', $update_data, $cond);

            if ($updated) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Image uploaded successfully',
                    'image_path' => base_url($image_path)
                ]);
            } else {
                echo json_encode([
                    'success' => false, 
                    'message' => 'Failed to update image in database'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false, 
                'message' => $this->upload->display_errors()
            ]);
        }
    }

    public function order_details($order_id){
        $data['order_info'] = $this->My_model->select_where("order_tbl",["order_id" => $order_id])[0];

        $sql = "SELECT * FROM products,order_product WHERE order_id = '$order_id' AND products.product_id = order_product.product_id";

        $data['order_products'] = $this->db->query($sql)->result_array();

        // echo "<pre>";
        // print_r($data);
        $this->navbar();
        $this->load->view('hotel/order_details',$data);
        $this->footer();
    }

    function print_bill($order_id){
        $cond = ["order_id" => $order_id];
        $data = ["order_status"=> "Complete"];
        $this->My_model->update("order_tbl",$data,$cond);
        redirect(base_url()."hotel/order_details/$order_id");
    }
}
?>
