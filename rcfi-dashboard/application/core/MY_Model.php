<?php
class MY_Model extends CI_Model { 
    
    function __construct(){
        parent::__construct();
    }


    //CHECK FOR SECONDARY PAIRING
    public function check_for_secondary_pairing($gv_ml_id_main,$row,$gv_sp_count,$gv_id_acc_recruiter1,$gv_id_acc_recruiter2){
        // $gv_sp_count = COUNT OF ACCOUNT IN A ROW
        // $gv_id_acc_recruiter1 = FIRST ACCOUNT ENTERED IN A ROW
        // $gv_id_acc_recruiter2 = FIRST ACCOUNT ENTERED IN A ROW
        echo '| from secondary pairing1 | ';
        if($gv_sp_count == 4 || ($gv_sp_count != 1 && $gv_id_acc_recruiter2 == 0) || ($gv_sp_count == 2 && ($gv_id_acc_recruiter1 != $gv_id_acc_recruiter2)) || ($gv_sp_count == 3 && ($gv_id_acc_recruiter1 == $gv_id_acc_recruiter2))){//BIBIGYAN NANG PAIRING
            //$id_main = ID NANG RECRUITER
            echo '| from secondary pairing2 | '.$gv_ml_id_main .' |';
            return $gv_ml_id_main;//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL PAIRING MONEY
           

        }else{
            echo '| from secondary pairing3 | ';
        }
    }

    public function cutoff_summary_overall($id_main_,$date_from,$date_to){
        $number_of_account = 0;
        $paid_account = 0;
        $accounts_to_be_paid = 0;
        $weekly_cutoff = 0;
        $payment = 0;
        $pending_payment = 0;
        
        $query_weekly_income_list = $this->db->query("call report_cutoff_summary('$id_main_','$date_from','$date_to')");
        
        mysqli_next_result($this->db->conn_id);
        foreach($query_weekly_income_list->result() as $row){
            if($row->pay_status==1){
                $paid_account = $paid_account + 1;
                $payment = $payment + $row->weekly_income;
            }
            if($row->pay_status==0){
                $accounts_to_be_paid = $accounts_to_be_paid + 1;
                $pending_payment = $pending_payment + $row->weekly_income;
            }
            $weekly_cutoff = $weekly_cutoff + $row->weekly_income;
        }
        $number_of_account = COUNT($query_weekly_income_list->result());

        return array(
            'number_of_account'=>$number_of_account,
            'paid_account'=>$paid_account,
            'accounts_to_be_paid'=>$accounts_to_be_paid,
            'weekly_cutoff'=>$weekly_cutoff,
            'payment'=>$payment,
            'pending_payment'=>$pending_payment,
        );
    }

    public function flushout($date_from,$date_to,$id_main){

        //WE ARE GOING TO GET EACH DATE BETWEEN DATE RANGE
        //CREATE TEMPORARY TABLE
        //WHEREIN WE WILL SAVE ALL ROW THAT PAIRING COUNT IS HIGHER THAN 10

        $this->db->query('DROP TABLE IF EXISTS TempTable');
        $this->db->query('CALL addTempTableForFlushout()');

        $_SESSION['date_from'] = $date_from;
        $_SESSION['start_date_for_diff'] = DateTime::createFromFormat('Y-m-d', $date_from);
        $date_to = DateTime::createFromFormat('Y-m-d', $date_to);

        $_SESSION['days_count'] = $date_to->diff($_SESSION['start_date_for_diff'])->format("%a");
        if($_SESSION['days_count'] == 0){
            $_SESSION['days_count'] = 1;
        }
        // die($_SESSION['days_count'] );
        $test = '';
        do {

            $query2 = $this->db->query("SELECT c.setting,d.cash as 'membership_type_pairing',
            CONCAT(b.reference_nos,' - ',b.last_name,', ',b.first_name,' ',b.middle_name) as 'name',
            COUNT(a.id_main_money) as 'pairing_count',
            SUM(a.cash) as 'pairing_money',
            (COUNT(a.id_main_money) - c.setting) as 'flushout',
            (COUNT(a.id_main_money) - c.setting) * d.cash as 'flushout_money',
    
            (SELECT COUNT(a.id_main_money)
            FROM main_money a
            WHERE
            a.type = 'gift_check'  AND a.id_main = b.id_registration  AND a.del_status = 1 AND
            cast(a.dt as date) = '$_SESSION[date_from]'
            GROUP BY b.id_registration) as 'gc'
    
    
            FROM main_money a INNER JOIN registration b ON a.id_main = b.id_registration
            INNER JOIN settings c ON c.type = 'flushout'
            INNER JOIN main_money_membership_fee d ON d.type = 'membership_type_pairing'
            WHERE
            (a.type='referal_pairing' OR a.type = 'gift_check')  AND a.id_main LIKE '%$id_main' AND a.del_status = 1 AND
            cast(a.dt as date) = '$_SESSION[date_from]'
            GROUP BY b.id_registration");
            $row = $query2->result_array();

            // $test = $test .','. $_SESSION['date_from'];

            if($query2-> num_rows() > 0){
                // $test = $test + 1;
                // print_r($query2->result_array());die($this->db->last_query());
                // die($row[0]['name']);
                $arr = array(
                    'setting'=>$row[0]['setting'], //int
                    'membership_type_pairing'=>$row[0]['membership_type_pairing'], //money
                    'name'=>$row[0]['name'], //text
                    'pairing_count'=>$row[0]['pairing_count'], //int
                    'flushout'=>$row[0]['flushout'], //int
                    'pairing_money'=>$row[0]['pairing_money'], //money
                    'gc'=>$row[0]['gc'], //int
                    'flushout_money'=>$row[0]['flushout_money'], //money
                );
                $this->db->insert("TempTableFlushout",$arr);
            }
          

            $_SESSION['days_count'] = $_SESSION['days_count']  - 1;//LOOP UNTIL DAYS DURATION IS DOWN TO ZERO(0)
            $_SESSION['date_from'] = date('Y-m-d',strtotime($_SESSION['date_from'] . "+1 days"));//EVERY LOOP ADD + 1 TO DATE 
          

        }while($_SESSION['days_count'] != 0);//HANGGANG HINDI PA ZERO UNG DATE DIFF
        // die($test.'x');

        $report_flushout = $this->db->query("SELECT * FROM TempTableFlushout");
        
        // print_r($report_flushout->result_array());die($this->db->last_query().'|'.$test.'x');
        return $report_flushout->result();

        // $query2 = $this->db->query("SELECT c.setting,d.cash as 'membership_type_pairing',
        // CONCAT(b.reference_nos,' - ',b.last_name,', ',b.first_name,' ',b.middle_name) as 'name',
        // COUNT(a.id_main_money) as 'pairing_count',
        // SUM(a.cash) as 'pairing_money',
        // (COUNT(a.id_main_money) - c.setting) as 'flushout',
        // (COUNT(a.id_main_money) - c.setting) * d.cash as 'flushout_money',

        // (SELECT COUNT(a.id_main_money)
        // FROM main_money a
        // WHERE
        // a.type = 'gift_check'  AND a.id_main = b.id_registration  AND a.del_status = 1 AND
        // cast(a.dt as date) BETWEEN  '$date_from' AND '$date_to'
        // GROUP BY b.id_registration) as 'gc'


        // FROM main_money a INNER JOIN registration b ON a.id_main = b.id_registration
        // INNER JOIN settings c ON c.type = 'flushout'
        // INNER JOIN main_money_membership_fee d ON d.type = 'membership_type_pairing'
        // WHERE
        // (a.type='referal_pairing' OR a.type = 'gift_check')  AND a.id_main LIKE '%$id_main' AND a.del_status = 1 AND
        // cast(a.dt as date) BETWEEN  '$date_from' AND '$date_to'
        // GROUP BY b.id_registration");
        // return $query2->result();

    }

    //MULTIPLE
    public function check_for_multi_pairing($gv_id_acc_recruit1,$gv_id_acc_recruit2,$gv_ml_id_main,$gv_sp_id_id_acc_recruit,$gv_sp_count,$gv_id_acc_recruiter1,$gv_id_acc_recruiter2,$sponsorship_last_id,$multi_id_account,$subject_for_multiple_pairing,$first_equal,$row,$id_main){
      
        //GET THE 2 ACCOUNTS UNDER NI SECONDARY ACCOUNT
        // die($gv_id_acc_recruit1.' gv_id_acc_recruit1 | '.$gv_id_acc_recruit2.' gv_id_acc_recruit2');

        //GET 1 NA MAY PAIRING STATUS NA 1 PERO HINDI UNDER NANG SECONDARY PAIRING
        $qry = $this->db->query("SELECT id_sponsorship FROM sponsorship 
        WHERE pairing_status=1 AND row='$_POST[row]' AND id_acc_recruiter!='$gv_id_acc_recruit1' AND id_acc_recruiter!='$gv_id_acc_recruit2' AND del_status = 1   LIMIT 1");
        if($qry-> num_rows() > 0){ 

           //THEN ICOCOMPARE NATIN ITO BAGO TAYO MAG GIVE NANG PAIRING MONEY. IF DI NA REACH NANG VARIABLE NA TO UNG VALUE NANG ROW. SAD TO SAY WALANG PAIRING AT WALANG UPDATE NANG STATUS
            if($first_equal == $row){
                $row_status = $qry->result_array();
                $row_id_sponsorship = $row_status[0]['id_sponsorship'];
                $this->db->query("UPDATE sponsorship SET pairing_status=0 WHERE id_sponsorship='$sponsorship_last_id' ");//LAST INSERTEND ACCOUNT
                $this->db->query("UPDATE sponsorship SET pairing_status=0 WHERE id_sponsorship='$row_id_sponsorship' ");//2ND TO THE LATEST ACCOUNT
    
                // //GET MULTILEVEL ACCOUNT ------------------------------------------------------------------------------------------------------------------------------------
                // $_SESSION['row_recruiter_1'] = $id_main; //HOLD THE ACCOUNT OF RECRUITER OF THE RECRUITER
    
                //SEND BACK TO MODEL
                echo '| from multiple pairing1 | ';
                $arr = explode('|',$subject_for_multiple_pairing);
                $get_id = 0;
                for($i=0;$i<count($arr);$i++){
                    $get_id = $get_id.','.$arr[$i];
                }
    
    
                // return $multi_id_account.','.$gv_sp_id_id_acc_recruit.','.$get_id;//MULTILEVEL
                // $get_id = MGA SUBJECT FOR PAIRING
                return $multi_id_account.','.$get_id;//MULTILEVEL
                // return ;//SECONDARY
            }else{

                //CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.
                $query_get_recruiter_1 = $this->db->query("SELECT id_acc_recruiter FROM sponsorship WHERE id_acc_recruit='$id_main' AND del_status = 1");
                $row_recruiter_1 = $query_get_recruiter_1->result_array();
                $_SESSION['row_recruiter_1'] = $row_recruiter_1[0]['id_acc_recruiter'];
                //CHECK KUNG SINO ANG RECRUITER //TO BE COMPARE SA RECRUITER NANG SINUNDAN NA ACCOUNT SA SAME ROW IF SAME NANG RECRUITER //IF NO END.

                //GET THE 2 ACCOUNTS UNDER NI SECONDARY ACCOUNT
                $qry_get_two_accounts = $this->db->query("SELECT id_acc_recruit FROM sponsorship WHERE id_acc_recruiter='$_SESSION[row_recruiter_1]' AND del_status = 1");
                $row_get_two_accounts = $qry_get_two_accounts->result_array();
                $id_acc_recruit1 = $row_get_two_accounts[0]['id_acc_recruit'];
                $id_acc_recruit2 = $row_get_two_accounts[1]['id_acc_recruit'];

                //GET ALL 
                $qry_get_two_accounts1 = $this->db->query("SELECT id_acc_recruiter
                FROM sponsorship 
                WHERE id_acc_recruiter ='$id_acc_recruit1' OR id_acc_recruiter ='$id_acc_recruit2' AND row = '$row' AND del_status = 1 LIMIT 1 ORDER BY dt ASC  ");
                if($qry_get_two_accounts1->num_rows() > 0){ 
                    $row_get_two_accounts1 = $qry_get_two_accounts1->result_array();
                    $id_acc_recruiter1 = $row_get_two_accounts1[0]['id_acc_recruiter'];
                    echo '| from multiple pairing4 | ';

                }else{
                    echo '| from multiple pairing5 | ';
                }
              

            }

        }else if($_POST['row'] == 2){
            //BIGYAN PA DIN NANG MULTI SI ROW 2. KAC MAX NA NIYA UNG 2 RECRUITER BELOW NIYA.
            //SEND BACK TO MODEL
            if($gv_sp_count == 4 || ($gv_sp_count != 1 && $gv_id_acc_recruiter2 == 0) || ($gv_sp_count == 2 && ($gv_id_acc_recruiter1 != $gv_id_acc_recruiter2)) || ($gv_sp_count == 3 && ($gv_id_acc_recruiter1 == $gv_id_acc_recruiter2))){//BIBIGYAN NANG PAIRING
                $subject_for_multiple_pairing = '';//JUST TO RESET THE ARRAY.
                echo '| from multiple pairing2 | ';
                return $gv_ml_id_main;//SECONDARY
            }else{
                echo '| from multiple pairing3 | ';
            }
        }
    }


    public function pyramid_logic($id){
        $array_recruits = array();//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL SEND BACK TO AJAX.
		$temporary_container = array();//HOLD ALL ACCOUNTS THAT IS NEED TO VALIDATE
		$_SESSION['id_acc_recruiter'] = $id;//PUT THE RECRUITER IN A SESSION
		do{ 
			$query3 = $this->db->query("SELECT *,
			(SELECT count(id_sponsorship) FROM sponsorship WHERE del_status = 1) as 'count',

			(SELECT id_main_position
			FROM sponsorship
			WHERE (id_acc_recruiter='$_SESSION[id_acc_recruiter]' 
			OR id_acc_replacement='$_SESSION[id_acc_recruiter]') AND id_main_position = 0 AND del_status = 1 LIMIT 1) as 'check_left',
								
			(SELECT id_main_position
			FROM sponsorship
			 
			WHERE (id_acc_recruiter='$_SESSION[id_acc_recruiter]' 
			OR id_acc_replacement='$_SESSION[id_acc_recruiter]') AND id_main_position = 1 AND del_status = 1 LIMIT 1) as 'check_right'
			
			FROM sponsorship 
			WHERE 
			(id_acc_recruiter='$_SESSION[id_acc_recruiter]' OR id_acc_replacement='$_SESSION[id_acc_recruiter]')
			AND id_main_position !=2 AND del_status = 1
			");//SEARCH ALL THE RECRUITS OF RECRUITER
			if(!empty($query3->result())){
				foreach($query3->result() as $row_pair3){

					if($row_pair3->check_left == '0' && $row_pair3->check_right == '1'){//IF BOTH SIDE IS OKAY
						//NO PUSH ON A TEMPORARY CONTAINER
						//TEMPORARY CONTAINER HAVE THE ID OF ALL PENDING ACCOUNT NEED TO VALIDATE
						// die($row_pair3->check_left.' | '.$row_pair3->check_right);
						array_push($array_recruits,$row_pair3->id_acc_recruit);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL SEND BACK TO AJAX.
					}else{
						array_push($array_recruits,$row_pair3->id_acc_recruit);
						// array_push($array_recruits,$row_pair3->id_acc_recruiter);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL SEND BACK TO AJAX.
						// array_push($array_recruits,$row_pair3->id_acc_replacement);//THIS ARRAY CONTAINS ALL ACCOUNT THAT WILL SEND BACK TO AJAX.
					}

					
					array_push($temporary_container,$row_pair3->id_acc_recruit);//HOLD ALL ACCOUNTS THAT IS NEED TO VALIDATE
					$temporary_container = array_unique($temporary_container);//DELETE DUPLICATED ID'S
					

					//IPASA SA PANIBAGONG SESSION AND UNANG RECRUIT
					$_SESSION['id_acc_recruiter'] = $row_pair3->id_acc_recruit;

					if($row_pair3->count == 1){//MEANING BY DEFAULT
						$_SESSION['id_acc_recruiter'] = '';//TO END THE LOOP
					}
				}
				
			}else{

				//DELETE THE LAST ID IN TEMPORARY TABLE
				if (($key = array_search($_SESSION['id_acc_recruiter'], $temporary_container)) !== false) {
					unset($temporary_container[$key]);
				}
				if(count($temporary_container) == 0){ //IF HINDI PA UBOS ANG LAMAN NANG TEMP CONTAINER 
					//IUNSET UNG NAKARECRUIT
					//HINDI DAPAT KAC LALABAS UNG SARILI NIYA SA OPTION NANG REPLACEMENT
					// print_r($array_recruits);die('rerer');

					if (($key = array_search($id, $array_recruits)) !== false) {
						unset($array_recruits[$key]);
					}

					//  print_r($array_recruits);die('x');
					$_SESSION['id_acc_recruiter'] = ''; // THIS WILL EXIT THE DO LOOP

				}else{
					//IT WILL PICK AGAIN ANOTHER ID FOR TESTING
					// echo $_SESSION['id_acc_recruiter'].' To Set';
					//  print_r($temporary_container);die('11');
					$get_new_id_in_array = reset($temporary_container); // First element's value //THEN RESET THE ARRAY
					
					if (($key = array_search($get_new_id_in_array, $temporary_container)) !== false) {//REMOVE IN TEMPORARY COINTAINER THE VALUE
						unset($temporary_container[$key]);
					}

					// print_r($temporary_container);die('11');


					$_SESSION['id_acc_recruiter'] = $get_new_id_in_array;

				}
				
			}
		}while($_SESSION['id_acc_recruiter'] != '');


		$_SESSION['array_recruits'] = $array_recruits; 

		array_walk($array_recruits, 'intval');
        $ids = implode(',',$array_recruits);
        

        // CONVERT ID'S INTO ARRAY
        $arr_ids = explode(',',$ids);

        //USING ARRAY UNIQUE TO AVOID DUPLICATE PAIRING MONEY
        $array_unique = array_unique($arr_ids);
        // To reset the keys of all arrays in an array:
        $array_values = array_values($array_unique);

        $ids = implode(',', $array_values);
        
        if(empty($ids)){
            $ids = 0;
        }
        return $ids;
    }

    public function get_date_range($date){
		$GET_MONDAY =  date("Y-m-d", strtotime('monday this week',strtotime($date))); //GET MONDAY OF THE WEEK
		$GET_TUESDAY =  date("Y-m-d", strtotime("-6 days", strtotime($GET_MONDAY))); //GET_FIRST_TUESDAY_OF_PAST_WEEK
		$GET_FRIDAY =  date("Y-m-d", strtotime("4 days", strtotime($GET_MONDAY))); //GET_FIRST_TUESDAY_OF_PAST_WEEK
        
        return array(
            'GET_TUESDAY'=>$GET_TUESDAY,
            'GET_MONDAY'=>$GET_MONDAY,
            'GET_FRIDAY'=>$GET_FRIDAY,
        );
    }

}