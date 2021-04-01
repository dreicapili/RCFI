<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailNotif extends CI_Controller {

  public function __construct(){
      parent::__construct();
      $this->load->helper('email');
      $this->load->helper('security'); 
	}

  public function receive_email()
  {
      $type = $this->input->post('type');

      $this->form_validation->set_rules('full_name', 'Full name', 'trim|required|xss_clean');
      $this->form_validation->set_rules('contact', 'Contact Number', 'trim|required|xss_clean');
      $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
      $this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

      if ($this->form_validation->run() == FALSE) {
        $data = array(
          'full_name' => $this->input->post('full_name'),
          'contact' => $this->input->post('contact'),
          'email' => $this->input->post('email'),
          'message' => $this->input->post('message'),
        );

        
        if($type == 'contact'){
          $this->load->view('front/contact',$data);
        }else{
          $this->load->view('front/inquire',$data);
        }

      }else{

       
        $full_name = $this->input->post('full_name');
        $contact = $this->input->post('contact');
        $email = $this->input->post('email');
        $message = $this->input->post('message');
  
        $to =  'rcfifoodsupplementtrading@gmail.com';  // User email pass here
        
        if($type == 'contact'){
          $subject = 'New Message from the website';
        }else{
          $subject = 'NutriRich Package - Inquiry From the Website';
        }
       
    
        $from = 'info@rcouragefaithinspire.com';              // Pass here your mail id
    
        $emailContent = '<h1><b>Inquiry Details</b></h1>
        <br>
        <p>Full name: '.$full_name.'</p>
        <p>Contact Number: '.$contact.'</p>
        <p>Email: '.$email.'</p>
        <p>Message: '.$message.'</p>
        ';
                  
        $config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://mail.rcouragefaithinspire.com'; // ssl://smtp.gmail.com //hostinger
        $config['smtp_port']    = '465'; //465 //587
        $config['smtp_timeout'] = '60';
    
        $config['smtp_user']    = 'info@rcouragefaithinspire.com';    //Important
        $config['smtp_pass']    = '#in@4df3';  //Important
    
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
    
         
    
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->from($from);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($emailContent);
        $this->email->send();
    
        // $this->session->set_flashdata('msg',"Mail has been sent successfully to ()");
        // $this->session->set_flashdata('msg_class','alert-success');

        $msg = "Mail has been sent successfully";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
  
        if(! $this->email->print_debugger()){
          show_error($this->email->print_debugger());
          // echo 'Email not send';
        }else{
          // echo 'sended successfully';
        }
       
        if($type == 'contact'){
          return redirect('front/contact');
        }else{
          return redirect('front/inquire');
        }
       
      }


  }
  

}
