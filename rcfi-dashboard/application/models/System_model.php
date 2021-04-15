<?php

class System_model extends MY_Model{  

    function check_duplicate_staff(){
        $id_user = $this->input->post('id_user');
        $email = $this->input->post('email'); 
        $contact = $this->input->post('contact');
        $result = $this->db->query("SELECT id_user FROM users 
        WHERE (email='$email' OR contact='$contact' ) AND del_status = 1 AND id_user != '$id_user' AND type != 0 ");
        if($result-> num_rows() > 0){
            return true;
        }else{ 
            return false;
        } 
	}   
	
	function dashboard_data_summary(){ 
    $result = $this->db->query("SELECT COUNT(id_registration) AS 'registered_accounts',
		(SELECT COUNT(id_user) FROM users WHERE type != 0 AND del_status = 1) as 'staff_accounts',
		(SELECT SUM(cash) FROM main_money WHERE id_main != 1 AND type != 'gift_check' AND  del_status=1) as 'expense'
		FROM registration WHERE del_status = 1");

		$date_ = date('Y-m-d');
		$id_main_ = 0;
		$type_ = 0;//0 SUM //1 SELECT ALL //SELECT BY ID

		$query_overall_income = $this->db->query("call overall_income_by_account('$date_',$id_main_,$type_,'$date_')");
		mysqli_next_result($this->db->conn_id);
		$row_oi =  $query_overall_income->result_array();
		$overall_income = $row_oi[0]['overall_income'];


		foreach($result->result() as $table_row){
			return array(
				'registered_accounts' => $table_row->registered_accounts,
				'staff_accounts' => $table_row->staff_accounts,
				'overall_income' => $overall_income,
				'expense' => $table_row->expense,
			);
		}
       
	}
	
	public function leftRightNewProcess($id,$date_from = NULL,$date_to,$result_type){
		$left = 0;
		$right = 0;
		$reference_nos = '';
		$name = '';
		$type = 'fetch_reg_account_for_replacement';

		$result = $this->db->query("SELECT s.id_acc_recruit, s.id_main_position, reg.reference_nos, CONCAT(last_name,', ',first_name,' ',middle_name) as 'name'  
		FROM `sponsorship`s 
		INNER JOIN registration reg ON reg.id_registration = s.`id_acc_recruiter` OR reg.id_registration = s.`id_acc_replacement` 
		
		WHERE (s.id_acc_recruiter = '$id' or s.id_acc_replacement = '$id') AND
		s.del_status=1
		GROUP BY `id_acc_recruit`
		ORDER BY s.dt ASC LIMIT 2");
		

		if($result -> num_rows() > 0){

			foreach($result->result() as $row){
				$reference_nos = $row->reference_nos;
				$name = $row->name;
				if($row->id_main_position == 0){ // LEFT
					$left = count( $this->system_model->fetch_reg_account_for_replacement($type, $row->id_acc_recruit ,$date_from,$date_to) );
				}

				if($row->id_main_position == 1){ // LEFT
					$right = count( $this->system_model->fetch_reg_account_for_replacement($type, $row->id_acc_recruit ,$date_from,$date_to) );
				}
			}

		}
	

		return array(
			'reference_nos' => $reference_nos,
			'name' 			=> $name,
			'left' 			=> $left + 1,
			'right' 		=> $right + 1
		);
	}

	public function main_logic($id,$date_from = NULL,$date_to,$result_type){
		/*
		RESULT TYPE
			1. OVERALL
			2. DAILY
		*/

		//GET ACCOUNTS
		$this->load->model('registration_model');
		$query = $this->registration_model->account_byId($id);
		if($query -> num_rows() > 0){

			//CALL TEMPORARY TABLE
			$this->db->query('DROP TABLE IF EXISTS TempTable');
			$this->db->query('CALL temp_tbl_lr()');

			//GET LEFT AND RIGHT OF EACH ACCOUNT PER DAY AND INSERT IN TEMP TABLE
			foreach($query->result() as $account){
				$set_id = $account->id_registration;
				if($id != ''){
					$set_id = $id;
				}
				$ids = $this->pyramid_logic($set_id);//GET ACCOUNTS GROUP

				$data['lr'] = $this->get_LR($ids, $account->id_registration, $account->reference_nos, $account->name, $date_from, $date_to); //GET LEFT AND RIGHT
				// print_r($data['lr']);die();
				for($i=0; $i<count($data['lr']); $i++){
					$this->db->insert("temp_tbl_lr",$data['lr'][$i]);
				}
			}
			$result = $this->db->get("temp_tbl_lr");
			if($result_type == 'overall'){
				$this->db->select("lr.id, lr.name, lr.reference_nos, lr.date, 
				(SELECT SUM(left_) temp_tbl_lr WHERE id = lr.id ) as 'left_' ,
				(SELECT SUM(right_) temp_tbl_lr WHERE id = lr.id ) as 'right_' ,
				");
				$this->db->group_by("lr.id");
				$result = $this->db->get("temp_tbl_lr lr");
			}else{
				$result = $this->db->get("temp_tbl_lr");
			}
			return $result;
		}
	}

	public function get_LR($ids, $id, $reference_nos, $name, $date_from, $date_to){
		$data = [];
		$_SESSION['date_from'] = $date_from;
		$_SESSION['days_count']= ($this->customlib->get_days_count($_SESSION['date_from'],$date_to) + 1); //PLUS 1 DAY

		$_SESSION['rep_count_left'] = 0;
		$_SESSION['rep_count_right'] = 0;
		$_SESSION['rep_pairing_cash'] = 0;
		$_SESSION['rep_count_pairing'] = 0;
		$_SESSION['rep_commision_cash'] = 0;
		$_SESSION['rep_commision_count'] = 0;
		$_SESSION['rep_gc'] = 0;
		$_SESSION['rep_flushout_cash'] = 0;
		$_SESSION['rep_flushout'] = 0;
		$_SESSION['rep_total_income'] = 0;

		do {

			//GET LEFT
			$this->db->select(" COUNT(a.id_sponsorship) as 'count' ");
			$this->db->where("CAST(a.dt as DATE)  BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_from]'");
			$this->db->where("(a.id_acc_recruit IN ($ids) OR a.id_acc_recruit = $id) ");
			$this->db->where(" a.id_acc_recruit !=",$id);
			$this->db->where(" a.id_main_position ",0);
			$this->db->where('a.del_status',1);
			$query_left = $this->db->get('sponsorship as a');
			$row_left = $query_left->result_array();
			$count_left = $row_left[0]['count'];
			// die($this->db->last_query());
	
			//GET RIGHT
			$this->db->select(" COUNT(a.id_sponsorship) as 'count' ");
			$this->db->where("CAST(a.dt as DATE)  BETWEEN '$_SESSION[date_from]' AND '$_SESSION[date_from]'");
			$this->db->where("(a.id_acc_recruit IN ($ids) OR a.id_acc_recruit = $id) ");
			$this->db->where(" a.id_acc_recruit !=",$id);
			$this->db->where(" a.id_main_position ",1);
			$this->db->where('a.del_status',1);
			$query_right = $this->db->get('sponsorship as a');
			$row_right = $query_right->result_array();
			$count_right = $row_right[0]['count'];


			$x = date("l", strtotime($_SESSION['date_from']));
			// die($x);

			if($x == 'Saturday' || $x == 'Sunday' || $x == 'Monday'){//SATURDAY, SUNDAY, MONDAY (COMBILE STATS)
				$_SESSION['rep_count_left'] = $_SESSION['rep_count_left'] + $count_left;
				$_SESSION['rep_count_right'] = $_SESSION['rep_count_right'] + $count_right;
			}

			if($x != 'Saturday' || $x != 'Sunday'){// IF SATURDAY AND SUNDAY DONT SAVE IN TEMPORARY DB
				if($x == 'Monday'){// IF MONDAY THEN SAVE IT TO DISPLAY
					array_push($data,
						array(
							'id'				=> $id,
							'reference_nos'		=> $reference_nos,
							'name'				=> $name,
							'date'				=> $_SESSION['date_from'],
							'left_'				=> $_SESSION['rep_count_left'],
							'right_'			=> $_SESSION['rep_count_right'],
						)
					);
					$_SESSION['rep_count_left'] = 0;
					$_SESSION['rep_count_right'] = 0;
					
				}else{
					array_push($data,
						array(
							'id'				=> $id,
							'reference_nos'				=> $reference_nos,
							'name'				=> $name,
							'date'				=> $_SESSION['date_from'],
							'left_'				=> $count_left,
							'right_'			=> $count_right,
						)
					);
				}
			}

			$_SESSION['days_count'] = $_SESSION['days_count']  - 1;//LOOP UNTIL DAYS DURATION IS DOWN TO ZERO(0)
			$_SESSION['date_from'] = date('Y-m-d',strtotime($_SESSION['date_from'] . "+1 days"));//EVERY LOOP ADD + 1 TO DATE 

		}while($_SESSION['days_count'] > 0);//KAPAG MALIIT NA SA ZERO STOP NA ANG LOOP
		// print_r($data);die();
		return $data;
	}

    function check_duplicate_membership_type(){
        $id_set_membership_type = $this->input->post('id_set_membership_type');
        $code = $this->input->post('code');
        $type = $this->input->post('type');
        $result = $this->db->query("SELECT id_set_membership_type FROM set_membership_type 
        WHERE (code='$code' OR type='$type' ) AND del_status = 1 AND id_set_membership_type != '$id_set_membership_type' ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
	
	public function get_list_account_for_pairing_commision($id_acc_recruiter,$id_acc_replacement){
		$query = $this->db->query("call get_list_account_for_pairing_commision($id_acc_recruiter,$id_acc_replacement)");
		mysqli_next_result($this->db->conn_id);
		return $query->result_array();



		// //IWAS ERROR SA OUT OF SYNC
		// $conn = $this->db->conn_id;
		// do {
		// 	if ($result = mysqli_store_result($conn)) {
		// 		mysqli_free_result($result);
		// 	}
		// } while (mysqli_more_results($conn) && mysqli_next_result($conn));
	}

	public function get_reference_number_count(){
		$query = $this->db->query("SELECT (count(id_registration) + 1001) as 'ref_code' from registration");
		foreach($query->result() as $table_row){
			return array(
				'ref_code'=>$table_row->ref_code,
			);
		}
	}

	public function get_account_details_for_edit($id){
		$query = $this->db->query("SELECT * FROM registration a WHERE a.id_registration = '$id' AND a.del_status=1");
		foreach($query->result() as $table_row){
			return array(
				'id_set_membership_type'=>$table_row->id_set_membership_type,
				'reference_nos'=>$table_row->reference_nos,
				'last_name'=>$table_row->last_name,
				'first_name'=>$table_row->first_name,
				'middle_name'=>$table_row->middle_name,
				'id_main_address_province'=>$table_row->id_main_address_province,
				'id_main_address_city'=>$table_row->id_main_address_city,
				'id_main_address_barangay'=>$table_row->id_main_address_barangay,
				'bday'=>$table_row->bday,
				'bplace'=>$table_row->bplace,
				'id_main_gender'=>$table_row->id_main_gender,
				'id_main_civil_status'=>$table_row->id_main_civil_status,
				'contact'=>$table_row->contact,
				'email'=>$table_row->email,
				'sss'=>$table_row->sss,
				'tin'=>$table_row->tin,
				'occupation'=>$table_row->occupation,
				'spouse'=>$table_row->spouse,
				'spouse_contact'=>$table_row->spouse_contact,
			);
		}
	}
	
	function get_membership_type_value_by_id(){
		$id_set_membership_type = $this->input->post('id');
		$result = $this->db->query("SELECT 
		b.cash as 'membership_type_amount',
		c.cash as 'membership_type_commission',
		d.cash as 'membership_type_pairing',
		(SELECT setting FROM settings WHERE type = 'account_limit' AND del_status = 1) as 'account_limit' 
		
		FROM set_membership_type a
		INNER JOIN main_money_membership_fee b ON a.id_set_membership_type = b.id_main AND b.type='membership_type_amount'
		INNER JOIN main_money_membership_fee c ON a.id_set_membership_type = c.id_main AND c.type='membership_type_commission'
		INNER JOIN main_money_membership_fee d ON a.id_set_membership_type = d.id_main AND d.type='membership_type_pairing'
		WHERE a.del_status = 1 AND a.id_set_membership_type = '$id_set_membership_type' ");
		return $result->result(); 
	}

	function add_staff(){
		unset($_POST['id_user']);
		$_POST['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
		$result = $this->db->insert('users',$this->input->post());
	}

	function save_membership_type(){
		//FOR MONEY
		$amount  = $this->input->post("amount");
		$commission  = $this->input->post("commission");
		$pairing  = $this->input->post("pairing");
		$type = 'membership_type_amount';
		
		unset($_POST['id_set_membership_type']);
		unset($_POST['amount']);
		unset($_POST['commission']);
		unset($_POST['pairing']);

		//SAVE MEMBERSHIP TYPE
		$result = $this->db->insert('set_membership_type',$this->input->post());
		$last_id = $this->db->insert_id();
		
		//SAVE MONEY
		if($amount != 0){
			$type_amt[] = array(
				'id_main' => $last_id,
				'type' => 'membership_type_amount',
				'cash' => $amount,
			);
		}
		
		if($commission != 0){ 
			$type_amt[] = array(
				'id_main' => $last_id,
				'type' => 'membership_type_commission',
				'cash' => $commission,
			);
		}
		
		if($pairing != 0){
			$type_amt[] = array(
				'id_main' => $last_id,
				'type' => 'membership_type_pairing',
				'cash' => $pairing,
			);
		}
		for($x = 0; $x < count($type_amt); $x++){
			$this->db->insert('main_money_membership_fee',$type_amt[$x]);
		}
		return 'success';
		
		//$result = $this->db->query("INSERT INTO main_money(id_main,cash,type)
		//VALUES('$last_id','$cash','$type')");
		
    }
	
	public function membership_type(){
		$type = 'membership_type_amount';
		$query = $this->db->query("SELECT a.*,b.cash as 'amount',c.cash as 'commission',d.cash as 'pairing' FROM set_membership_type a
		LEFT JOIN main_money_membership_fee b ON a.id_set_membership_type = b.id_main AND b.type='membership_type_amount' AND b.del_status = 1
		LEFT JOIN main_money_membership_fee c ON a.id_set_membership_type = c.id_main AND c.type='membership_type_commission' AND c.del_status = 1
		LEFT JOIN main_money_membership_fee d ON a.id_set_membership_type = d.id_main AND d.type='membership_type_pairing' AND d.del_status = 1
		WHERE a.del_status = 1");
        return $query->result(); 
	}

	function edit_staff(){
		$id_user = $_POST['id_user'];
		unset($_POST['id_user']);
		$_POST['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

		$this->db->where("id_user",$id_user);
		$result = $this->db->update('users',$this->input->post());
	}

	public function get_staff_list(){
		$this->db->where('del_status',1);
		$this->db->where('type',1);
		$query = $this->db->get('users');
		return $query->result(); 
	}
	
	public function get_account_to_ban(){
		$id_registration = $this->input->post('id_registration');
        $query = $this->db->query("SELECT id_registration,CONCAT(last_name,', ',first_name,' ',middle_name) as 'name' 
		FROM registration WHERE id_registration = '$id_registration'");
        return $query->result(); 
	}
	
	public function ban_account(){
		$id_registration = $this->input->post('id_registration');
		$remarks = $this->input->post('remarks');

		//UPDATE STATUS IN REGISTTRATION
		$this->db->query("UPDATE registration SET del_status=0 
		WHERE id_registration='$id_registration'");

		//UPDATE STATUS IN SPONSORSHIP
		$this->db->query("UPDATE sponsorship SET del_status=0 
		WHERE id_acc_recruit='$id_registration'");

		//UPDATE STATUS OF MONEY
		$query_money = $this->db->query("SELECT id_sponsorship FROM sponsorship WHERE id_acc_recruit='$id_registration'");
		$row = $query_money->result_array();
		$id_sponsorship = $row[0]['id_sponsorship'];

		$this->db->query("UPDATE main_money SET del_status=0 
		WHERE id_sponsorship='$id_sponsorship'");

		$this->db->query("INSERT INTO banned_accounts(id_registration,remarks)
		VALUES('$id_registration','$remarks')");
	}
	
	public function unban_account(){
		$id_registration = $this->input->post('id');

		$query = $this->db->query("UPDATE registration SET del_status=1 
		WHERE id_registration='$id_registration'");

		$query = $this->db->query("UPDATE banned_accounts SET del_status=0 
		WHERE id_registration='$id_registration'");

    }
	
	public function get_staff_bin_list(){
		$this->db->where('del_status',0);
		$this->db->where('type',1);
		$query = $this->db->get('users');
		return $query->result(); 
	}

	public function delete_staff(){
		$id_user = $_POST['id'];
		$this->db->query("UPDATE users SET del_status=0 WHERE id_user='$id_user' ");
	}

	public function delete_membership_type(){
		$id_set_membership_type = $_POST['id'];
		$this->db->query("UPDATE set_membership_type SET del_status=0 WHERE id_set_membership_type='$id_set_membership_type' ");
	}


	public function for_edit_staff_data(){
		$id_user = $this->input->post('id_user');
		$this->db->where('id_user',$id_user); 
		$this->db->where('del_status',1);
		$query = $this->db->get('users');
		return $query->result();
	} 

	public function registered_accounts(){
		$query = $this->db->query("SELECT a.reference_nos,a.id_registration,a.last_name,a.first_name,a.middle_name
		FROM registration a 
		WHERE a.del_status=1");
		return $query->result(); 
	}

	public function unique_registered_accounts(){
		//GET ALL ACCOUNT NA 0 UNG ID MAIN
		$query = $this->db->query("SELECT a.reference_nos,a.id_registration,a.last_name,a.first_name,a.middle_name
		FROM registration a 
		WHERE a.del_status=1 AND id_main=0");
		return $query->result(); 
	}

	public function get_self_account(){
		$id_registration = $this->input->post('id');
		$query = $this->db->query("SELECT a.reference_nos,a.id_registration,a.last_name,a.first_name,a.middle_name,a.id_main_address_province,
		a.id_main_address_city,a.id_main_address_barangay,a.bday,a.bplace,a.id_main_gender,a.id_main_civil_status,a.contact,a.email,
		a.sss,a.tin,a.occupation,a.spouse,a.spouse_contact,
		(SELECT COUNT(id_registration) FROM registration WHERE id_main=$id_registration AND del_status = 1) as 'current_account_count',
		(SELECT setting FROM settings WHERE type = 'account_limit' AND del_status = 1) as 'account_limit'
		FROM registration a 
		WHERE a.id_registration = $id_registration AND a.del_status=1
		");
		return $query->result(); 
	}
	
	public function view_account($id,$date){

		$get_date_range = $this->get_date_range($date);
		$GET_TUESDAY = $get_date_range['GET_TUESDAY'];
		$GET_MONDAY = $get_date_range['GET_MONDAY'];
		$GET_FRIDAY = $get_date_range['GET_FRIDAY'];

		$type = 'referal_commision';
		$query = $this->db->query("SELECT a.*,b.type,c.cash,CONCAT(last_name,', ',first_name,' ',middle_name) as 'name',

		(SELECT SUM(cash)
		 FROM main_money WHERE id_main = '$id' AND type != 'gift_check' AND del_status = 1) as 'overall_income',
		 
		 (SELECT COUNT(id_main_money) 
		 FROM main_money WHERE id_main = '$id' AND type = 'gift_check' AND del_status = 1) as 'gift_check'
				
		FROM registration a 
		INNER JOIN set_membership_type b ON a.id_set_membership_type = b.id_set_membership_type
		INNER JOIN main_money_membership_fee c ON b.id_set_membership_type = c.id_main AND c.type = 'membership_type_amount'
		WHERE a.id_registration = '$id' AND a.del_status = 1"); 


		//GET WEEKLY INCOME
		$id_main_ = $id;
		$type_ = 5;//0 SUM //1 SELECT ALL //SELECT BY ID
		$query_weekly_income = $this->db->query("call weekly_income_by_account('$id_main_','$type_','$GET_TUESDAY','$GET_MONDAY')");
		mysqli_next_result($this->db->conn_id);
		$row_wi =  $query_weekly_income->result_array();
		$weekly_income = $row_wi[0]['weekly_income_by_account'];
		if($weekly_income == ''){
			$weekly_income = 0;
		}


		$type1_ = '0';
	
		$query_left_right_count = $this->report_left_right_count($id_main_,$GET_TUESDAY,$GET_MONDAY);
		if(!empty($query_left_right_count)){
			foreach($query_left_right_count as $row){
				$left = $row->left_;
				$right = $row->right_;
			}
		}else{
			$left = 0;
			$right = 0;
		}

		$FIRST_DAY_MONTH = date('Y-m-01', strtotime(date('Y-m-d')));
		$LAST_DAY_MONTH =  date('Y-m-t', strtotime(date('Y-m-d')));

		$id_main1_ = $id;
		$type2_ = 1;//0 SUM //1 SELECT ALL //SELECT BY ID
		$query_monthly_income = $this->db->query("call monthly_income_by_account('$FIRST_DAY_MONTH',$id_main_,$type2_,'$LAST_DAY_MONTH')");
		mysqli_next_result($this->db->conn_id);
		$row_mi =  $query_monthly_income->result_array();
		$monthly_income = $row_mi[0]['monthly_income'];
		if($monthly_income == ''){
			$monthly_income = 0;
		}

		$type3_ = 6;//0 SUM //1 SELECT ALL //SELECT BY ID
		$query_weekly_income_list = $this->db->query("call weekly_income_by_account('$id_main_','$type3_','$GET_TUESDAY','$GET_MONDAY')");
		mysqli_next_result($this->db->conn_id);

		//GET FLUSHOUT
		$qry_flushout = $this->flushout($GET_TUESDAY,$GET_MONDAY,$id);
    $flushout_number_of_account = 0;
    $flushout_total_of_flushout = 0;
    if(isset($qry_flushout)){
      foreach($qry_flushout as $row_flushout){
        if($row_flushout->pairing_count > $row_flushout->setting){
          $flushout_number_of_account = $flushout_number_of_account + 1;
          $flushout_total_of_flushout =  $flushout_total_of_flushout + $row_flushout->flushout_money;
        }
      }
    }

		foreach($query->result() as $table_row){
			//PROCESS OF GETTING PAIR COMMISIONS
			
			//TOTAL COUNT OF RECRUITS
			$recruits = $table_row->reference_nos;
			
			//PROCESS OF GETTING THE PAIR
			$query_pair = $this->db->query("SELECT * FROM sponsorship WHERE id_acc_recruiter='$id' AND del_status = 1 ORDER BY dt ASC");
			foreach($query_pair->result() as $row_pair){
				
			}
			
			return array(
				'id_main' => $table_row->id_main,
				'reference_nos' => $table_row->reference_nos,
				'last_name' => $table_row->last_name,
				'first_name' => $table_row->first_name,
				'middle_name' => $table_row->middle_name,
				'id_main_address_province' => $table_row->id_main_address_province,
				'id_main_address_city' => $table_row->id_main_address_city,
				'id_main_address_barangay' => $table_row->id_main_address_barangay,
				'bday' => $table_row->bday,
				'bplace' => $table_row->bplace,
				'id_main_gender' => $table_row->id_main_gender,
				'id_main_civil_status' => $table_row->id_main_civil_status,
				'contact' => $table_row->contact,
				'email' => $table_row->email,
				'sss' => $table_row->sss,
				'tin' => $table_row->tin,
				'occupation' => $table_row->occupation,
				'spouse' => $table_row->spouse,
				'spouse_contact' => $table_row->spouse_contact,
				'pic' => $table_row->pic,
				//SUMMARY OF INCOME
				'overall_income' => $table_row->overall_income,
				'gift_check' => $table_row->gift_check,
				'weekly_income' => $weekly_income,
				'monthly_income' => $monthly_income,
				'flushout_total_of_flushout' => $flushout_total_of_flushout,
				'left' => $left,
				'right' => $right,
				//VALUES FROM INNER JOIN
				'cash' => $table_row->cash,
				'type' => $table_row->type,
				'name' => $table_row->name,
				'query_weekly_income_list' => $query_weekly_income_list->result(),
				//DATES
				'cutoff_start' => date('m-d-Y', strtotime('-'.date('w').' days')), //MONDAY
				'FIRST_DAY_MONTH' => $FIRST_DAY_MONTH,
				'LAST_DAY_MONTH' => $LAST_DAY_MONTH,
				'get_tuesday' => $GET_TUESDAY,
				'get_monday' => $GET_MONDAY,
				'get_friday' => $GET_FRIDAY,
				
			);
		}
	}
	
	public function cutoff($date){

		$get_date_range = $this->get_date_range($date);
		$GET_TUESDAY = $get_date_range['GET_TUESDAY'];
		$GET_MONDAY = $get_date_range['GET_MONDAY'];
		$GET_FRIDAY = $get_date_range['GET_FRIDAY'];
		//WEEKLY CUTOFF SUM ALL
		$date_ = $date;
		$id_main_ = 0;
		$type_ = 0;//0 SUM //1 SELECT ALL //SELECT BY ID
		$query_weekly_income = $this->db->query("call weekly_income_by_account('$id_main_','$type_','$GET_TUESDAY','$GET_MONDAY')");
		mysqli_next_result($this->db->conn_id);
		$weekly_income = 0;
		$weekly_acc_count = 0;
		if($query_weekly_income->num_rows()>0){
			$row_wi =  $query_weekly_income->result_array();
			$weekly_income = $row_wi[0]['weekly_income'];
			$weekly_acc_count = $row_wi[0]['weekly_acc_count'];
		}

		//GET LIST OF CUTOFF
		$type1_ = 2;//0 SUM //1 SUM ALL //SUM BY ID //2 SELECT ALL //3 SELECT BY ID
		$query_weekly_income_list = $this->db->query("call weekly_income_by_account('$id_main_','$type1_','$GET_TUESDAY','$GET_MONDAY')");
		// print_r($query_weekly_income_list->result());die();
		mysqli_next_result($this->db->conn_id);

		// //CUTOFF - FROM MONDAY TO TUESDAY. YANG ANG IBIBIGAY KAY FRIDAY.
		$day_ = date('w');
		
		//php get the week of the current month
		$dateArray = explode("-", $date_);
		$date = new DateTime();
		$date->setDate($dateArray[0], $dateArray[1], $dateArray[2]);
		$week_count = floor((date_format($date, 'j') - 1) / 7) + 1;  


		$cutoff_summary_overall = $this->cutoff_summary_overall($id_main_,$GET_TUESDAY,$GET_MONDAY);
		// print_r($haha);die();
			
		return array(
			
			'weekly_income' => $weekly_income,
			'weekly_acc_count' => $weekly_acc_count,
			'get_tuesday' => $GET_TUESDAY,
			'get_monday' => $GET_MONDAY,
			'get_friday' => $GET_FRIDAY,
			
			'cutoff_summary_overall' => $cutoff_summary_overall,

			'query_weekly_income_list' => $query_weekly_income_list->result(),
		
		);
	
	}

	public function redeem_gc(){
		$gc_requestor = $this->input->post('gc_requestor');
		$number_of_gc = $this->input->post('gc');

		//GET THE CURRENT QTY OF GC
		$select_gc = $this->db->query("SELECT COUNT(id_main_money) as 'count' FROM main_money WHERE 
		type='gift_check' AND id_main = '$gc_requestor' AND del_status = 1 AND pay_status = 0");
		$row = $select_gc->result_array();
		$count = $row[0]['count'];

		//COMPARE QTY TO USER REQUEST
		if($number_of_gc > $count){
			return 'Invalid Request: This account have ('.$count.') GC only';
		}else{
			for($x=0;$x<$number_of_gc;$x++){
				$this->db->query("UPDATE main_money as a,

				(SELECT id_main_money FROM main_money WHERE 
				type='gift_check' AND id_main = '$gc_requestor' AND del_status = 1 AND pay_status = 0
				ORDER BY dt asc LIMIT 1 ) b
														
				SET a.pay_status = 1                  
				WHERE a.id_main_money= b.id_main_money");
			}
			return '('.$number_of_gc.') GC Redeem Successfully';
		}



	
	}

	public function giftcheck($date){

		//WEEKLY CUTOFF SUM ALL
		$date_ = $date;
		$id_main_ = 0;
		$type_ = 0;//0 SUM //1 SELECT ALL //SELECT BY ID


		$GET_MONDAY =  date("Y-m-d", strtotime('monday this week',strtotime($date_))); //GET MONDAY OF THE WEEK
		$GET_FIRST_TUESDAY_OF_PAST_WEEK =  date("Y-m-d", strtotime("-6 days", strtotime($GET_MONDAY))); //GET_FIRST_TUESDAY_OF_PAST_WEEK
		$GET_FRIDAY =  date("Y-m-d", strtotime("4 days", strtotime($GET_MONDAY))); //GET_FIRST_TUESDAY_OF_PAST_WEEK
		// die($GET_FIRST_TUESDAY_OF_PAST_WEEK.' '.$GET_MONDAY);

		
		$query_gc = $this->db->query("call report_gc('','$GET_FIRST_TUESDAY_OF_PAST_WEEK','$GET_MONDAY')");
		mysqli_next_result($this->db->conn_id);
		$query_summary = $this->db->query("call gift_check_box_summary('','$GET_FIRST_TUESDAY_OF_PAST_WEEK','$GET_MONDAY')");
		mysqli_next_result($this->db->conn_id);
		foreach($query_summary->result() as $row){	
			$number_of_gc = $row->number_of_gc;
			$number_of_account = $row->number_of_account;
			$paid_gc = $row->paid_gc;
			$unpaid_gc = $row->unpaid_gc;
		}
			
		return array(
			'get_tuesday' => $GET_FIRST_TUESDAY_OF_PAST_WEEK,
			'get_monday' => $GET_MONDAY,
			'get_friday' => $GET_FRIDAY,

			'number_of_gc' => $number_of_gc,
			'number_of_account' => $number_of_account,
			'paid_gc' => $paid_gc,
			'unpaid_gc' => $unpaid_gc,

			'query_gc' => $query_gc->result(),
		);
	
	}

	public function flushout_data(){
		$id_main = $this->input->post('id_main');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$flushout = $this->flushout($date_from,$date_to,$id_main);
		// print_r($flushout);die();
		return $flushout;
	}

	public function report_income_account_list(){
		$id_main = $this->input->post('id_main');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$query_weekly_income_list = $this->db->query("call report_income_account_list($id_main,'$date_from','$date_to')");
		mysqli_next_result($this->db->conn_id);
		return $query_weekly_income_list->result();
	}	

	public function report_gc_by_account(){
		$id_main = $this->input->post('id_main');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$query_weekly_income_list = $this->db->query("call report_gc_by_account($id_main,'$date_from','$date_to')");
		mysqli_next_result($this->db->conn_id);
		return $query_weekly_income_list->result();
		
		// die($id_main.' | '. $date);
	}

	public function cutoff_update_payment_multiple(){
		$data_payment = $this->input->post('data_payment');

		$date_from_ = $this->input->post('date_from_');
		$date_to_ = $this->input->post('date_to_');
		$value = 1;
		for($x = 0; $x < count($data_payment['data_table']); $x++){
			$id_main = $data_payment['data_table'][$x]['id_main'];
			$this->db->query("call cutoff_update_payment($id_main,'$date_from_','$date_to_',$value)");
		}
	}

	public function cutoff_update_payment(){
		$id_main = $this->input->post('id_main');
		$date_from_ = $this->input->post('date_from_');
		$date_to_ = $this->input->post('date_to_');
		$value = $this->input->post('value');
		$this->db->query("call cutoff_update_payment($id_main,'$date_from_','$date_to_',$value)");
	}

  public function registration_list(){
		$query = $this->db->query("SELECT a.id_registration,a.reference_nos,a.last_name,a.first_name,a.middle_name,b.type,c.cash,a.contact 
		FROM registration a
		INNER JOIN set_membership_type b ON a.id_set_membership_type = b.id_set_membership_type
		INNER JOIN main_money_membership_fee c ON b.id_set_membership_type = c.id_main AND c.type = 'membership_type_amount'
		WHERE a.del_status = 1
		");
        return $query->result(); 
	}
	
	public function get_banned_accounts(){
        $query = $this->db->query("SELECT a.id_registration,a.reference_nos,a.last_name,a.first_name,a.middle_name,b.type,c.cash,a.contact,d.remarks 
		FROM registration a
		INNER JOIN set_membership_type b ON a.id_set_membership_type = b.id_set_membership_type
		INNER JOIN main_money_membership_fee c ON b.id_set_membership_type = c.id_main AND c.type = 'membership_type_amount'
		INNER JOIN banned_accounts d ON a.id_registration = d.id_registration
		WHERE a.del_status = 0
		");
        return $query->result(); 
	}

	public function fetch_registered_account_by_id(){

		$id = $this->input->post('id');
		$query = $this->db->query("SELECT b.dt,b.last_name,b.first_name,b.middle_name,b.row,

		(SELECT COUNT(a.id_acc_recruiter)
		FROM sponsorship a
		WHERE (a.id_acc_recruiter = '$id' OR a.id_acc_replacement) = '$id' AND a.del_status = 1) as 'if_have_placement',

		(SELECT SUM(id_main_position)
		FROM sponsorship
		WHERE id_acc_recruiter = '$id' AND del_status = 1) as 'if_left_right_is_ok',

		(SELECT id_main_position
		FROM sponsorship
		WHERE (id_acc_replacement = '$id' ) AND id_main_position = 0 AND del_status = 1 LIMIT 1) as 'check_replacement_left',
        
        
		(SELECT id_main_position
		FROM sponsorship
		WHERE (id_acc_replacement = '$id' ) AND id_main_position = 1 AND del_status = 1 LIMIT 1) as 'check_replacement_right',
    
        
		(SELECT id_main_position
		FROM sponsorship
		WHERE (id_acc_recruiter = '$id' AND id_acc_replacement = 0) AND del_status = 1 AND  id_main_position = 0 LIMIT 1) as 'check_recruiter_left',
        
        
		(SELECT id_main_position
		FROM sponsorship
		WHERE (id_acc_recruiter = '$id' AND id_acc_replacement = 0) AND del_status = 1 AND id_main_position = 1 LIMIT 1) as 'check_recruiter_right'


		FROM registration b WHERE b.id_registration = '$id' AND b.del_status =1");
		
		return $query->result(); 
	}

	public function fetch_acc_primary_details(){
		$id = $this->input->post('id');
		$query = $this->db->query("SELECT id_registration,reference_nos,pic,CONCAT(last_name,', ',first_name,' ',middle_name) as 'name'
		FROM registration b WHERE b.id_registration = '$id' AND b.del_status =1");
		return $query->result(); 
	}
	
	public function fetch_reg_account_for_replacement($type,$account,$date_from,$date_to){ 

		// TYPE 1: FOR ACCOUNT GENEOLOGY //for_acc_geneology
		// TYPE 2: FOR RETRIEVING ACCOUNT FOR REPLACEMENT //for_replacement_acc
		$id = $account;
		$ids = $this->pyramid_logic($id);//GET ACCOUNTS GROUP
		// print_r($ids);die('x '.$account);
		// // CONVERT ID'S INTO ARRAY
		// $arr_ids = explode(',',$ids);

		// //USING ARRAY UNIQUE TO AVOID DUPLICATE PAIRING MONEY
		// $array_unique = array_unique($arr_ids);
		// // To reset the keys of all arrays in an array:
		// $array_values = array_values($array_unique);

		// $ids = implode(',', $array_values);
		if($type == 'for_acc_geneology'){
			if(empty($ids)){
				$ids = 0;
			}

			$query = $this->db->query("SELECT CONCAT(b.reference_nos,' - ',b.last_name,', ',b.first_name,' ',b.middle_name) as 'recruit_name',
			CASE 
				WHEN c.reference_nos IS NULL  THEN  'N/A'
				WHEN c.reference_nos != '' THEN  CONCAT(c.reference_nos,' - ',c.last_name,', ',c.first_name,' ',c.middle_name) 
			END AS 'sponsor',
			CASE 
				WHEN d.reference_nos IS NULL  THEN  'N/A'
				WHEN d.reference_nos != '' THEN  CONCAT(d.reference_nos,' - ',d.last_name,', ',d.first_name,' ',d.middle_name) 
			END AS 'replacement',
			e.position,a.dt
			FROM sponsorship a
			LEFT JOIN registration b ON a.id_acc_recruit = b.id_registration
			LEFT JOIN registration c ON a.id_acc_recruiter = c.id_registration
			LEFT JOIN registration d ON a.id_acc_replacement = d.id_registration
			LEFT JOIN main_position e ON a.id_main_position = e.id_main_position
			WHERE a.del_status=1 AND
			CAST(a.dt as DATE) BETWEEN '$date_from' AND '$date_to' AND
			(id_acc_recruit IN ($ids) OR id_acc_recruit = $id)
			ORDER BY a.dt ASC");
			return $query->result(); 
		}else if($type == 'fetch_reg_account_for_replacement'){//FETCH PYRAMID DATA
			if(!empty($ids)){
				$query = $this->db->query("SELECT * FROM registration WHERE id_registration IN ($ids) AND del_status=1");
				return $query->result(); 
			}else{
				$query = $this->db->query("SELECT * FROM registration WHERE id_registration= 0 AND del_status=1");
				return $query->result(); 
			}
		}
		
	}

	public function for_report_left_right_count($account,$date_from = NULL,$date_to,$position){

		// $query = $this->db->query("SELECT COUNT(id_sponsorship) as 'count'
		// FROM sponsorship a
		// WHERE a.del_status=1 AND
		// CAST(a.dt as DATE) BETWEEN '$date_from' AND '$date_to' AND
		// (id_acc_recruit IN ($ids) OR id_acc_recruit = $id)
		// LIMIT 1");
		// // print_r($query->result());die($this->db->last_query());
		// $row = $query->result_array();
		// $count = $row[0]['count'];

		$id = $account;
		$ids = $this->pyramid_logic($id);//GET ACCOUNTS GROUP

		// $query = $this->db->query("SELECT COUNT(a.id_sponsorship) as 'count'

		// FROM sponsorship a 
		
		// WHERE a.del_status=1 
		// AND CAST(a.dt as DATE) 
		// BETWEEN '$date_from' AND '$date_to' 
		// AND (a.id_acc_recruit IN ($ids) OR a.id_acc_recruit = $id) 
		// AND a.id_acc_recruit != $id
		// AND a.id_main_position = '$position'
		// ORDER BY a.dt ASC");
		// // print_r($query->result());die($this->db->last_query());

		$this->db->select(" COUNT(a.id_sponsorship) as 'count' ");
		$this->db->where("CAST(a.dt as DATE)  BETWEEN '$date_from' AND '$date_to'");
		$this->db->where("(a.id_acc_recruit IN ($ids) OR a.id_acc_recruit = $id) ");
		$this->db->where(" a.id_acc_recruit !=",$id);
		$this->db->where(" a.id_main_position ",$position);
		$this->db->where('a.del_status',1);
		$query = $this->db->get('sponsorship as a');
		// die($this->db->last_query());

		$row = $query->result_array();
		$count = $row[0]['count'];
		return $count;

	}
	
	public function overall_genealogy(){
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$account = $this->input->post('account');

		mysqli_next_result($this->db->conn_id);

		if($account == ''){
			$query = $this->db->query("CALL report_genealogy('$account','$date_from','$date_to')");
			mysqli_next_result($this->db->conn_id);
			return $query->result(); 
		}else{
			$query = $this->fetch_reg_account_for_replacement('for_acc_geneology',$account,$date_from,$date_to);
			return $query; 
		}
	}

	public function get_report_type(){
		$query = $this->db->query("SELECT * FROM settings WHERE type='report_type' AND del_status=1");
		return $query->result();
	}

	public function get_report(){
		$query = $this->db->query("SELECT * FROM settings WHERE type='report' AND del_status=1");
		return $query->result();
	}

	public function report_gc(){

		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$account = $this->input->post('account');

		$query_gc = $this->db->query("CALL report_gc('$account','$date_from','$date_to')");
		mysqli_next_result($this->db->conn_id);
		return $query_gc->result();

	}

	public function report_flushout(){
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$account = $this->input->post('account');
		$flushout = $this->flushout($date_from,$date_to,$account);
		// print_r($flushout);die();
		return $flushout;
	}

	public function report_left_right_count($account,$date_from,$date_to){
		
		if($account != ''){

			$this->db->select("CONCAT(last_name,' ',first_name,' ',middle_name) as name");
			$this->db->where("id_registration",$account);
			$query_name = $this->db->get("registration");
			$row_name = $query_name->result_array();
			$name = $row_name[0]['name'];

			// LEFT
			// $query_left = $this->db->query("SELECT id_acc_recruit FROM `sponsorship` WHERE (id_acc_recruiter = $account or id_acc_replacement = $account) AND id_main_position = 0 LIMIT 1");
			// $row_left = $query_left->result_array();
			// if($query_left->num_rows()>0){
			// 	$left = $row_left[0]['id_acc_recruit'];
			// }else{
			// 	$left = 0;
			// }
			$left_count = $this->for_report_left_right_count($account,$date_from,$date_to,0);


			// RIGHT
			// $query_right = $this->db->query("SELECT id_acc_recruit FROM `sponsorship` WHERE (id_acc_recruiter = $account or id_acc_replacement = $account) AND id_main_position = 1 LIMIT 1");
			// $row_right = $query_right->result_array();
			// if($query_right->num_rows()>0){
			// 	$right = $row_right[0]['id_acc_recruit'];
			// }else{
			// 	$right = 0;
			// }
			// print_r();die($right.' xxxx');
			// die($right.' xxxx');
			$right_count = $this->for_report_left_right_count($account,$date_from,$date_to,1);
			// print_r($right_count);die($right.' xx');
			$this->db->query('DROP TABLE IF EXISTS temp_left_right');
			$this->db->query('CALL add_temp_left_right()');

			$arr = array(
				'id_account'=>$account,
				'name'=>$name,
				'left_'=>$left_count,
				'right_'=>$right_count,
			);


			if(!empty($arr)){
				// print_r($arr);die('x');
				$this->db->insert("temp_left_right",$arr);
			}

			$query_left_right_count = $this->db->query("SELECT * FROM temp_left_right");

			return $query_left_right_count->result();

		}
		
		
	}

	public function left_right_sub_func($account,$date_from,$date_to){
		// die($account);
		// $account = 2;
		$ids =$this->pyramid_logic($account).','.$account;
		$ids = str_replace('0', $account, $ids);
		// die($ids);
		$query_left_right_count = $this->db->query("SELECT b.id_registration,CONCAT(b.reference_nos,' - ',b.last_name,', ',b.first_name,' ',b.middle_name) as 'name', 

		(SELECT COUNT(id_sponsorship) FROM sponsorship 
		WHERE (id_acc_recruiter IN ($ids)
		OR id_acc_replacement IN ($ids)) 
		AND id_main_position = 0 AND del_status = 1
		AND CAST(dt as DATE) BETWEEN '$date_from' AND '$date_to') as 'left_',
		
		(SELECT COUNT(id_sponsorship) FROM sponsorship 
		WHERE (id_acc_recruiter IN ($ids) 
		OR id_acc_replacement IN ($ids)) 
		AND id_main_position = 1 AND del_status = 1
		AND CAST(dt as DATE) BETWEEN '$date_from' AND '$date_to') as 'right_'
		
		
		FROM sponsorship a
		INNER JOIN registration b ON b.id_registration = '$account'
		WHERE a.del_status = 1
		AND cast(a.dt as DATE) BETWEEN '$date_from' AND '$date_to' 
		GROUP BY b.id_registration;
		");

		// print_r($query_left_right_count->result());die();
		return $query_left_right_count;
	}

	public function report_cutoff(){
		//GET LIST OF CUTOFF
		$account = $this->input->post('account');
		$date_from = $this->input->post('date_from');
		$date_to = $this->input->post('date_to');
		$type1_ = 2;//0 SUM //1 SUM ALL //SUM BY ID //2 SELECT ALL //3 SELECT BY ID
		$query_weekly_income_list = $this->db->query("call report_cutoff('$account','$date_from','$date_to')");
		return $query_weekly_income_list->result();
	}

	public function select_city(){
			$id = $this->input->post('id');
			$query = $this->db->query("SELECT b.id_main_address_city,b.citymunDesc FROM main_address_province a 
			INNER JOIN main_address_city b ON a.provCode = b.provCode
			WHERE a.id_main_address_province = $id");
			return $query->result(); 
	}

    public function select_barangay(){
        $id = $this->input->post('id');
        $query = $this->db->query("SELECT b.id_main_address_barangay,b.brgyDesc FROM main_address_city a 
        INNER JOIN main_address_barangay b ON a.citymunCode = b.citymunCode
        WHERE a.id_main_address_city = $id");
        return $query->result(); 
    }
    
    
    public function get_province(){
        $query = $this->db->query("SELECT id_main_address_province,provDesc FROM main_address_province ORDER BY provDesc ASC");
        return $query->result(); 
    }

    public function get_gender(){
        $query = $this->db->query("SELECT id_main_gender,gender FROM main_gender WHERE del_status=1");
        return $query->result(); 
    }
    
    public function get_civil_status(){
        $query = $this->db->query("SELECT id_main_civil_status,civil_status FROM main_civil_status WHERE del_status=1");
        return $query->result(); 
	}
	
	public function update_account($id){
		
		$id_main = $this->input->post('id_main');
		$_POST['id_main_address_province'] = $this->input->post('main_address_province');
		$_POST['id_main_address_city'] = $this->input->post('main_address_city');
		$_POST['id_main_address_barangay'] = $this->input->post('main_address_barangay');
		//UNSET 
		unset($_POST['id_main']);
		unset($_POST['main_address_province']);
		unset($_POST['main_address_city']);
		unset($_POST['main_address_barangay']);

		//SAVE IN ACCOUNT REGISTRATION
		if($id_main != 0){
			$id = $id_main;
		}
		
		$this->db->where("id_registration",$id);
		$this->db->or_where("id_main",$id);
		$this->db->update("registration",$this->input->post());
		
		// die($this->db->last_query());
	}

	public function add_profile_picture($file_name,$id){
		
		$id_main = $this->input->post('id_main');
		//UNSET 
		unset($_POST['id_main']);

		//SAVE IN ACCOUNT REGISTRATION
		if($id_main != 0){
			$id = $id_main;
		}

		$arr = array('pic'=>$file_name);
		
		$this->db->where("id_registration",$id);
		$this->db->or_where("id_main",$id);
		$this->db->update("registration",$arr);
		// die($this->db->last_query());
	}
	
	public function register_account_alternative(){
		$membership_type_amount  = $this->input->post("membership_type_amount");
		$membership_type_commission  = $this->input->post("membership_type_commission");
		$membership_type_pairing  = $this->input->post("membership_type_pairing");
		$id_acc_recruiter = $this->input->post('id_acc_recruiter');
		$id_main_position = $this->input->post('id_main_position');
		$id_acc_replacement = $this->input->post('id_acc_replacement');
		$reference_nos = $this->input->post('reference_nos');
		$is_replacement_blank = $this->input->post('is_replacement_blank');
		$is_there_pairing = $this->input->post('is_there_pairing');
		$data_pairing = $this->input->post('data_pairing');

		//PAIRING ARRAY
		$account_will_get_pairing_money = array();
		
		//BE DEFAULT MAKE IT 0 WHEN IT IS EMPTY
		if($reference_nos == '#1001'){//BY DEFAULT 1, KAC SIYA UNG FIRST ACCOUNT
			$id_acc_recruiter = 0;
			$id_main_position = 2;
			$_POST['row'] = 0;
		}else{
			$_POST['row'] = $this->input->post('row') + 1;
		}

		if($id_acc_replacement == ''){
			$id_acc_replacement = 0;
		}

		//UNSET 
		unset($_POST['data_pairing']);
		unset($_POST['is_replacement_blank']);
		unset($_POST['is_there_pairing']);
		unset($_POST['membership_type_amount']);
		unset($_POST['membership_type_commission']);
		unset($_POST['membership_type_pairing']);
		unset($_POST['id_acc_recruiter']);
		unset($_POST['id_main_position']);
		unset($_POST['id_acc_replacement']);
		//FOR SELF ACCOUNT TRACKING
		
		//SAVE IN ACCOUNT REGISTRATION
		$this->db->insert("registration",$this->input->post());
		$last_id = $this->db->insert_id();

		//SAVE IN ACCOUNT SPONSORSHIP
		$sponsor_data[] = array(
			'id_acc_recruit' => $last_id,
			'id_acc_recruiter' => $id_acc_recruiter,
			'id_acc_replacement' => $id_acc_replacement,
			'id_main_position' => $id_main_position,
			'row' => $_POST['row'],
		);
		$this->db->insert("sponsorship",$sponsor_data[0]);
		$sponsorship_last_id = $this->db->insert_id();
		//SAVE IN ACCOUNT SPONSORSHIP

		if($reference_nos != '#1001'){//ON THE FIRST ACCOUNT, WALA MUNANG REFERAL
			//SAVE COMMISION IN MONEY
			$commision_money_data[] = array(
				'id_sponsorship' => $sponsorship_last_id,
				'id_main' => $id_acc_recruiter,
				'type' => 'referal_commision',
				'cash' => $membership_type_commission,
			);
			$this->db->insert("main_money",$commision_money_data[0]);
		}

		//FOR PAIRING
		if($is_replacement_blank == 0){//KAPAG BLANK SI REPLACEMENT
			$id_main = $id_acc_recruiter; //SPONSOR
		}else{
			$id_main = $id_acc_replacement; //REPLACEMENT
		}

		if($is_there_pairing == 1){
			array_push($account_will_get_pairing_money,$id_main);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL GET PAIRING MONEY
		}
		//FOR PAIRING

		//GET ALL ACCOUNT IN PAIRING TABLE
		// print_r($data_pairing);die();
		if(isset($data_pairing)){
			for($x = 0; $x < count($data_pairing['data_table']); $x++){
				$id_main1 = $data_pairing['data_table'][$x]['id'];
				array_push($account_will_get_pairing_money,$id_main1);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL GET PAIRING MONEY
			}
		}
		//GET ALL ACCOUNT IN PAIRING TABLE	
		// print_r($account_will_get_pairing_money);
		if(count($account_will_get_pairing_money) >= 0){//IF ARRAY IS NOT EMPTY THEN COMBINE OR MERGE ARRAY

			//USING ARRAY UNIQUE TO AVOID DUPLICATE PAIRING MONEY
			$array_unique = array_unique($account_will_get_pairing_money);
			// To reset the keys of all arrays in an array:
			$array_values = array_values($array_unique);
			// print_r($array_values);//echo count($array_values);

			for($x = 0; $x < count($array_values); $x++){
				// die('pogi ako');
				// die($id_sponsorship1.' | '.$id_sponsorship2);
	
				// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship1'");	
				// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship2'");
	  
				//ID'S
				$id_main = $array_values[$x];
				// die($id_main);
				// echo $id_main;
				// echo $array_values[$x].'|';
				//COUNT NUMBER OF PAIRING
				//IF PAIRING COUNT REACHED 4 THEN GIVE GC INSTEAD
				$query = $this->db->query("SELECT COUNT(id_main_money) as 'pairing_count'
				FROM main_money WHERE id_main = '$id_main' AND (type = 'referal_pairing' OR type = 'gift_check') AND del_status = 1 ");
				$row = $query->result_array();
	
				// print_r($query->result_array());die(' he');
				// $x = intval($row[0]['pairing_count']) % 5;
				// echo $x;
				// die(intval($row[0]['pairing_count']).' | '.$x);
				//removed GC if(intval($row[0]['pairing_count']) % 5 != 4 || intval($row[0]['pairing_count']) == 0){//EVERY 5FT PAIR GIVE GC
					// print_r();die($id_main.'| '.$array_unique[$x].' gege');
					//FOR PAIRING COMMISION 
					if($array_values[$x] != 0){
						$array_money[] = array(
							'id_sponsorship' => $sponsorship_last_id,
							'id_main' => $array_values[$x],
							'type' => 'referal_pairing',
							'cash' => $membership_type_pairing,
						);
						
						// print_r($array_money);
						
						$this->db->insert("main_money",$array_money[0]);
					}
				//removed GC}
				//removed GCelse{
					// die('b');
					//FOR GIFT CHECK
				//removed GC	if($array_values[$x] != 0){
				//removed GC		$array_money[] = array(
				//removed GC			'id_sponsorship' => $sponsorship_last_id,
				//removed GC			'id_main' => $array_values[$x],
				//removed GC			'type' => 'gift_check',
				//removed GC			'cash' => 1,
				//removed GC		);
				//removed GC		$this->db->insert("main_money",$array_money[0]);
				//removed GC	}
				//removed GC}
	
				//RESET ARRAY
				$array_money = array();
				
				// print_r($array_unique);die(' haha');
			}
		}

		echo $last_id;
		// die('galing');

	}
    
	public function register_account(){
		//DECLARIATION
		$row_pair5_check_left = '';
		$row_pair5_check_right = '';
		$row_pair5_id_acc_replacement = '';
		//VARIABLES
		
		$membership_type_amount  = $this->input->post("membership_type_amount");
		$membership_type_commission  = $this->input->post("membership_type_commission");
		$membership_type_pairing  = $this->input->post("membership_type_pairing");
		$id_acc_recruiter = $this->input->post('id_acc_recruiter');
		$id_main_position = $this->input->post('id_main_position');
		$id_acc_replacement = $this->input->post('id_acc_replacement');
		$reference_nos = $this->input->post('reference_nos');

		$is_replacement_blank = $this->input->post('is_replacement_blank');
		$is_there_pairing = $this->input->post('is_there_pairing');

		//PAIRING ARRAY
		$account_will_get_pairing_money = array();
		
		//BE DEFAULT MAKE IT 0 WHEN IT IS EMPTY
		if($reference_nos == '#1001'){//BY DEFAULT 1, KAC SIYA UNG FIRST ACCOUNT
			$id_acc_recruiter = 0;
			$id_main_position = 0;//MEANING NEUTRAL OR (BOTH 1 AND 2)
			// $row = 0;
			$_POST['row'] = 0;
		}else{
			$_POST['row'] = $this->input->post('row') + 1;
		}

		if($id_acc_replacement == ''){
			$id_acc_replacement = 0;
		}

		 
		//UNSET 
		unset($_POST['is_replacement_blank']);
		unset($_POST['is_there_pairing']);

		unset($_POST['get_self_account']);
		unset($_POST['membership_type_amount']);
		unset($_POST['membership_type_commission']);
		unset($_POST['membership_type_pairing']);
		unset($_POST['id_acc_recruiter']);
		unset($_POST['id_main_position']);
		unset($_POST['id_acc_replacement']);

		//FOR SELF ACCOUNT TRACKING
		$_POST['id_main'] = $get_self_account;
		
		//VARIALBES FOR PAIRING
		$first_position='';  
		$second_position='';
		$sum=''; 
		
		//SAVE IN ACCOUNT REGISTRATION
        $this->db->insert("registration",$this->input->post());
		$last_id = $this->db->insert_id();
		 
		//SAVE IN SPONSOR TABLE
		// if($reference_nos == '#1001'){//BY DEFAULT 1, KAC SIYA UNG FIRST ACCOUNT
		// 	$pairing_status = 1;
		// }else{
		// 	$pairing_status = 0;
		// }

		$sponsor_data[] = array(
			'id_acc_recruit' => $last_id,
			'id_acc_recruiter' => $id_acc_recruiter,
			'id_acc_replacement' => $id_acc_replacement,
			'id_main_position' => $id_main_position,
			'row' => $_POST['row'],
		);
		$this->db->insert("sponsorship",$sponsor_data[0]);
		$sponsorship_last_id = $this->db->insert_id();
		
		if($reference_nos != '#1001'){//ON THE FIRST ACCOUNT, WALA MUNANG REFERAL
			//SAVE COMMISION IN MONEY
			$commision_money_data[] = array(
				'id_main' => $id_acc_recruiter,
				'type' => 'referal_commision',
				'cash' => $membership_type_commission,
			);
			$this->db->insert("main_money",$commision_money_data[0]);
		}

 
		if($is_replacement_blank == 0){//KAPAG BLANK SI REPLACEMENT
			$id_main = $id_acc_recruiter; //SPONSOR
		}else{
			$id_main = $id_acc_replacement; //REPLACEMENT
		}

		//STEP 1 - GETTING FIRST/PRIMARY PAIRING ----------------------------------------------------------------------------------------------------------------------
		//FIRST/PRIMARY PAIRING
		if($is_there_pairing == 1){
			//PAIRING COMISSION
			array_push($account_will_get_pairing_money,$id_main);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL GET PAIRING MONEY
			// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$sponsorship_last_id' ");//UPDATE PAIRING STATUS TO 1	
			
		}
		//STEP 1 - GETTING FIRST/PRIMARY PAIRING ----------------------------------------------------------------------------------------------------------------------

		

		if( $_POST['row'] > 1){//ROW 0 AND 1 IS NOT CANDIDATE FOR PAIRING

				
				//COUNT NUMBER OF PAIRING STATUS 1 IN A SPECIFIC ROW
				$qry_count_of_pairing_status1 = $this->db->query("SELECT COUNT(id_sponsorship) as 'count' FROM sponsorship WHERE row='$_POST[row]' AND pairing_status=1");
				$row_count = $qry_count_of_pairing_status1->result_array();
				//$gv_pairing_count = COUNT OF ACCOUNT WITH 1 AS PAIRING STATUS IN A CURRENT ROW
				$gv_pairing_count = $row_count[0]['count'];

				//GLOBAL VARIABLE $gv
				//SECONDARY $sp
				//GET THE RECRUITER OF ID_MAIN
				$query_get_recruiter_1 = $this->db->query("SELECT id_acc_recruiter,id_acc_recruit FROM sponsorship WHERE id_acc_recruit='$id_main' AND del_status = 1 ");
				$row_recruiter_1 = $query_get_recruiter_1->result_array();
				$gv_ml_id_main = $row_recruiter_1[0]['id_acc_recruiter'];//MULTI ACCOUNT
				$gv_sp_id_id_acc_recruit = $row_recruiter_1[0]['id_acc_recruit'];//MULTI ACCOUNT

				//GETTING THE 2 RECRUITS OF  $gv_ml_id_main
				//$id_main = ID OF RECRUITER
				$qry_get_two_accounts = $this->db->query("SELECT id_acc_recruit FROM sponsorship WHERE id_acc_recruiter='$gv_ml_id_main' AND del_status = 1 ");// $_SESSION[row_recruiter_1] SECONDARY ID
				$row_get_two_accounts = $qry_get_two_accounts->result_array();
				//$id_acc_recruit1 & $id_acc_recruit2 = ANG DALAWANG RECRUIT NI $id_main
				$gv_id_acc_recruit1 = $row_get_two_accounts[0]['id_acc_recruit'];
				$gv_id_acc_recruit2 = $row_get_two_accounts[1]['id_acc_recruit'];

				//$row or $_POST['row'] = COUNT OF CURRENT ROW
				$row = $_POST['row'];
				// die($id_main);
				// die($gv_id_acc_recruit1 .'|'.$gv_id_acc_recruit2);

				//GET ALL 
				$qry_get_two_accounts1 = $this->db->query("SELECT id_acc_recruiter,
				(SELECT COUNT(id_sponsorship) FROM sponsorship WHERE id_acc_recruiter ='$gv_id_acc_recruit1' OR id_acc_recruiter ='$gv_id_acc_recruit2' AND row = '$row' AND del_status = 1) as 'count'
				FROM sponsorship 
				WHERE id_acc_recruiter ='$gv_id_acc_recruit1' OR id_acc_recruiter ='$gv_id_acc_recruit2' AND row = '$row'  AND del_status = 1 ORDER BY dt ASC ");
				$row_get_two_accounts1 = $qry_get_two_accounts1->result_array();
				$gv_id_acc_recruiter1 = $row_get_two_accounts1[0]['id_acc_recruiter'];
				$gv_sp_count = $row_get_two_accounts1[0]['count'];
				if($gv_sp_count != 1){
					$gv_id_acc_recruiter2 = $row_get_two_accounts1[1]['id_acc_recruiter'];
				}else{
					$gv_id_acc_recruiter2 = 0;
				}
				//GLOBAL VARIABLE

				
				if($gv_pairing_count != 1){//KAPAG 1 LANG AT WALA SIYANG KA PARTNER. GO TO ELSE
					$_SESSION['row_recruiter_1'] = $id_main; //HOLD THE ACCOUNT OF RECRUITER OF THE RECRUITER
				


					if($id_main > 0){//BY DEFAULT, IF RECRUITER IS 1. NOTHING TO DO NEXT
						// //GET MULTILEVEL ACCOUNT ------------------------------------------------------------------------------------------------------------------------------------
						$qry_get_acc = $this->db->query("SELECT id_sponsorship,id_acc_recruiter FROM sponsorship WHERE row='$_POST[row]' AND del_status = 1 ORDER by id_sponsorship DESC LIMIT 1, 1");
						$row_get_acc = $qry_get_acc->result_array();
						$_SESSION['row_recruiter_2']  = $row_get_acc[0]['id_acc_recruiter'];
						$id_sponsorship2  = $row_get_acc[0]['id_sponsorship'];
						// die($_SESSION['row_recruiter_1'] .' | '.$_SESSION['row_recruiter_2'] .' haha');
						echo ' block 1 ';
						$x = 1;
						$subject_for_multiple_pairing = '';
						$first_equal = '';
						do{
							//CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.
							$query_get_recruiter_1 = $this->db->query("SELECT id_acc_recruiter FROM sponsorship WHERE id_acc_recruit='$_SESSION[row_recruiter_1]'");
							$row_recruiter_1 = $query_get_recruiter_1->result_array();
							$_SESSION['row_recruiter_1'] = $row_recruiter_1[0]['id_acc_recruiter'];
							//CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.
		
							//GET THE ACCOUNT BEFORE THE LATEST ACCOUNT IN ROW
							$query_get_recruiter_2 = $this->db->query("SELECT id_acc_recruiter FROM sponsorship WHERE id_acc_recruit='$_SESSION[row_recruiter_2]'");
							$row_recruiter_2 = $query_get_recruiter_2->result_array();
							$_SESSION['row_recruiter_2'] = $row_recruiter_2[0]['id_acc_recruiter'];
							$row_recruiter_22 = $row_recruiter_2[0]['id_acc_recruiter'];
							//GET THE ACCOUNT BEFORE THE LATEST ACCOUNT IN ROW
							$x = $x + 1;

							if($_SESSION['row_recruiter_1'] == $_SESSION['row_recruiter_2']){
								$subject_for_multiple_pairing = $subject_for_multiple_pairing.'|'.$_SESSION['row_recruiter_1'];//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL PAIRING MONEY
								if($first_equal == ''){//KUHANIN NATIN UNG COUNT NANG X KUNG SAAN UNANG NAGEQUAL ANG TWO VARIABLES
									$first_equal = $x;//THEN ICOCOMPARE NATIN ITO BAGO TAYO MAG GIVE NANG PAIRING MONEY. IF DI NA REACH NANG VARIABLE NA TO UNG VALUE NANG ROW. SAD TO SAY WALANG PAIRING AT WALANG UPDATE NANG STATUS
								}
							}
		
						}while($x != $row);//LOOP IS BASED SA ROW COUNT
						$multi_id_account = $_SESSION['row_recruiter_1'];//MULTI LEVEL ACCOUT
						// //GET MULTILEVEL ACCOUNT ------------------------------------------------------------------------------------------------------------------------------------
						// die($_SESSION['row_recruiter_1']);
	
						//UPDATE PAIRING STATUS

							$result = $this->check_for_secondary_pairing($gv_ml_id_main,$_POST['row'],$gv_sp_count,$gv_id_acc_recruiter1,$gv_id_acc_recruiter2);
							array_push($account_will_get_pairing_money,$result);

							$result1 = $this->check_for_multi_pairing($gv_id_acc_recruit1,$gv_id_acc_recruit2,$gv_ml_id_main,$gv_sp_id_id_acc_recruit,$gv_sp_count,$gv_id_acc_recruiter1,$gv_id_acc_recruiter2,$sponsorship_last_id,$multi_id_account,$subject_for_multiple_pairing,$first_equal,$row,$id_main);
							$myArray = array();
							$myArray = explode(',',$result1);
							for($i=0;$i<count($myArray);$i++){
								array_push($account_will_get_pairing_money,$myArray[$i]);
							}

					}

				
				}else{
					echo ' block 6 ';
					//CHECK FOR SECONDARY LEVEL
					// $row_loop = 2;
					// if($id_main > 0){//BY DEFAULT, IF RECRUITER IS 1. NOTHING TO DO NEXT
					$_SESSION['row_recruiter_1'] = $id_main; //HOLD THE ACCOUNT OF RECRUITER OF THE RECRUITER
					// do{
						//CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.
						$query_get_recruiter_1 = $this->db->query("SELECT id_acc_recruiter FROM sponsorship WHERE id_acc_recruit='$_SESSION[row_recruiter_1]'");
						$row_recruiter_1 = $query_get_recruiter_1->result_array();
						$_SESSION['row_recruiter_1'] = $row_recruiter_1[0]['id_acc_recruiter'];
						//CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.

						// die($_SESSION['row_recruiter_1']);
						
					// 	$row_loop = $row_loop - 1;
					// }while($row_loop != 0);
					// echo $_SESSION['row_recruiter_1'] .' recruiter | ';

					//GET THE 2 ACCOUNTS UNDER NI SECONDARY ACCOUNT
					$qry_get_two_accounts = $this->db->query("SELECT id_acc_recruit FROM sponsorship WHERE id_acc_recruiter='$_SESSION[row_recruiter_1]' ");
					$row_get_two_accounts = $qry_get_two_accounts->result_array();
					$id_acc_recruit1 = $row_get_two_accounts[0]['id_acc_recruit'];
					$id_acc_recruit2 = $row_get_two_accounts[1]['id_acc_recruit'];

					// echo $id_acc_recruit1 .' recruit 1 | ';
					// echo $id_acc_recruit2 .' recruit 2';

					//COUNT AND CHECK IF EVEN OR NOT. THE ACCOUNT IN THAT SECONDARY ROW. IF EVEN GIVE PAIRING
					$row = $_POST['row'];
					// die($row .' row '.$id_acc_recruit1.' | '.$id_acc_recruit1);

					//GET ALL 
					$qry_get_two_accounts1 = $this->db->query("SELECT id_acc_recruiter,
					(SELECT COUNT(id_sponsorship) FROM sponsorship WHERE id_acc_recruiter ='$id_acc_recruit1' OR id_acc_recruiter ='$id_acc_recruit2' AND row = '$row') as 'count'
					FROM sponsorship 
					WHERE id_acc_recruiter ='$id_acc_recruit1' OR id_acc_recruiter ='$id_acc_recruit2' AND row = '$row' ORDER BY dt ASC  ");
					$row_get_two_accounts1 = $qry_get_two_accounts1->result_array();
					$id_acc_recruiter1 = $row_get_two_accounts1[0]['id_acc_recruiter'];
					$count = $row_get_two_accounts1[0]['count'];
					if($count != 1){
						$id_acc_recruiter2 = $row_get_two_accounts1[1]['id_acc_recruiter'];
					}else{
						$id_acc_recruiter2 = 0;
					}
					// die($id_acc_recruiter1.'|'.$id_acc_recruiter2.'|'.$count);
					//KAPAG ANG COUNT IS EQUAL SA 4 PASOK. 
					//KAPAG DIFFERENT NANG RECRUITER SA UNANG DALAWANG ACCOUNT PASOK 
					//KAPAG ANG COUNT AY 3 AND SAME NANG RECRUITER PASOK
					$result = $this->check_for_secondary_pairing($gv_ml_id_main,$_POST['row'],$gv_sp_count,$gv_id_acc_recruiter1,$gv_id_acc_recruiter2);
					array_push($account_will_get_pairing_money,$result);
					// }

				}

				
				
			
			
			// }
		}###000_johnmay_2017241997
		 ###000_johnmay_2017241997
	
		

		//GET ACCOUNTS WHO WILL GET PAIRING MONEY


		// print_r($array_unique);die();

		
	
		// die(count($array_unique).' b');
		// print_r($array_unique);die(count($array_unique).' haha');

		if(count($account_will_get_pairing_money) >= 0){//IF ARRAY IS NOT EMPTY THEN COMBINE OR MERGE ARRAY

			

			//USING ARRAY UNIQUE TO AVOID DUPLICATE PAIRING MONEY
			$array_unique = array_unique($account_will_get_pairing_money);
			// To reset the keys of all arrays in an array:
			$array_values = array_values($array_unique);

			echo '|  array | ';
			print_r($account_will_get_pairing_money);

			for($x = 0; $x < count($array_values); $x++){
				// die('pogi ako');
				// die($id_sponsorship1.' | '.$id_sponsorship2);
	
				// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship1'");	
				// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship2'");
	  
				//ID'S
				$id_main = $array_values[$x];
				// die($id_main);
				// echo $id_main;
	 
				//COUNT NUMBER OF PAIRING
				//IF PAIRING COUNT REACHED 4 THEN GIVE GC INSTEAD
				$query = $this->db->query("SELECT COUNT(id_main_money) as 'pairing_count'
				FROM main_money WHERE id_main = '$id_main' AND type = 'referal_pairing'");
				$row = $query->result_array();
	
				// print_r($query->result_array());die(' he');
				
				if($row[0]['pairing_count'] < 4){//IF BELOW OR EQUAL TO 4
					// print_r();die($id_main.'| '.$array_unique[$x].' gege');
					//FOR PAIRING COMMISION
					if($id_main != 0){
						$array_money[] = array(
							'id_main' => $array_values[$x],
							'type' => 'referal_pairing',
							'cash' => $membership_type_pairing,
						);
	
						// print_r($array_money);
						
						$this->db->insert("main_money",$array_money[0]);
					}
				}else{
					// die('b');
					//FOR GIFT CHECK
					if($array_values[$x] != 0){
						$array_money[] = array(
							'id_main' => $array_values[$x],
							'type' => 'gift_check',
							'cash' => 1,
						);
						$this->db->insert("main_money",$array_money[0]);
					}
				}
	
				//RESET ARRAY
				$array_money = array();
				
				// print_r($array_unique);die(' haha');
			}
		}

		die(' haha');
		// print_r($array_unique);die(' haha');
		// print_r($array_unique);die();
		
	}
	
	
    public function update_display_profile($file_name){
        $id_user = $this->input->post('id_user');
        $_SESSION['picture'] = $file_name;
        $query = $this->db->query("UPDATE users SET picture='$file_name' WHERE id_user='$id_user'");
    }

    function check_duplicate_user_acc(){
        $id_user = $this->input->post('id_user');
        $accounts_id = $this->input->post('accounts_id');
        $email = $this->input->post('email');
        $contact = $this->input->post('contact');
        $result = $this->db->query("SELECT id_user FROM users 
        WHERE (email='$email' OR contact='$contact' ) AND del_status = 1 AND id_user != '$id_user' ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    } 

    public function update_user_account(){
        $id_user = $this->input->post('id_user');
        unset($_POST['id_user']);
        $this->db->where('id_user',$id_user);
        $this->db->where('del_status',1);
        $result = $this->db->update("users",$this->input->post());
    }

    public function update_account_password($new_password){

        $new_hash_password = password_hash($new_password, PASSWORD_DEFAULT);
        $this->db->query("UPDATE users SET password='$new_hash_password' WHERE id_user='$_SESSION[id_user]' ");
    }

}