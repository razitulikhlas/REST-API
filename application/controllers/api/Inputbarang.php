<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */

//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class Inputbarang extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Barang_model', 'item');
        $this->load->model('Imagecatalog_model', 'image');
        $this->__resTraitConstruct();
        $this->load->library('image_lib');
        $this->load->library('Authorization_Token');

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        $kd = $this->get('kd_dokter');
        if ($kd === null) {
            $dokter = $this->dokter->getDokter();
        } else {
            $dokter = $this->dokter->getDokter($kd);
        }


        if ($dokter) {
            $this->response([
                'status' => true,
                'data' => $dokter
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'kd not found'
            ], 404);
        }
    }

    protected function uploadimage_post()
    {
        $id_pedagang = $this->post('id_pedagang');
        $id_catalog  = $this->post('id_catalog');
        $id_pedagang = $this->post('id_pedagang');
        $gambar      = $_FILES['gambar']['name'];

        $folder = './assets/images/catalog/catalog-pedagang-' . $id_pedagang . '/';

        $config['upload_path']   = $folder; // lokasi penyimpanan gambar
        $config['allowed_types'] = 'jpg|png|jpeg|webp'; // format gambar yang bisa di upload

        if ($gambar == '') {
            $gambar = "blank_profile.png";
        } else {
            $this->load->library('upload', $config);
            $this->_upload_image('gambar', $id_pedagang);
        }

        $data = array(
            "id_catalog" => $id_catalog,
            "gambar"     => $gambar
        );

        $save = $this->image->insert($data);

        if ($save) {
            $this->response([
                'status' => true,
                'message' => 'gambar berhasil di upload'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gambar gagal di upload'
            ], 400);
        }
    }

    protected function uploadimage_delete()
    {
        $id_pedagang = $this->post('id_pedagang');
        $kd = $this->delete('id_image');
        if ($kd === null) {
            $this->response([
                'status'  => false,
                'message' => 'id tidak boleh kosong',
                'code'    => 21
            ], 400);
        } else {
            $image = $this->image->get($kd);
            $where = array("id_image" => $kd);
            if ($this->image->delete($where) > 0) {
                // delete gambar di folder
                $this->_deleteImage($image->gambar, $id_pedagang);
                // response sukses
                $this->response([
                    'status' => true,
                    'message' => 'data berhasil di hapus',
                ], 200);
            } else {
                // response gagal
                $this->response([
                    'status'  => false,
                    'message' => 'id tidak ditemukan',
                    'code'    => 22
                ], 400);
            }
        }
    }

    protected function uploadimageupdate_post()
    {
        $id_pedagang = $this->post('id_pedagang');
        $id_image    = $this->post('id_image');
        $id_catalog  = $this->post('id_catalog');
        $gambar      = $_FILES['gambar']['name'];

        $folder = './assets/images/catalog/catalog-pedagang-' . $id_pedagang . '/';

        $config['upload_path']   = $folder; // lokasi penyimpanan gambar
        $config['allowed_types'] = 'jpg|png|jpeg|webp'; // format gambar yang bisa di upload

        if ($gambar == '') {
            $gambar = "blank_profile.png";
        } else {
            $this->load->library('upload', $config);
            $this->_upload_image('gambar', $id_pedagang);
        }

        // ambil data image yang ingin di hapus
        $image = $this->image->get($id_image);

        // menentukan image yang ingin  di hapus
        $where = array(
            "id_image" => $id_image
        );

        // data yang akan di update
        $data = array(
            "id_catalog" => $id_catalog,
            "gambar"     => $gambar
        );

        if ($this->image->update($data, $where) > 0) {
            $this->_deleteImage($image->gambar, $id_pedagang);
            $this->response([
                'status' => true,
                'message' => 'gambar berhasil di update'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'gambar gagal diupdate'
            ], 400);
        }
    }


    public function index_delete()
    {
        $kd          = $this->delete('id_catalog');

        // check token
        $is_valid_token = $this->authorization_token->validateToken();

        if (!empty($is_valid_token) and $is_valid_token['status'] == TRUE) {
            if ($kd === null) {
                $this->response([
                    'status'  => false,
                    'message' => 'id tidak boleh kosong',
                    'code'    => 21
                ], 400);
            } else {
                $image = $this->item->getGambar($kd);
                $where = array("id_catalog" => $kd);
                // $this->item->delete($where) > 0
                if ($this->item->delete($where) > 0) {
                    $id_pedagang = $this->delete('id_pedagang');
                    // ok
                    // fungsi mengahpus gambar di tabel catalog_image
                    $this->image->delete($where);
                    foreach ($image as $row) {
                        $this->_deleteImage($row->gambar, $id_pedagang);
                    }
                    // response sukses
                    $this->response([
                        'status' => true,
                        'message' => 'data berhasil di hapus',
                        'data' => $image
                    ], 200);
                } else {
                    $this->response([
                        'status'  => false,
                        'message' => 'id tidak ditemukan',
                        'code'    => 22
                    ], 400);
                }
            }
        } else {
            // faile authentikasi token
            $this->response([
                'status' => false,
                'message' => $is_valid_token['message']
            ], 400);
        }
    }

    public function index_post()
    {
        // $id_pedagang = $this->post('id_pedagang');
        $nama        = $this->post('namabarang');
        $harga       = $this->post('harga');
        $deskripsi   = $this->post('deskripsi');

        $is_valid_token = $this->authorization_token->validateToken();
        // var_dump($is_valid_token);
        // exit;

        if (!empty($is_valid_token) and $is_valid_token['status'] == TRUE) {
            // aksi
            $data = [
                "id_pedagang"      => $is_valid_token["data"]->id,
                "nama_jualan"      => $nama,
                "harga_jualan"     => $harga,
                "deskripsi_jualan" => $deskripsi,
            ];
            $save = $this->item->insert($data);

            if ($save) {
                // mkdir('./assets/images/catalog/catalog-pedagang-' . $id_pedagang);
                $this->response([
                    'status' => true,
                    'message' => 'data berhasil di tambahkan'
                ], 201);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'data gagal ditambahkan'
                ], 400);
            }
        } else {
            // faile authentikasi token
            $this->response([
                'status' => false,
                'message' => $is_valid_token['message']
            ], 400);
        }
    }

    protected function _upload_image($key, $id)
    {
        $folder = './assets/images/catalog/catalog-pedagang-' . $id . '/';
        // echo $folder;
        // die();
        if (!$this->upload->do_upload($key)) {
            echo $this->upload->display_errors();
        } else {
            $image = $this->upload->data('file_name');
            $config['image_library'] = 'gd2';
            $config['source_image'] = $folder . $image;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '100%';
            $config['width']  = 800;
            $config['height'] = 800;
            $config['new_image'] = $folder . $image;
            $this->load->library('image_lib', $config);
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->load->model('resize_model');
        }
    }


    protected function _deleteImage($old, $id)
    {
        $folder = './assets/images/catalog/catalog-pedagang-' . $id . '/';
        $target = $folder . $old;
        if (file_exists($target)) {
            unlink($target);
        }

        // if (file_exists($target)) {
        //     echo "Failed delet" . $target;
        // } else {
        //     echo "sukses delete" . $target;
        // }
    }


    protected function _watermark()
    {
        $image = $this->upload->data('file_name');
        $config['source_image'] = './assets/images/' . $image;
        $config['wm_text'] = 'Copyright 2006 - Razitul Ikhlas';
        $config['wm_type'] = 'text';
        $config['wm_font_path'] = './system/fonts/texb.ttf';
        $config['wm_font_size'] = '16';
        $config['wm_font_color'] = 'ffffff';
        $config['wm_vrt_alignment'] = 'bottom';
        $config['wm_hor_alignment'] = 'center';
        $config['wm_padding'] = '20';

        $this->image_lib->initialize($config);

        $this->image_lib->watermark();
    }

    public function index_put()
    {
        $id_catalog  = $this->put('id_catalog');
        $id_pedagang = $this->put('id_pedagang');
        $nama        = $this->put('namabarang');
        $harga       = $this->put('harga');
        $deskripsi   = $this->put('deskripsi');


        $where = array('id_catalog' => $id_catalog);

        $data = [
            "id_pedagang"      => $id_pedagang,
            "nama_jualan"      => $nama,
            "harga_jualan"     => $harga,
            "deskripsi_jualan" => $deskripsi
        ];

        if ($this->item->update($data, $where) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data berhasil di update'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data gagal diupdate'
            ], 400);
        }
    }
}
