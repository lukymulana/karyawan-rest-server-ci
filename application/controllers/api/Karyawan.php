<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Karyawan extends CI_Controller {

    use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    public function __construct() {
        parent::__construct();
        $this->__resTraitConstruct();
        $this->load->model('Karyawan_model', 'karyawan');
    }

    public function index_get() {
        $emp_no = $this->get('emp_no');

        if ($emp_no === null) {
            $karyawan = $this->karyawan->getKaryawan();
        } else {
            $karyawan = $this->karyawan->getKaryawan($emp_no);
        }
        
        if($karyawan) {
            $this->response([
                'status' => true,
                'data' => $karyawan
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data Karyawan Tidak Ditemukan'
            ], 404 );
        }
    }

    public function index_delete() {
        $emp_no = $this->delete('emp_no');

        if ($emp_no === null) {
            $this->response([
                'status' => false,
                'message' => 'ID Tidak Boleh Kosong'
            ], 400 );
        } else {
            if ($this->karyawan->deleteKaryawan($emp_no) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'emp_no' => $emp_no,
                    'message' => 'Data Berhasil Dihapus'
                ], 200);
            } else {
                // id not found
                $this->response([
                    'status' => false,
                    'message' => 'ID Tidak Ditemukan'
                ], 400 );
            }
        }
    }

    public function index_post() {
        $data = [
            'emp_no' => $this->post('emp_no'),
            'birth_date' => $this->post('birth_date'),
            'first_name' => $this->post('first_name'),
            'last_name' => $this->post('last_name'),
            'gender' => $this->post('gender'),
            'hire_date' => $this->post('hire_date')
        ];

        if ($this->karyawan->createKaryawan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data gagal disimpan'
            ], 400);
        }
    }

    public function index_put() {
        $emp_no = $this->put('emp_no');

        $data = [
            'emp_no' => $this->put('emp_no'),
            'birth_date' => $this->put('birth_date'),
            'first_name' => $this->put('first_name'),
            'last_name' => $this->put('last_name'),
            'gender' => $this->put('gender'),
            'hire_date' => $this->put('hire_date')
        ];

        if ($this->karyawan->updateKaryawan($data, $emp_no) > 0) {
            $this->response([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Data gagal diubah'
            ], 400);
        }
    }
}