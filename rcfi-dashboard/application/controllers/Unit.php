<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('unit_model');

        if($this->session->userdata('id_user') == ''){
            redirect('login');
        }
	}
	
	public function index()
	{
        $data['get_unit_list'] = $this->unit_model->get_unit_list();
		$this->load->view('dashboard/unit',$data);
    }

    public function view_unit($id_unit)
	{
        $data = $this->unit_model->view_unit($id_unit);
        $data['get_rooms_list'] = $this->unit_model->get_rooms_list($id_unit);
		$this->load->view('dashboard/view-unit',$data);
    }

    public function delete_unit(){
        $this->unit_model->delete_unit();
    }
    
    public function add_unit(){
        if($this->unit_model->check_duplicate_unit()){
            $msg = "Unit is already existing, try another again";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('unit/index/');
        }else{
            $result = $this->unit_model->add_unit();
            $msg = "Unit was succesfully saved";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('unit/index/');
        }
    }

    public function for_edit_room_data(){
        $query = $this->unit_model->for_edit_room_data();
        echo json_encode($query);
    }

    public function add_rooms($id_unit){
        if($this->unit_model->check_duplicate_rooms($id_unit)){
            $msg = "Room is already existing, try another again";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('unit/view_unit/'.$id_unit);
        }else{
            $result = $this->unit_model->add_rooms($id_unit);
            $msg = "Room was succesfully saved";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('unit/view_unit/'.$id_unit);
        }
    }

    public function edit_rooms($id_unit){
        if($this->unit_model->check_duplicate_rooms_edit($id_unit)){
            $msg = "E is already existing, try another again";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('unit/view_unit/'.$id_unit);
        }else{
            $result = $this->unit_model->edit_rooms();
            $msg = "Room was succesfully updated";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('unit/view_unit/'.$id_unit);
        }
    }

}
