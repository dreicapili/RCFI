<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Giftcheck extends CI_Controller {
  
    public function __construct(){    
        parent::__construct();
        if($this->session->userdata('id_user') == ''){
            redirect('login');
        } 
    }

  public function print_check()
	{
    $this->load->view('dashboard/print-check');
  }



}
