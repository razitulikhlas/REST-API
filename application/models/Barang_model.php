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
}
