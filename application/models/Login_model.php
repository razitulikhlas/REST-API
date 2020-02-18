<?php

class Login_model extends CI_Model
{
    public function getAll($id = null)
    {
        if ($id === null) {
            return $this->db->get('login')->result_array();
        } else {
            return $this->db->get_where('login', ['id' => $id])->result_array();
        }
    }

    public function delete($kd)
    {
        $this->db->delete('login', ['id' => $kd]);
        return $this->db->affected_rows();
    }

    public function insert($data)
    {
        $this->db->insert('login', $data);
        return $this->db->affected_rows();
    }

    public function updateDokter($data, $kd)
    {
        $this->db->update('login', $data, ['id' => $kd]);
        return $this->db->affected_rows();
    }
}
