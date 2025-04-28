<?php

	class Login extends CI_Controller{
		public function index(){
			$this->load->view('login_form');
		}

		public function process_login(){
			if(isset($_POST['email']) && isset($_POST['password'])){
				$cond['hotel_email']=$_POST['email'];
				$cond['hotel_password']= $_POST['password']; 
				$match=$this->My_model->select_where('hotel',$cond);
				if(isset($match[0]['hotel_id'])){
					$_SESSION['hotel_id'] = $match[0]['hotel_id'];
					redirect(base_url('hotel'));
				}
				else{
					redirect(base_url('login'));
				}
			}
		}
	}

?>