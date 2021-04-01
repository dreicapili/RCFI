STORED PROCEDURE
BEGIN

-- DECLARATION
DECLARE    recruiter        INT;
DECLARE    replacement        INT;
DECLARE    str      VARCHAR(100);-- WILL HOLD ALL THE ID SUBJECT FOR COMMISION



-- SET VALUE
SET recruiter = param_recruiter; -- RECRUITER ID
SET replacement = param_replacement; -- REPLACEMENT ID
SET str = '' ;





 -- LOOP FOR RECRUITER ----------------------------------------------------------------
REPEAT   
-- GET ALL REPLACEMENT AND RECRUITER BY LOOP
-- GUMAMIT NANG INTO SA SELECT PARA HINDI IDISPLAY NI QUERY UNG OUTPUT
SELECT  
COUNT(id_sponsorship),
if(id_acc_recruiter IS NULL OR id_acc_recruiter = '',0,id_acc_recruiter), 
if(id_acc_replacement IS NULL OR id_acc_replacement = '',0,id_acc_replacement)
INTO @id_sponsorship,@id_acc_recruiter,@id_acc_replacement 
FROM `sponsorship` WHERE id_acc_recruit = recruiter OR id_acc_recruit = replacement;

-- COMBINE ALL ID IN ONE VARIABLE
set str = CONCAT(str,',',recruiter,',',replacement,',',@id_acc_recruiter,',',@id_acc_replacement);


-- VARIABLE FOR THE NEXT LOOP
-- IF THIS = 0 THE LOOP IS OVER
IF @id_acc_recruiter = 0 AND @id_acc_replacement =0 THEN
	SET   recruiter    =  0; -- LOOP TO END
    SET   replacement    =  0; -- LOOP TO END
ELSE
	SET   recruiter    =  @id_acc_recruiter;
    SET   replacement    =  @id_acc_replacement;
END IF;


UNTIL  recruiter <=0 AND replacement <=0-- REPEAT UNTIL
END REPEAT; 
 -- LOOP FOR RECRUITER ----------------------------------------------------------------
 
 




-- RETURN ID'S
SELECT  SUBSTR(str,2) as 'list_of_account';

END













REGISTER ACCOUNT.
public function register_account(){
		//DECLARIATION
		$row_pair5_check_left = '';
		$row_pair5_check_right = '';
		$row_pair5_id_acc_replacement = '';
		//VARIABLES
		$get_self_account  = $this->input->post("get_self_account");
		$membership_type_amount  = $this->input->post("membership_type_amount");
		$membership_type_commission  = $this->input->post("membership_type_commission");
		$membership_type_pairing  = $this->input->post("membership_type_pairing");
		$id_acc_recruiter = $this->input->post('id_acc_recruiter');
		$id_main_position = $this->input->post('id_main_position');
		$id_acc_replacement = $this->input->post('id_acc_replacement');
		$id_main_process = 1; //account_registration

		//PAIRING ARRAY
		$account_will_get_pairing_money = array();

		 
		//UNSET 
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
		$sponsor_data[] = array(
			'id_acc_recruit' => $last_id,
			'id_acc_recruiter' => $id_acc_recruiter,
			'id_acc_replacement' => $id_acc_replacement,
			'id_main_position' => $id_main_position,
		);
		$this->db->insert("sponsorship",$sponsor_data[0]);
		
		//SAVE COMMISION IN MONEY
		$commision_money_data[] = array(
			'id_main_process' => $id_main_process,
			'id_main' => $id_acc_recruiter,
			'type' => 'referal_commision',
			'cash' => $membership_type_commission,
		);
		$this->db->insert("main_money",$commision_money_data[0]);
		
		
		//CHECK PAIRING
		// $query_pair = $this->db->query("SELECT * FROM sponsorship WHERE id_acc_recruiter='$id_acc_recruiter' AND pairing_status=0 "); //PAY STATUS IS FOR VALIDATION ONLY
		// if($id_acc_replacement != ''){
		// 	$query_pair = $this->db->query("SELECT * FROM sponsorship WHERE id_acc_replacement='$id_acc_replacement' AND pairing_status=0 
		// 	ORDER BY dt ASC"); //PAY STATUS IS FOR VALIDATION ONLY
		// }else{
			$query_pair = $this->db->query("SELECT * FROM sponsorship WHERE id_acc_recruiter='$id_acc_recruiter' AND id_acc_replacement='$id_acc_replacement' AND pairing_status=0 
			UNION ALL
			SELECT * FROM sponsorship WHERE id_acc_replacement='$id_acc_recruiter' AND pairing_status=0 
			ORDER BY dt ASC"); //PAY STATUS IS FOR VALIDATION ONLY
		// }
		
		// print_r($query_pair->result_array());die(); 2 sa huli

		foreach($query_pair->result() as $row_pair){

			//JUST TO MAKE SURE THAT EVERY 2 ROW OF SPONSORSHIP WILL BE TEST
			if($first_position == ''){
				$first_position = $row_pair->id_main_position;
				//GET ALL ID, OF SPONSORSHIP 
				$id_sponsorship1 = $row_pair->id_sponsorship;
			}else if($second_position == ''){
				$second_position = $row_pair->id_main_position;
				//GET ALL ID, OF SPONSORSHIP
				$id_sponsorship2 = $row_pair->id_sponsorship;
			}
			
		
			if($first_position != '' && $second_position !=''){//HINDI MAG EXECUTE HANGGANG MAY BAKANTE SA DALAWA
				$sum = $first_position + $second_position;
				
				//IF SUM IS = 1 MEANING CONFIRM PAIRING
				if($sum == 1){
					//UPDATE PAY STATUS FROM 0 TO 1
					//SO THE NEXT TIME, IT WILL NOT BE INCLUDED IN THE LOOP
					$this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship1'");	
					// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship2'");

					//CHECKER IF LEFT AND RIGHT OF RECRUITER/REPLACMENT IS HAVE
					//IF YES UPDATE THEIR PAIRING STATUS = 1
					$query5 = $this->db->query("SELECT id_sponsorship,

					-- CHECK LEFT OF REPLACEMENT
					(SELECT id_main_position
					FROM sponsorship
					WHERE (id_acc_replacement = '$id_acc_replacement') AND id_main_position = 0 LIMIT 1) as 'check_left',
					
					-- CHECK LEFT OF REPLACEMENT
					(SELECT id_main_position
					FROM sponsorship
					WHERE (id_acc_replacement = '$id_acc_replacement') AND id_main_position = 1 LIMIT 1) as 'check_right',

					-- CHECK IF RECRUITER HAVE RECRUITER
					(SELECT count(id_sponsorship) FROM sponsorship 
					WHERE id_acc_recruit='$id_acc_recruiter') as 'if_have_recruiter',

					-- ORIG PAIRING MEANS NO REPLACEMENT USED
					(SELECT COUNT(orig_paring) FROM sponsorship 
					WHERE id_acc_recruiter='$id_acc_recruiter' AND id_acc_replacement = 0 AND orig_paring = 0) as 'orig_pairing_status'
					
					FROM sponsorship WHERE id_acc_replacement = '$id_acc_replacement' AND id_acc_replacement != '' LIMIT 1
					");//FIND THE RECRUITER OF THE RECRUITER
					if(!empty($query5->result())){//IF MAY RECRUITER NA NAKITA
						foreach($query5->result() as $row_pair5){

							$if_have_recruiter = $row_pair5->if_have_recruiter;//TO TEST IF MAY NAG RECRUIT SA NAGRECRUIT
							$orig_pairing_status = $row_pair5->orig_pairing_status;//ID OF X RECRUITER
							$row_pair5_check_left = $row_pair5->check_left;//ID OF X RECRUITER
							$row_pair5_check_right = $row_pair5->check_right;//ID OF X RECRUITER
							$row_pair5_id_acc_replacement = $id_acc_replacement;//ID OF X RECRUITER

							if($orig_pairing_status == 2){

								$this->db->query("UPDATE sponsorship SET orig_paring=1 WHERE id_acc_replacement = 0 AND orig_paring=0 AND id_acc_recruiter='$id_acc_recruiter'");

								if($row_pair5_check_left == 0 && $row_pair5_check_right == 1){//CHECK IF BOTH SIDE OF REPLACEMENT IS OKAY
									// $this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_acc_replacement='$row_pair5_id_acc_replacement'");
				
									//GIVE PARING MONEY TO REPLACEMENT ACCOUNT
									if($row_pair5_id_acc_replacement != 0 || $row_pair5_id_acc_replacement != '0' || $row_pair5_id_acc_replacement != '' || $row_pair5_id_acc_replacement != NULL || $row_pair5_id_acc_replacement != null){
										// $this->db->query("INSERT INTO main_money(id_main_process,id_main,type,cash)
										// VALUES('$id_main_process','$row_pair5_id_acc_replacement','referal_pairing5','$membership_type_pairing')");

										array_push($account_will_get_pairing_money, $row_pair5_id_acc_replacement);
									}
									
								}

							}
							
						}
					}

					array_push($account_will_get_pairing_money, $id_acc_recruiter);

					//ADD PAIRING BONUS SA LAHAT NANG UPLINES/RECRUITER
					$_SESSION['id_acc_recruiter'] = $id_acc_recruiter;// PASS THE ID OF RECRUITER TO THIS SESSION

					//QUERY TO GET THE POSITION OF REPLACEMENT
					$query_get_position = $this->db->query("SELECT id_main_position FROM sponsorship 
					WHERE id_acc_recruiter = '$_SESSION[id_acc_recruiter]' AND id_acc_replacement='$id_acc_replacement' 
					ORDER BY id_sponsorship ASC
					LIMIT 1");
					$result_get_position = $query_get_position->result_array();
					//NOW THE ID MAIN POSITIN IS
					$result_get_position = $result_get_position[0]['id_main_position'];

					// print_r($query_get_position->result_array());die( ' | '.$_SESSION['id_acc_recruiter'].' | '.$id_acc_replacement); // 0 | 2 | 3
					do{ 

						//  die($result_get_position.' position'); //0
						
						$query3 = $this->db->query("SELECT id_acc_recruiter,id_acc_replacement
						FROM sponsorship 
						WHERE id_acc_recruit = '$_SESSION[id_acc_recruiter]' OR id_acc_recruiter = '$_SESSION[id_acc_recruiter]' 
						AND id_acc_replacement != 0 AND pairing_status = 0  AND id_main_position = '$result_get_position'
						
						GROUP BY id_acc_replacement
						ORDER BY id_acc_replacement DESC");//FIND THE RECRUITER OF THE RECRUITER
						// print_r($query3->result_array());die();
						if(!empty($query3->result())){//IF MAY RECRUITER NA NAKITA
							foreach($query3->result() as $row_pair3){

									$_SESSION['id_acc_recruiter'] = $row_pair3->id_acc_recruiter;//ID OF X RECRUITER
									$id_acc_replacement_from_first_cycle = $row_pair3->id_acc_replacement;//GET THE REPLACEMENT ACCOUNT AND GIVE PAIRING MONEY
									array_push($account_will_get_pairing_money, $id_acc_replacement_from_first_cycle);//ORIGINAL REPLACEMENT
		

			
									//THIS CONDITION IS PARA MABIGYAN NANG PAIRING MONEY LAHAT NANG REPLACEMENT NI RECRUITER
									if($_SESSION['id_acc_recruiter'] == $id_acc_recruiter){
										$_SESSION['id_acc_recruiter'] = $row_pair3->id_acc_replacement;//ID OF X RECRUITER
										// ADD PAIRING MONEY ALSO TO THE ACCOUNT USED FOR REPLACEMENT
										if($_SESSION['id_acc_recruiter'] != 0 || $_SESSION['id_acc_recruiter'] != '0'){

											array_push($account_will_get_pairing_money, $_SESSION['id_acc_recruiter']);
											array_push($account_will_get_pairing_money, $id_acc_replacement);
										}// ADD PAIRING MONEY ALSO TO THE ACCOUNT USED FOR REPLACEMENT

									}else{
										array_push($account_will_get_pairing_money, $_SESSION['id_acc_recruiter']);

										//REPLACEMENT TO REPLACEMENT
										$query4 = $this->db->query("SELECT id_acc_replacement FROM sponsorship WHERE id_acc_recruit = '$id_acc_replacement'");//FIND THE RECRUITER
										foreach($query4->result() as $row_pair4){

											array_push($account_will_get_pairing_money, $id_acc_replacement);//ORIGINAL REPLACEMENT
											

											$id_acc_replacement=$row_pair4->id_acc_replacement;//ID OF X RECRUITER
											if($id_acc_replacement != 0){
												array_push($account_will_get_pairing_money, $id_acc_replacement);//REPLACEMENT FOUND DURING THE CYCLE
											} 
										}//REPLACEMENT TO REPLACEMENT
									}
									

							
		
							}

							// print_r($account_will_get_pairing_money);die();
						}else{//IF WALANG RECRUITER UNG ACCOUNT, MEANS SIYA ANG TUKTOK NANG PIRAMYD, AND THIS LOOP ENDS HERE NOW
							$_SESSION['id_acc_recruiter'] = 0; // THIS WILL EXIT THE DO LOOP
						}
						
					}while($_SESSION['id_acc_recruiter'] > 0);//HANGGANG MAS MATAAS KAY ZERO, TRUE ANG STATEMENT
					//ADD PAIRING BONUS SA LAHAT NANG UPLINES/RECRUITER

					//ADD PAIRING BONUS SA LAHAT NANG REPLACEMENT
				}

				if($row_pair5_check_left == 0 && $row_pair5_check_right == 1){//CHECK IF BOTH SIDE OF REPLACEMENT IS OKAY
					$this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_acc_replacement='$row_pair5_id_acc_replacement'");

					//GIVE PARING MONEY TO REPLACEMENT ACCOUNT
					// if($row_pair5_id_acc_replacement != 0 || $row_pair5_id_acc_replacement != '0' || $row_pair5_id_acc_replacement != '' || $row_pair5_id_acc_replacement != NULL || $row_pair5_id_acc_replacement != null){
					// 	$this->db->query("INSERT INTO main_money(id_main_process,id_main,type,cash)
					// 	VALUES('$id_main_process','$row_pair5_id_acc_replacement','referal_pairing4','$membership_type_pairing')");
					// }
					
				}
				
				//RESET VARIABLE POSITION, FOR THE ANOTHER SET OF 2 ROW
				//$first_position ='';
				
				$second_position ='';
			} 
			

		}

		//GET ACCOUNTS WHO WILL GET PAIRING MONEY
		//USING ARRAY UNIQUE TO AVOID DUPLICATE PAIRING MONEY
		$array_unique = array_unique($account_will_get_pairing_money);

		// To reset the keys of all arrays in an array:
		$array_unique = array_values($array_unique);

		// print_r($array_unique);die(' haha');


		for($x = 0; $x < count($array_unique); $x++){

			$this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship1'");	
			$this->db->query("UPDATE sponsorship SET pairing_status=1 WHERE id_sponsorship='$id_sponsorship2'");

			//ID'S
			$id_main = $array_unique[$x];

			//COUNT NUMBER OF PAIRING
			//IF PAIRING COUNT REACHED 4 THEN GIVE GC INSTEAD
			$query = $this->db->query("SELECT COUNT(id_main_money) as 'pairing_count'
			FROM main_money WHERE id_main = '$id_main' AND type = 'referal_pairing'");
			$row = $query->result_array();

			// print_r($query->result_array());die(' he');

			if($row[0]['pairing_count'] < 4){//IF BELOW OR EQUAL TO 4
				$array_money[] = array(
					'id_main_process' => $id_main_process,
					'id_main' => $array_unique[$x],
					'type' => 'referal_pairing',
					'cash' => $membership_type_pairing,
				);
				$this->db->insert("main_money",$array_money[$x]);
			}else{
				$array_money[] = array(
					'id_main_process' => $id_main_process,
					'id_main' => $array_unique[$x],
					'type' => 'gift_check',
					'cash' => 1,
				);
				$this->db->insert("main_money",$array_money[$x]);
			}

			// print_r($array_unique);die(' haha');
		}
		// print_r($array_unique);die(' haha');
		// print_r($array_unique);die();
		
    }