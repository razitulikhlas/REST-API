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
        $this->__resTraitConstruct();
        $this->load->library('image_lib');

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

    public function index_delete()
    {
        $kd = $this->delete('id_catalog');

        if ($kd === null) {
            $this->response([
                'status'  => false,
                'message' => 'id tidak boleh kosong',
                'code'    => 21
            ], 400);
        } else {
            $where = array("id_catalog" => $kd);
            if ($this->item->delete($where) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'message' => 'data berhasil di hapus'
                ], 200);
            } else {
                $this->response([
                    'status'  => false,
                    'message' => 'id tidak ditemukan',
                    'code'    => 22
                ], 400);
            }
        }
    }

    public function index_post()
    {
        $id_pedagang = $this->post('id_pedagang');
        $nama        = $this->post('namabarang');
        $harga       = $this->post('harga');
        $deskripsi   = $this->post('deskripsi');
        $gambar1     = $_FILES['gambar1']['name'];
        $gambar2     = $_FILES['gambar2']['name'];
        $gambar3     = $_FILES['gambar3']['name'];
        $eror_message = '';

        $config['upload_path']   = './assets/images/'; // lokasi penyimpanan gambar
        $config['allowed_types'] = 'jpg|png|jpeg|webp'; // format gambar yang bisa di upload

        if ($gambar1 == '') {
            $gambar1 = "blank_profile.png";
        } else {

            $this->load->library('upload', $config);
            $this->_upload_image('gambar1');
        }

        if ($gambar2 == '') {
            $gambar2 = "blank_profile.png";
        } else {
            $this->load->library('upload', $config);
            $this->_upload_image('gambar2');
        }



        if ($gambar3 == '') {
            $gambar3 = "blank_profile.png";
        } else {
            $config['upload_path']   = './assets/images/'; // lokasi penyimpanan gambar
            $config['allowed_types'] = 'jpg|png|jpeg|webp'; // format gambar yang bisa di upload

            $this->load->library('upload', $config);
            $this->_upload_image('gambar3');
        }

        $data = [
            "id_pedagang"      => $id_pedagang,
            "nama_jualan"      => $nama,
            "harga_jualan"     => $harga,
            "deskripsi_jualan" => $deskripsi,
            "gambar1"          => $gambar1,
            "gambar2"          => $gambar2,
            "gambar3"          => $gambar3,
        ];

        $save = $this->item->insert($data);

        if ($save) {
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
    }

    protected function _upload_image($key)
    {
        if (!$this->upload->do_upload($key)) {
            echo $this->upload->display_errors();
        } else {
            $image = $this->upload->data('file_name');
            $config['image_library'] = 'gd2';
            $config['source_image'] = './assets/images/' . $image;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['quality'] = '100%';
            $config['width']  = 800;
            $config['height'] = 800;
            $config['new_image'] = './assets/images/' . $image;
            $this->load->library('image_lib', $config);
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            $this->load->model('resize_model');
        }
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

    public function users_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, 201); // CREATED (201) being the HTTP response code
    }

    public function users_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0) {
            // Set the response and exit
            $this->response(null, 400); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, 204); // NO_CONTENT (204) being the HTTP response code
    }
}
