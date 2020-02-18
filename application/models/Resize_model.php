<?php

class Resize_model extends MY_Model
{
    public function __construct()
    {
        $table  = 'resize';
        $id     = 'id';
        parent::__construct($table, $id);
    }

    public function checkemail($email)
    {
        $this->db->get_where("tbl_pedagang", ["email_pedagang" => $email])->row();
        return $this->db->affected_rows();
    }
    public function checknohp($nohp)
    {
        $this->db->get_where("tbl_pedagang", ["nohp_pedagang" => $nohp])->row();
        return $this->db->affected_rows();
    }
}
