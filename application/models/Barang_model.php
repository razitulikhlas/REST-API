<?php

class Barang_model extends MY_Model
{
    public function __construct()
    {
        $table  = 'catalog_pedagang';
        $id     = 'id_catalog';
        parent::__construct($table, $id);
    }

    public function updateCatalog($data, $kd)
    {
        $this->db->update('catalog_pedagang', $data, ['id_catalog' => $kd]);
        return $this->db->affected_rows();
    }

    public function getGambar($where)
    {
        $this->db->select('gambar');
        $this->db->from('catalog_image');
        $this->db->join('catalog_pedagang', 'catalog_pedagang.id_catalog = catalog_image.id_catalog');
        $this->db->where('catalog_image.id_catalog', $where);
        //  return $this->db->get_compiled_select();
        return $this->db->get()->result();
        return $this->db->affected_rows();
    }
}
