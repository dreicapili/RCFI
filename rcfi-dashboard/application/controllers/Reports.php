<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('report_model');

        if($this->session->userdata('id_user') == ''){
            redirect('login');
        }
    }
    
    public function goTopEarners()
	{
		$this->load->view('dashboard/top-earners');
    }

    public function getTopEarners()
	{
        $data['top_earners'] = $this->report_model->getTopEarners();
		$this->load->view('dashboard/top-earners',$data);
    }

}
