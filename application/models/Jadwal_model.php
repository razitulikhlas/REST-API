<?php

class Jadwal_model extends CI_Model{

    public function getJadwal($id = null){
        if($id === null){
            
            $query = "SELECT kd_jadwal,tbl_spesialis.nama AS 'poli',tbl_dokter.nama AS 'dokter',
            waktu,tanggal,status,tbl_jadwal.keterangan
            FROM tbl_jadwal,tbl_spesialis,tbl_dokter
            WHERE
            tbl_jadwal.kd_poli = tbl_spesialis.kd_spesialis &&
            tbl_jadwal.kd_dokter = tbl_dokter.kd_dokter;
            ";
        }else{

            $query = "SELECT kd_jadwal,tbl_spesialis.nama AS 'poli',tbl_dokter.nama AS 'dokter',
            waktu,tanggal,status,tbl_jadwal.keterangan
            FROM tbl_jadwal,tbl_spesialis,tbl_dokter
            WHERE
            tbl_jadwal.kd_poli = tbl_spesialis.kd_spesialis &&
            tbl_jadwal.kd_dokter = tbl_dokter.kd_dokter &&
            kd_jadwal = $id ;
            ";
        }

        return $this->db->query($query)->result_array();
        
    }

    public function deleteJadwal($kd){
        $this->db->delete('tbl_jadwal',['kd_jadwal' => $kd]);
        return $this->db->affected_rows();
    }

    public function createJadwal($data){
        $this->db->insert('tbl_jadwal',$data);
        return $this->db->affected_rows();
    }

    public function updateJadwal($data,$kd){
        $this->db->update('tbl_jadwal',$data,['kd_jadwal' => $kd]);
        return $this->db->affected_rows();
    }
}