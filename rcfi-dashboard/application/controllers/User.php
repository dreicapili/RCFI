<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function __construct(){
    parent::__construct();

    if($this->session->userdata('id_user') == ''){
        redirect('login');
    } 

    $this->load->library('form_validation');
    $this->load->helper(array('form'));
    $this->load->model('user_model');
    $this->load->model('system_model');

    $config['upload_path']          = 'public/uploads/dp';
    $config['allowed_types']        = 'gif|jpg|png';
    $config['max_size']             = 0; // INFINIT 0
    $config['max_width']            = 0; // INFINIT 0
    $config['max_height']           = 0; // INFINIT 0

    $this->load->library('upload', $config);
	}
    
  public function profile()
	{
    $this->db->where('id_user',$_SESSION['id_user']);
    $result = $this->db->get('users');
    $data['users'] = $result->row();

		$this->load->view('dashboard/profile',$data);
  }
    
  public function edit_profile($id)
	{

    if($this->input->post()){
        $this->form_validation->set_rules('name','Name is required','required');
        $this->form_validation->set_rules('contact','Contact is required','required');
        $this->form_validation->set_rules('email','Email is required','required');
        $this->form_validation->set_rules('username','Usrname is required','required');
        $this->form_validation->set_rules('password','Password is required','required');
        $this->form_validation->set_rules('picture','Picture is required','required');
        $this->form_validation->set_rules('status','Status is required','required');

        $this->upload->do_upload('userfile');
        $data = array('upload_data' => $this->upload->data());
        $_POST['picture'] = $data['upload_data']['file_name'];

        //  print_r($this->input->post());die();

        $this->user_model->edit_user($this->input->post(),$id);

        redirect('user/profile');
    }
  }
  

  public function index()
	{
    $report_tbody = '';
    $report_all_gc = '';
    $report_all_cutoff = '';
    $report_genealogy = '';
    $report_left_right = '';
    $report_all_flushout = '';

    //SUMMARY GC
    $number_of_gc = '';
    $number_of_account = '';
    $paid_gc = '';
    $unpaid_gc = '';

    $cutoff_summary_overall = '';
    $flushout = '';

    $data = $this->system_model->dashboard_data_summary();
    $data['registered_accounts'] = $this->system_model->registered_accounts();
    $data['get_report_type'] = $this->system_model->get_report_type();
    $data['get_report'] = $this->system_model->get_report();

   

    $report_type = $this->input->post('report_type');
    $report = $this->input->post('report');
    $date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$account = $this->input->post('account');
    
    if(isset($report_type)){

    
      if($report_type == 'Detail'){
       
        // GIFT CHECK---------------------------------------------------------------------------------------------------------------
        if($report != ''){
          
          if($report == 'Gift Check'){

            $query_report = $this->system_model->report_gc();
            foreach($query_report as $table_report){
              $report_tbody = '
              <tr>
                <td>'.$table_report->name.'</td>
                <td>'.$table_report->gc_count.'</td>
                <td>'.$table_report->paid_gc.'</td>
                <td>'.$table_report->unpaid_gc.'</td>
              </tr>';
            }
           
          }else if($report == 'Cutoff'){
            $query_report = $this->system_model->report_cutoff();
            foreach($query_report as $table_report){
              $report_tbody = '
              <tr>
                <td>'.$table_report->name.'</td>
                <td>'.number_format($table_report->income,2).'</td>
                <td>'.$table_report->pay_status.'</td>
              </tr>';
            }
          }
         

        }else{
          
         
          // GIFT CHECK---------------------------------------------------------------------------------------------------------------
          $query_report = $this->system_model->report_gc();
          foreach($query_report as $table_report){
            $report_all_gc .= '
            <tr>
              <td>'.$table_report->name.'</td>
              <td>'.$table_report->gc_count.'</td>
              <td>'.$table_report->paid_gc.'</td>
              <td>'.$table_report->unpaid_gc.'</td>
            </tr>';
          }
        
          // die('xx2');
          // Flushout---------------------------------------------------------------------------------------------------------------
          $report_flushout = $this->system_model->report_flushout();
          foreach($report_flushout as $table_report){
            if($table_report->pairing_count > $table_report->setting){
              $report_all_flushout .= '
              <tr>
                <td>'.$table_report->name.'</td>
                <td>'.$table_report->pairing_count.' - (₱ '.number_format(($table_report->pairing_money - $table_report->gc) + ($table_report->gc * $table_report->membership_type_pairing),2).')</td>  
                <td>'.$table_report->flushout.' - (₱ '.number_format($table_report->flushout_money,2).')</td>
              </tr>';
            }
          } 
         
          // CUTOFF ---------------------------------------------------------------------------------------------------------------
          $query_report = $this->system_model->report_cutoff();
          foreach($query_report as $table_report){
            $report_all_cutoff .= '
            <tr>
              <td>'.$table_report->name.'</td>
              <td><button onclick="get_cutoff_details_by_account('.$table_report->id_registration.')" class="btn btn-primary" style="width:140px"> ₱ '.number_format($table_report->income,2).' </button></td>
              <td>'.$table_report->pay_status.'</td>
            </tr>';
          }
         
          // GENEALOGY ---------------------------------------------------------------------------------------------------------------
          $overall_genealogy = $this->system_model->overall_genealogy();
          foreach($overall_genealogy as $table_report){
            $report_genealogy .= '
            <tr>
              <td>'.$table_report->recruit_name.'</td>
              <td>'.$table_report->sponsor.'</td>
              <td>'.$table_report->replacement.'</td>
              <td>'.$table_report->position.'</td>
              <td>'.$table_report->dt.'</td>
            </tr>';
          }
         
          // Left/Right ---------------------------------------------------------------------------------------------------------------
          // $report_left_right_count = $this->system_model->report_left_right_count($account,$date_from,$date_to);
          $report_left_right_count = $this->system_model->leftRightNewProcess($account,$date_from,$date_to,'overall');
          $report_left_right .= '
          <tr>
            <td> '.$report_left_right_count['reference_nos'] . ' - '. $report_left_right_count['name'].'</td>
            <td>'.$report_left_right_count['left'].'</td>
            <td>'.$report_left_right_count['right'].'</td>
          </tr>';
         
        }
        
         
       
      }else if($report_type == 'Summary'){

        if($report != ''){

        }else{
          // GIFT CHECK---------------------------------------------------------------------------------------------------------------
          $query_gift_check_box_summary = $this->db->query("call gift_check_box_summary('$account','$date_from','$date_to')");
          mysqli_next_result($this->db->conn_id);
          foreach($query_gift_check_box_summary->result() as $row){
            $number_of_gc = $row->number_of_gc;
            $number_of_account = $row->number_of_account;
            $paid_gc = $row->paid_gc;
            $unpaid_gc = $row->unpaid_gc;
          }
          // Cutoff ---------------------------------------------------------------------------------------------------------------
          $cutoff_summary_overall = $this->system_model->cutoff_summary_overall($account,$date_from,$date_to,'');
          // mysqli_next_result($this->db->conn_id);
          // print_r($query_gift_check_box_summary->result());die();

          // Flushout ---------------------------------------------------------------------------------------------------------------
          $flushout = $this->system_model->flushout($date_from,$date_to,$account);
        }

      }

     
    }

    
   

    $data['report'] =  array(
      'report_tbody'=> $report_tbody,
      'report_all_gc'=> $report_all_gc,
      'report_all_cutoff'=> $report_all_cutoff,
      'report_genealogy'=> $report_genealogy,
      'report_left_right'=> $report_left_right,
      'report_all_flushout'=> $report_all_flushout,

      // SUMMARY GC
      'number_of_gc'=>$number_of_gc,
      'number_of_account'=>$number_of_account,
      'paid_gc'=>$paid_gc,
      'unpaid_gc'=>$unpaid_gc,

      // CUTOFF
      'cutoff_summary_overall'=>$cutoff_summary_overall,
      'flushout'=>$flushout,
      
      'report_type'=> $report_type,
      'report'=> $report,
      'date_from'=> $date_from,
      'date_to'=> $date_to,
      'account'=> $account,
    );

    $this->load->view('dashboard/index',$data);
  }

  public function report_fetch_data(){
    $data = $this->system_model->report_fetch_data();
  }

}
