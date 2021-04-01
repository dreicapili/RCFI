<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('mod_Login');
        $this->load->library('form_validation');
        // die($this->session->userdata('id_user'));


    }

    public function logout(){
        $this->session->sess_destroy();
        //redirect for CONTROLLER VIEW
        // die('haha');
        redirect('login/');
    }
	
	public function login()
	{
        if($this->input->post()){
          

            $this->form_validation->set_rules('username','Username is required','required');
            $this->form_validation->set_rules('password','Password is required','required');

            if($this->input->post('username'))
            {
                
                $is_match = 0;

                $users = $this->mod_Login->verify_username($this->input->post('username'));

                if(count($users) <= 0){ 
                    $this->session->set_flashdata('error','Cannot Find User');
                    redirect('login');
                }


                foreach($users as $user){
                    if(password_verify($this->input->post('password'),$user->password)){

                        $is_match = 1;
                        $user_sess = array(
                            'id_user' => $user->id_user,
                            'first_name' => $user->first_name,
                            'middle_name' => $user->middle_name,
                            'last_name' => $user->last_name,
                            'contact' => $user->contact,
                            'email' => $user->email,
                            'username' => $user->username,
                            'password' => $user->password,
                            'picture' => $user->picture,
                            'status' => $user->status,
                            'type' => $user->type
                        );

                        $_SESSION['vendor_count'] = $this->mod_Login->vendor_count();


                
                        $this->session->set_userdata($user_sess);

                        if($is_match == 1){
                            $this->session->set_flashdata('success','Welcome '.$user->username);
                            // print_r($this->session->all_userdata());die();
                            redirect('user');
                        }

                    }
                }

                if($is_match <= 0){
                    $this->session->set_flashdata('error','Username and Password mismatch');
                    redirect('login/index');
                }


            }else{
                $this->session->set_flashdata('error','Username and Password mismatch');
                redirect('login/index');
            }



        }else{
            $this->session->set_flashdata('error','Username and Password mismatch');
            redirect('login/index');
        }
        


        
        // print_r($this->input->post());die();
    }
    
    public function index()
	{
        if($this->session->userdata('id_user') != ''){
            redirect('user');
        }else{
            $this->load->view('login');
        }

       
	}
}
