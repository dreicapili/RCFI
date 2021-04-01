<?php

class User_model extends CI_Model{

    public function edit_user($data,$id){

        $post = $data;
        $post['password'] = password_hash($post['password'], PASSWORD_DEFAULT);
        unset($post['passwordconf']);

        $this->db->where('id_user',$id);
        if($this->db->update('users',$post)){
            return true;
        }else{
            return false;
        }
    }

}