<?php

class Unit_model extends CI_Model{

    function check_duplicate_unit(){
        $code = $this->input->post('code');
        $unit = $this->input->post('unit');
        $result = $this->db->query("SELECT id_unit FROM unit 
        WHERE (unit='$unit' OR code='$code') AND del_status = 1 ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function check_duplicate_rooms($id_unit){
        $code = $this->input->post('code');
        $room = $this->input->post('room');
        $result = $this->db->query("SELECT id_room FROM rooms
        WHERE (room='$room' OR code='$code') AND id_unit='$id_unit' AND del_status = 1 ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function check_duplicate_rooms_edit($id_unit){
        $code = $this->input->post('code');
        $room = $this->input->post('room');
        $id_room = $this->input->post('id_room');
        $result = $this->db->query("SELECT id_room FROM rooms
        WHERE (room='$room' OR code='$code') AND id_room != '$id_room' AND id_unit='$id_unit' AND del_status = 1 ");
        if($result-> num_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function add_unit(){
        unset($_POST['id_unit']);
        $this->db->insert('unit',$this->input->post());
    }

    function add_rooms($id_unit){
        unset($_POST['id_room']);
        $_POST['id_unit'] = $id_unit;
        $this->db->insert('rooms',$this->input->post());
    }

    public function get_unit_list(){
        $this->db->where('del_status',1);
        $query = $this->db->get('unit');
        return $query->result();
    }

    public function get_rooms_list($id_unit){
        $this->db->where('id_unit',$id_unit);
        $this->db->where('del_status',1);
        $query = $this->db->get('rooms');
        return $query->result();
    }

    public function for_edit_room_data(){
        $id_room = $this->input->post('id_room');
        $this->db->where('id_room',$id_room);
        $this->db->where('del_status',1);
        $query = $this->db->get('rooms');
        return $query->result();
    }


    public function view_unit($id_unit){
        $this->db->where('id_unit',$id_unit);
        $this->db->where('del_status',1);
        $query = $this->db->get('unit');

        foreach($query->result() as $table_row){
            return array(
                'id_unit' => $table_row->id_unit,
                'code' => $table_row->code,
                'floors_count' => $table_row->floors_count,
                'unit' => $table_row->unit,
                'description' => $table_row->description,
                'dt' => $table_row->dt,
            );
        }
    }

    public function delete_unit(){
        $this->db->where('id_unit',$this->input->post('id'));
        $query = $this->db->UPDATE('unit',array('del_status' => 0));
    }

    public function edit_rooms(){
        $id_room = $this->input->post('id_room');
        unset($_POST['id_room']);
        $this->db->where('id_room',$id_room);
        $query = $this->db->UPDATE('rooms',$this->input->post());
    }

}