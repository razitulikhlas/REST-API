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
class Login extends CI_Controller
{

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Login_model', 'login');
        $this->__resTraitConstruct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['users_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['users_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['users_delete']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function index_get()
    {
        $kd = $this->get('id');
        if ($kd === null) {
            $login = $this->login->getAll();
        } else {
            $login = $this->login->getAll()($kd);
        }


        if ($login) {
            $this->response([
                'status' => true,
                'data' => $login
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'kd not found'
            ], 404);
        }
    }

    public function index_delete($id)
    {
        // $kd = $this->delete('id');
        //methode delete di model
        echo $id;

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'kode tidak boleh kosong',
                'id'   => $id
            ], 400);
        } else {
            if ($this->login->delete($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'message' => 'data berhasil di hapus',
                    'id'   => $id
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'kd not found',
                    'id'   => $id
                ], 404);
            }
        }
    }

    public function index_post()
    {

        $foto        = $_FILES['gambar']['name'];
        $email       = $this->post('email');
        $password    = $this->post('password');

        if ($foto == '') {
            $foto = 'blank_profile.png';
        } else {
            $config['upload_path']   = './assets/images/'; // lokasi penyimpanan gambar
            $config['allowed_types'] = 'jpg|png|jpeg|webp'; // format gambar yang bisa di upload

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('gambar')) {
                // jika foto gagal di inputkan
                echo "failed upload foto";
            } else {
                $foto = $this->upload->data('file_name');
            }
        }

        $data = [
            "email"    => $email,
            "password" => $password,
            "gambar"   => base_url() . 'assets/images/' . $foto
        ];

        if ($this->login->insert($data) > 0) {
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

    public function index_put()
    {
        $kode_dokter     = $this->put('kd_dokter');
        $namadokter     = $this->put('nama');
        $jeniskelamin    = $this->put('jk');
        $nohp             = $this->put('nohp');
        $noizin            = $this->put('noizin');
        $alamat         = $this->put('alamat');
        $provinsi        = $this->put('provinsi');
        $kota             = $this->put('kota');
        $kecamatan         = $this->put('kecamatan');
        $kelurahan        = $this->put('kelurahan');
        $kotalahir        = $this->put('kotalahir');
        $tanggal_lahir     = $this->put('tgllahir');
        $spesialis         = $this->put('spesialis');
        $email             = $this->put('email');
        $password         = $this->put('password');
        $foto             = $this->put('foto');

        $kd = $kode_dokter;
        $data = [
            'nama'            => $namadokter,
            'jenis_kelamin'    => $jeniskelamin,
            'nohp'            => $nohp,
            'noizin'        => $noizin,
            'alamat'        => $alamat,
            'provinsi'        => $provinsi,
            'kota'            => $kota,
            'kecamatan'        => $kecamatan,
            'kelurahan'        => $kelurahan,
            'tampat_lahir'    => $kotalahir,
            'tanggal_lahir' => $tanggal_lahir,
            'spesialis'        => $spesialis,
            'email'            => $email,
            'password'      => $password,
            'photo'            => $foto
        ];

        if ($this->dokter->updateDokter($data, $kd) > 0) {
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
