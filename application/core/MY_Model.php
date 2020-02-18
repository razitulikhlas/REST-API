<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected $table;
    protected $id;

    public function __construct($table, $id)
    {
        $this->table      = $table;
        $this->id         = $id;
    }

    //fungsi untuk memasukan data kedalam tabel
    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    //fungsi untuk mengupdate data yang ada ditabel
    public function update($data, $where)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    //fungsi untuk mengambil semua field yang ada ditabel
    public function get($id = null)
    {
        if ($id === null) {
            return $this->db->get($this->table)->row();
        } else {
            return $this->db->get_where($this->table, [$this->id => $id])->row();
        }
    }




    //fungsi untuk mengambil sebagian field yang ada ditabel
    public function getInfo($select)
    {
        $this->db->select($select);
        return $this->db->get($this->table)->result_array();
    }

    //fungsi untuk mengambil field yang ada di tabel menggunakan where
    // public function getWhere($select,$where){
    //     $hasil;
    //     /**
    //      * Jika yang diselect tidak ada maka tampilkan semua field,
    //      * Tapi jika ada yang diselect maka tampilkan apa yang ingin diselect
    //     */
    //     if($select==""){
    //         $hasil = $this->db->get_where($this->table,$where)->row_array();
    //     }else{
    //         $this->db->select($select);
    //         $hasil = $this->db->get_where($this->table,$where)->row_array();
    //     }
    //     return $hasil;
    // }

    public function getAllWhere($where)
    {
        return  $this->db->get_where($this->table, $where)->result_array();
    }

    public function getWhere($where)
    {
        return  $this->db->get_where($this->table, $where)->row();
    }

    public function getDetailWhere($where)
    {
        return  $this->db->get_where($this->detail, $where)->result_array();
    }

    //fungsi untuk mengahapus data yang ada ditabel
    public function delete($where)
    {
        $this->db->delete($this->table, $where);
        return $this->db->affected_rows();
    }

    //fungsi untuk mengahapus data yang ada ditabel detail
    public function deleteDetail($where)
    {
        $this->db->delete($this->detail, $where);
        return $this->db->affected_rows();
    }

    // get gambar berdasarkan id catalog


    //fungsi untuk ambil subharga
    public function subHarga($sum, $join, $where)
    {
        $this->db->select_sum($sum);
        $this->db->from($this->table);
        $this->db->join($this->detail, $join);
        $this->db->where('no_faktur', $where);
        //  return $this->db->get_compiled_select();
        return $this->db->get()->row();
    }

    //fungsi untuk menghitung jumlah data
    public function getCount()
    {
        return $this->db->count_all_results($this->table, FALSE);
    }



    public function getRincian($select, $join, $where)
    {
        $this->db->select($select);
        $this->db->from($this->table);
        $this->db->join($this->detail, $join);
        $this->db->where('no_faktur', $where);
        // return $this->db->get_compiled_select();
        return $this->db->get()->result();
    }
}
