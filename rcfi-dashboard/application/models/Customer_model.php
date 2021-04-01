<?php

class Customer_model extends CI_Model{

    function check_duplicate_customer(){
        $company = $this->input->post('customer');
        $result = $this->db->query("SELECT id_customer FROM customer 
        WHERE customer='$customer' AND del_status = 1 ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function check_duplicate_customer_walkin(){
        $name = $this->input->post('name');
        $result = $this->db->query("SELECT id_customer_walkin FROM customer_walkin 
        WHERE name='$name' AND del_status = 1 ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function add_customer(){
        unset($_POST['id_customer']);
        $this->db->insert('customer',$this->input->post());
    }

    function add_customer_walkin(){
        unset($_POST['id_customer_walkin']);
        $this->db->insert('customer_walkin',$this->input->post());
    }

    public function call_customer_company(){
        $this->db->where('del_status',1);
        $query = $this->db->get('customer_company');
        return $query->result(); 
    }

    public function call_customer_walkin(){
        $this->db->where('del_status',1);
        $query = $this->db->get('customer_walkin');
        return $query->result(); 
    }

    public function delete_customer_company(){
        $this->db->where('id_customer_company',$this->input->post('id'));
        $query = $this->db->UPDATE('customer_company',array('del_status' => 0));
    }

    public function delete_customer_walkin(){
        $this->db->where('id_customer_walkin',$this->input->post('id'));
        $query = $this->db->UPDATE('customer_walkin',array('del_status' => 0));
    }
 
    public function edit_customer_company(){
        $id_customer_company = $this->input->post('id_customer_company');
        unset($_POST['id_customer_company']);
        $this->db->where('id_customer_company',$id_customer_company);
        $query = $this->db->UPDATE('customer_company',$this->input->post());
    }

    public function get_customer_list(){
        $query = $this->db->query("SELECT * FROM customer WHERE del_status = 1");
        return $query->result(); 
    }

}