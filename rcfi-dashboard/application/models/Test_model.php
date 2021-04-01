<?php

class Test_model extends CI_Model{ 

    //THIS FUNCTION DO.
    //BIBIGYAN LAHAT NANG PAIRING COMMISION ANG LAHAT NAGN UPLINE 
    function test(){
        $_SESSION['id_acc_recruiter'] = 35;// PASS THE ID OF RECRUITER TO THIS SESSION
        do{

            $query3 = $this->db->query("SELECT id_acc_recruiter FROM sponsorship WHERE id_acc_recruit = '$_SESSION[id_acc_recruiter]'");//FIND THE RECRUITER
            if(!empty($query3->result())){//IF MAY RECRUITER NA NAKITA
                foreach($query3->result() as $row_pair3){
                    $_SESSION['id_acc_recruiter']=$row_pair3->id_acc_recruiter;//ID OF X RECRUITER

                   
                    echo $_SESSION['id_acc_recruiter'].', DONE ,';


                    $this->db->query("INSERT INTO main_money(id_main_process,id_main,type,cash)
                    VALUES('1','$_SESSION[id_acc_recruiter]','referal_pairing','200')");


                    
                }
            }else{//IF WALANG RECRUITER UNG ACCOUNT, MEANS SIYA ANG TUKTOK NANG PIRAMYD, AND THIS LOOP ENDS HERE NOW
                $_SESSION['id_acc_recruiter'] = 0;
            }

           
            
        }while($_SESSION['id_acc_recruiter'] > 0);//HANGGANG MAS MATAAS KAY ZERO, TRUE ANG STATEMENT
        //ADD PAIRING BONUS SA LAHAT NANG UPLINES

	} 

}