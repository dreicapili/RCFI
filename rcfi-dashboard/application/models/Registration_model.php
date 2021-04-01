<?php

class Registration_model extends MY_Model{  

    function account_byId ($id_registration){
        $this->db->select("dt,id_registration,reference_nos,CONCAT(last_name,' ',first_name,' ',middle_name) as name");
		if($id_registration != ''){
			$this->db->where("id_registration",$id_registration);
		}
        return $this->db->get("registration");
    }

    function registerAccount($data){
        $this->db->insert('users',$data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }
	
}