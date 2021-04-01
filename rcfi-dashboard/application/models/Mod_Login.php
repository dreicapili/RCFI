<?php

class Mod_Login extends CI_Model{

    public function verify_username($username){
        $this->db->where('username',$username);
        $query = $this->db->get('users');
        return $query->result();
    }

    function vendor_count(){
        return 5;
    }

}