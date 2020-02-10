<?php

class Dokter_model extends CI_Model{
    public function getDokter($id = null){
        if($id === null){
            return $this->db->get('tbl_dokter')->result_array();
        }else{
            return $this->db->get_where('tbl_dokter',['kd_dokter' => $id])->result_array();
        }
        
    }

    public function deleteDokter($kd){
        $this->db->delete('tbl_dokter',['kd_dokter' => $kd]);
        return $this->db->affected_rows();
    }

    public function createDokter($data){
        $this->db->insert('tbl_dokter',$data);
        return $this->db->affected_rows();
    }

    public function updateDokter($data,$kd){
        $this->db->update('tbl_dokter',$data,['kd_dokter' => $kd]);
        return $this->db->affected_rows();
    }
}