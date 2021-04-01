<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
 
    public function __construct(){ 
        parent::__construct();
        $this->load->library('form_validation'); 
        $this->load->library('upload');
        $this->load->model('test_model');
    }

    public function index(){
        $data = $this->test_model->test();
        echo $data;
    }


}
