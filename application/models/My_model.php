<?php

	class My_model extends CI_Model{
		function insert($tname,$data){
			$this->db->insert($tname,$data);
			return $this->db->insert_id();
		}

		function select($tname){
			return $this->db->get($tname)->result_array();
		}

		function select_where($tname,$cond){
			return $this->db->where($cond)->get($tname)->result_array();
		}
		
		public function update($tname, $data, $cond)
		{
		    $this->db->where($cond)->update($tname, $data);
		}

		public function delete($tname, $cond)
		{
		    $this->db->where($cond)->delete($tname);
		}

		function get_cats(){
			  if (!isset($_SESSION['hotel_id'])) {
      			  return []; // Return an empty array if session is not set
    			}
			$cond = ["hotel_id" => $_SESSION['hotel_id']];
		   	return $this->select_where("category", $cond);
		}

		function get_products(){
			return $this->db->query("SELECT * FROM products,category WHERE products.category_id = category.category_id")->result_array();
		}

		public function product_update($table, $data, $where) {
	    	$this->db->where($where);
	   	 return $this->db->update($table, $data);
		}
	}

?>