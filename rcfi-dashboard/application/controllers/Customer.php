<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('customer_model');

        if($this->session->userdata('id_user') == ''){
            redirect('login');
        }
	}
	 
	public function index()
	{
        $data['get_customer_list'] = $this->customer_model->get_customer_list();
		$this->load->view('dashboard/customer',$data);
    }

    public function call_customer_company(){
        $data['call_customer_company'] = $this->customer_model->call_customer_company();
        $this->load->view('dashboard/customer_company',$data);
    }

    public function call_customer_walkin(){
        $data['call_customer_walkin'] = $this->customer_model->call_customer_walkin();
        $this->load->view('dashboard/customer_walkin',$data);
    }

    public function delete_customer_company(){
        $this->customer_model->delete_customer_company();
    }

    public function delete_customer_walkin(){
        $this->customer_model->delete_customer_walkin();
    }

    public function fetch_customer_data(){
        
    }

    public function add_customer(){
        $result = $this->customer_model->add_customer();
        $msg = "New customer was succesfully saved";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('customer/index/');
    }

    public function add_customer_walkin(){
        if($this->customer_model->check_duplicate_customer_walkin()){
            $msg = "Walkin Customer is existing";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('customer/call_customer_walkin/');
        }else{
            $result = $this->customer_model->add_customer_walkin();
            $msg = "Walkin Customer was succesfully saved";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('customer/call_customer_walkin/');
        }
       
    }

    public function edit_customer_company(){
        $result = $this->customer_model->edit_customer_company();
        $msg = "Company was succesfully updated";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('customer/call_customer_company/');
    }

}
