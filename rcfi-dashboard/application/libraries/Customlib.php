<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Customlib
{

    public $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('system_model', '', true);
        $this->CI->load->model('customer_model', '', true);
    }

    public function get_days_count($date_from,$date_to){
        if(empty($date_from) || empty($date_to)){
            return 0;
        }
        $start_date  = DateTime::createFromFormat('Y-m-d', $date_from);
        $end_date = DateTime::createFromFormat('Y-m-d', $date_to);
        return $end_date->diff($start_date)->format("%a"); // days_count
    }


    public function pairing_logic($left_ , $right_){
        $flushout_count = $left_;
        if($right_ < $left_){
            $flushout_count = $right_;
        }
        return $flushout_count;
    }


}
