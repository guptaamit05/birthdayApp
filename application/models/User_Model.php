<?php

    // MODEL:  User_model
    class User_model extends CI_Model
    { 

    // CONSTRUCTOR DEFINATION
    public function __construct() {

    } 


    // INSERT NEW RECORD INTO DATABASE
    public function insertData($table, $dta){
        
        $this->db->insert($table, $dta);
        return $this->db->insert_id();
    }


    // TO UPDATE THE EXISTING RECORD IN A TABLE
    public function updateData($table, $where, $data){

        $this->db->where($where);
        return $this->db->update($table, $data);
    }


    // NOW GET THE NAME OF THE USER WHO WISH TO ME ON MY BIRTHDAY
    public function getJoinData($user_id){

        $q = $this->db->query("select w_user.id, w_user.wished_to, user.first_name, user.last_name, w_user.message, w_user.created_date from tbl_wished_list w_user LEFT JOIN tbl_user user ON user.user_id = w_user.user_id WHERE w_user.wished_to = ".$user_id." ORDER BY w_user.created_date DESC");
        return $q->result_array();
    }


    // GET ONE ROW DATA FROM THE DATABASE
    public function getOneRowData($table, $where){

        $this->db->where($where);
        return $this->db->get($table)->row_array();
    }



    // GET ALL ROWS DATA FROM THE DATABASE
    public function getAllRowData($table, $where){

        $this->db->where($where);
        return $this->db->get($table)->result_array();
    }




}
