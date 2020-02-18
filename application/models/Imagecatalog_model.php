<?php

class Imagecatalog_model extends MY_Model
{
    public function __construct()
    {
        $table  = 'catalog_image';
        $id     = 'id_image';
        parent::__construct($table, $id);
    }
}
