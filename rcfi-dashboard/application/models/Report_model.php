<?php

class Report_model extends MY_Model{  

    function getTopEarners(){
        $query = $this->db->query("
        SELECT 

 		(SELECT CONCAT(r.reference_nos,' - ',r.last_name,', ', r.first_name,' ', r.middle_name) as account
         FROM `main_money` m
         INNER JOIN registration r ON r.id_registration = m.id_main
         WHERE m.id_main = mm.id_main 
         AND m.type != 'gift_check'
         GROUP BY r.id_registration) as 'account',
         
        (SELECT sum(cash) FROM `main_money` WHERE id_main = mm.id_main AND type != 'gift_check') as 'cash'

        FROM `main_money` as mm

        GROUP BY id_main
        ORDER BY cash DESC

        ");
        return $query->result();
    }
	
}