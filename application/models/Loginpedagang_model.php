<?php

class Loginpedagang_model extends MY_Model
{
    public function __construct()
    {
        $table  = 'tbl_pedagang';
        $id     = 'id_pedagang';
        parent::__construct($table, $id);
    }

    public function checkactif($data)
    {
        $this->db->get_where("tbl_pedagang", $data);
        return $this->db->affected_rows();
    }

    public function login($username, $password)
    {
        $user = $this->db->get_where("tbl_pedagang", ["email_pedagang" => $username])->row();
        if ($user) {
            if ($user->aktif == '1') {
                if (password_verify($password, $user->password)) {
                    return $user;
                } else {
                    return 20;
                }
            } else {
                return 22;
            }
        } else {
            return 23;
        }
    }

    public function verify($data)
    {
        $this->db->get_where("tbl_pedagang", $data);
        return $this->db->affected_rows();
    }

    public function getEmail($email)
    {
        return $this->db->get_where("tbl_pedagang", ["email_pedagang" => $email])->result_array();
    }
}
