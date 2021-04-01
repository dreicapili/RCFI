<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends CI_Controller {
  
    public function __construct(){    
        parent::__construct();
        $this->load->library('form_validation');  
        $this->load->library('upload'); 
        $this->load->model('system_model');
        $this->load->model('unit_model');
         
 
        if($this->session->userdata('id_user') == ''){
            redirect('login');
        } 
    }

    public function account_management()
	{
		$data['registration_list'] = $this->system_model->registration_list();
		$this->load->view('dashboard/account-management',$data);
    }

    public function banned_accounts()
	{
		$data['get_banned_accounts'] = $this->system_model->get_banned_accounts();
		$this->load->view('dashboard/banned-accounts',$data);
    }
	
	public function view_account($id,$date = NULL)
	{
        $_POST['id_acc_recruiter'] = $id;
        $data = $this->system_model->view_account($id,$date);
        $data['query_account_genealogy'] = $this->system_model->fetch_reg_account_for_replacement('for_acc_geneology',$id,$data['get_tuesday'],$data['get_monday']);
        
        $data['get_province'] = $this->system_model->get_province();
        $data['get_gender'] = $this->system_model->get_gender();
        $data['get_civil_status'] = $this->system_model->get_civil_status();
        $data['registered_accounts'] = $this->system_model->registered_accounts();

        $data['leftRight'] = $this->system_model->leftRightNewProcess($id,'2020-04-26',date('Y-m-d'),'overall');
        
		$this->load->view('dashboard/view-accounts',$data);
    }

    public function cutoff($date)
	{
        $data = $this->system_model->cutoff($date);
        // print_r($data);die();
		$this->load->view('dashboard/cutoff',$data);
    }

    public function giftcheck($date)
	{
        $data = $this->system_model->giftcheck($date);
        // print_r($data);die();
		$this->load->view('dashboard/gift-check.php',$data);
    }

    public function redeem_gc($date)
	{
        $data = $this->system_model->redeem_gc();

        $msg = $data;
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','warning');
        redirect('controller/giftcheck/'.$date);
    }

    public function flushout()
	{
        // $data = $this->system_model->cutoff($date);
        // print_r($data);die();
        $data['registered_accounts'] = $this->system_model->registered_accounts();
		$this->load->view('dashboard/flushout',$data);
    }

    public function flushout_data(){
        $data = $this->system_model->flushout_data();
        echo json_encode($data);
    }

    public function cutoff_update_payment(){
        $data = $this->system_model->cutoff_update_payment();
        echo 'Successfully update the payment status';
    }

    public function cutoff_update_payment_multiple(){
        $data = $this->system_model->cutoff_update_payment_multiple();
        echo 'Successfully update the payment status';
    }

    public function get_cutoff_details_by_account(){
        $data = $this->system_model->get_cutoff_details_by_account();
        echo json_encode($data);
    }

    public function report_income_account_list(){
        $data = $this->system_model->report_income_account_list();
        echo json_encode($data);
    }

    public function report_gc_by_account(){
        $data = $this->system_model->report_gc_by_account();
        echo json_encode($data);
    }
	
	public function create_payout()
	{
		$this->load->view('dashboard/create-payout');
    }



    public function account_registration($id)
	{
        
        // $data = $this->system_model->get_list_account_for_pairing_commision();
        // print_r($data[0]['list_of_account']);die();
        if($id == 0){
            $data = $this->system_model->get_reference_number_count();
        }else{
            $data = $this->system_model->get_account_details_for_edit($id);
        }
       
        
        
        $data['membership_type'] = $this->system_model->membership_type();
        $data['get_province'] = $this->system_model->get_province();
        $data['get_gender'] = $this->system_model->get_gender();
        $data['get_civil_status'] = $this->system_model->get_civil_status();
        $data['registered_accounts'] = $this->system_model->registered_accounts();
        $data['unique_registered_accounts'] = $this->system_model->unique_registered_accounts();
		$this->load->view('dashboard/account-registration',$data);
    }
    
    public function fetch_reg_account_for_replacement(){
        $type = 'fetch_reg_account_for_replacement';
        $account = $this->input->post('id_acc_recruiter');
        $date_from = '';
        $date_to = '';
        $data = $this->system_model->fetch_reg_account_for_replacement($type,$account,$date_from,$date_to);
        echo json_encode($data);
    }

    public function fetch_acc_primary_details()
	{
        $data = $this->system_model->fetch_acc_primary_details();
        echo json_encode($data);
    }

	public function fetch_registered_account_by_id()
	{
        $data = $this->system_model->fetch_registered_account_by_id();
        echo json_encode($data);
    }

    public function get_self_account()
	{
        $data = $this->system_model->get_self_account();
        echo json_encode($data);
    }

    public function select_city()
	{
        $data = $this->system_model->select_city();
        echo json_encode($data);
    }

    public function select_barangay()
	{
        $data = $this->system_model->select_barangay();
        echo json_encode($data);
    }
	
	public function max_income()
	{
		$this->load->view('dashboard/settings-max-income');
    }

    public function membership_type()
	{
        $data['membership_type'] = $this->system_model->membership_type();
		$this->load->view('dashboard/settings-membershipe-type',$data);
    }
	
	public function get_membership_type_value_by_id()
	{
        $data = $this->system_model->get_membership_type_value_by_id();
		echo json_encode($data);
    }

    public function register_account(){
        $result = $this->system_model->register_account();
        $msg = "New account was registered successfullly";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('controller/account_management/');
    }

    public function register_account_alternative(){
        $data = $this->system_model->register_account_alternative();
        $msg = "New account was registered successfullly";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        // redirect('controller/account_management/');
        return $data;
    }

    public function update_account($id){
        // print_r($this->input->post());
        $this->system_model->update_account($id);
        $msg = "Account was updated successfullly";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('controller/view_account/'.$id.'/'.date("Y-m-d"));
    }

    public function add_profile_picture($id){

        $upload_path = 'public/uploads/dp/'; 
        $allowed_types = 'gif|jpg|jpeg|png|GIF|JPG|PNG|JPEG';

        // print_r($this->input->post());die('haha');
        // print_r($_FILES['files']['name']);die('haha');

        if(!empty($_FILES['files']['name'])){
            $filesCount = count($_FILES['files']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
                
                // File upload configuration
                $config['upload_path']          = $upload_path;
                $config['allowed_types']        = $allowed_types;
                $config['max_size']             = 0; // INFINIT 0
                $config['max_width']            = 0; // INFINIT 0
                $config['max_height']           = 0; // INFINIT 0
                
                // Load and initialize upload library
                // $this->load->library('upload', $config);
                $this->upload->initialize($config);
                
                // Upload file to server
                if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");

                    $result = 'success';
                }else{
                    $result = 'error';
                }
            }
		}else{
            $result = 'no_files_selected';
        }

        if($result = 'success'){
            // print_r($this->input->post());
            $file_name = implode('|',$_FILES['files']['name']);
            $this->system_model->add_profile_picture($file_name,$id);
            $msg = "Account was updated successfullly";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('controller/view_account/'.$id.'/'.date("Y-m-d"));
        }else if($result = 'error' || $result = 'no_files_selected'){
            $msg = "Something went wrong! Try Again";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('controller/view_account/'.$id.'/'.date("Y-m-d"));
        }


    }

    public function staff_mngt()
	{
        $data['get_staff_list'] = $this->system_model->get_staff_list();
		$this->load->view('dashboard/staff-mngt',$data);
    }

    public function get_account_to_ban()
	{
        $data = $this->system_model->get_account_to_ban();
		echo json_encode($data);
    }

    public function ban_account()
	{
        $data = $this->system_model->ban_account();
        $msg = "Account was remove successfully in the system";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('controller/account_management/');
    }

    public function unban_account()
	{
        $data = $this->system_model->unban_account();
        $msg = "Account was unban successfully in the system";
        $this->session->set_userdata('acctg_msg',$msg);
        $this->session->set_userdata('acctg_msg_type','success');
        redirect('controller/account_management/');
    }
	
	public function staff_bin()
	{
        $data['get_staff_bin_list'] = $this->system_model->get_staff_bin_list();
		$this->load->view('dashboard/staff-bin',$data);
    }

    public function edit_staff(){
        if($this->system_model->check_duplicate_staff()){
            $msg = "Error: Email or Contact number is already used by other user";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('controller/staff_mngt/');
        }else{
            $this->input->post('id_users');
            $result = $this->system_model->edit_staff();
            $msg = "Staff account was successfully updated";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('controller/staff_mngt/');
        }
    }


	
    public function save_membership_type(){
        if($this->system_model->check_duplicate_membership_type()){
            $msg = "Membership type is already existing";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('controller/membership_type/');
        }else{
            $result = $this->system_model->save_membership_type();
            $msg = "New Membership type was succesfully saved";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('controller/membership_type/');
        }
    }

    public function add_staff(){
        if($this->system_model->check_duplicate_staff()){
            echo 'false';
        }else{
            $this->input->post('id_users');
            $result = $this->system_model->add_staff();
            $msg = "New staff was succesfully saved";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');

            echo 'true';
        }
    }

    public function delete_staff(){
        $this->system_model->delete_staff();
    }

    public function delete_membership_type(){
        $this->system_model->delete_membership_type();
    }



    public function for_edit_staff_data(){
        $query = $this->system_model->for_edit_staff_data();
        echo json_encode($query);
    }



    public function update_display_profile(){

        $config['upload_path']          = 'public/uploads/dp/';
        $config['allowed_types']        = 'gif|jpg|jpeg|png|GIF|JPG|PNG|JPEG';
        $config['max_size']             = 0; // INFINIT 0
        $config['max_width']            = 0; // INFINIT 0
        $config['max_height']           = 0; // INFINIT 0

        $this->upload->initialize($config); 

        if($this->upload->do_upload())
        {
            // IMAGE UPLOADED SUCCESSFULLY
            $data = array('upload_data' => $this->upload->data());

            $this->system_model->update_display_profile($data['upload_data']['file_name']);
            $msg = "Display picture was succesfully updated";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('user/profile/');
        }
        else
        {
            // FAILED TO UPLOAD PRODUCT IMAGE
            $msg = "There was a problem uploading product image";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('user/profile/');
        }
    }

    public function update_user_account(){
        if($this->system_model->check_duplicate_user_acc()){
            $msg = "Maybe mobile number or email is already used by the other user";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('user/profile/');
        }else{
            $result = $this->system_model->update_user_account();

            $_SESSION['accounts_id'] = $this->input->post('accounts_id');
            $_SESSION['first_name'] = $this->input->post('first_name');
            $_SESSION['middle_name'] = $this->input->post('middle_name');
            $_SESSION['last_name'] = $this->input->post('last_name');
            $_SESSION['email'] = $this->input->post('email');
            $_SESSION['contact'] = $this->input->post('contact');
            $_SESSION['username'] = $this->input->post('username');

            $msg = "Your account was succesfully updated";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','success');
            redirect('user/profile/');
        } 
    }

    public function update_account_password(){
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_password');

        // die(password_unhash($_SESSION['password'], PASSWORD_DEFAULT));
        // die(password_hash('password', PASSWORD_DEFAULT));
        
        if(!password_verify($current_password,$_SESSION['password'])){
            $msg = "Please check your current password";
            $this->session->set_userdata('acctg_msg',$msg);
            $this->session->set_userdata('acctg_msg_type','danger');
            redirect('user/profile/');
        }else{
            if($new_password != $confirm_password){
                $msg = "Password don't match";
                $this->session->set_userdata('acctg_msg',$msg);
                $this->session->set_userdata('acctg_msg_type','danger');
                redirect('user/profile/');
            }else{
                $result = $this->system_model->update_account_password($new_password);
                $msg = "Account password was succesfully updated";
                $this->session->set_userdata('acctg_msg',$msg);
                $this->session->set_userdata('acctg_msg_type','success');
                redirect('user/profile/');
            }
        }
    }


}
