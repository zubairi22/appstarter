<?php

namespace App\Modules\Pegawai\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelGolongan;
use App\Models\ModelPegawai;
use CodeIgniter\Modules\Modules;

class Pegawai extends BaseController
{
    public function __construct()
    {
        $this->pegawaiModel = new ModelPegawai();
        $this->golonganModel = new ModelGolongan();
    }

    public function index()
    {

        $agama = ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Khonghucu'];

        $data = [
            'title' => 'Data Pegawai',
            'pegawai'  => $this->pegawaiModel->get()->getResultArray(),
            'golongan' => $this->golonganModel->get()->getResultArray(),
            'agama' => $agama,
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Pegawai\Views\pegawaiView', $data);
    }

    function tambah()
    {
        if (!$this->validate([
            'pegawai_id' => [
                'rules' => 'required|min_length[16]|max_length[18]|is_unique[user.user_name]',
                'errors' => [
                    'required' => 'NIP Harus diisi',
                    'min_length' => 'NIP Minimal 16 Karakter',
                    'max_length' => 'NIP Maksimal 18 Karakter',
                    'is_unique' => 'NIP Sudah terdaftar'
                ]
            ],
            'pegawai_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Harus diisi',
                ]
            ],
            'pegawai_status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pilih Status Pegawai',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal', 'tambah');
            return redirect()->to(base_url('pegawai'))->withInput()->with('validation', $validation);
        }

        $data = [
            'pegawai_id' => $this->request->getVar('pegawai_id'),
            'pegawai_nama' => $this->request->getVar('pegawai_nama'),
            'golongan_id' => $this->request->getVar('golongan'),
            'pegawai_status' => $this->request->getVar('status'),
            'pegawai_tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'pegawai_tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'pegawai_kelamin' => $this->request->getVar('jk'),
            'pegawai_npwp' => $this->request->getVar('npwp'),
            'pegawai_agama' => $this->request->getVar('agama'),
            'pegawai_email' => $this->request->getVar('email'),
            'pegawai_alamat' => $this->request->getVar('alamat'),
        ];

        $this->pegawaiModel->insert($data);

        session()->setFlashdata('pesan', 'ditambah');

        return redirect()->to(base_url('pegawai'));
    }

    function update()
    {
        if (!$this->validate([
            'pegawai_nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Harus diisi',
                ]
            ],
            'tempat_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tempat Lahir Harus diisi',
                ]
            ],
            'alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Harus diisi',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('gagal', 'update');
            return redirect()->to(base_url('pegawai'))->withInput()->with('validation', $validation);
        }

        $data = [
            'pegawai_id' => $this->request->getVar('pegawai_id'),
            'pegawai_nama' => $this->request->getVar('pegawai_nama'),
            'golongan_id' => $this->request->getVar('golongan'),
            'pegawai_status' => $this->request->getVar('status'),
            'pegawai_tempat_lahir' => $this->request->getVar('tempat_lahir'),
            'pegawai_tanggal_lahir' => $this->request->getVar('tanggal_lahir'),
            'pegawai_kelamin' => $this->request->getVar('jk'),
            'pegawai_npwp' => $this->request->getVar('npwp'),
            'pegawai_agama' => $this->request->getVar('agama'),
            'pegawai_email' => $this->request->getVar('email'),
            'pegawai_alamat' => $this->request->getVar('alamat')
        ];

        $this->pegawaiModel->save($data);

        session()->setFlashdata('pesan', 'ditambah');

        return redirect()->to(base_url('pegawai'));
    }

    public function getDataUpdate()
    {
        $id = $this->request->getPost('id');
        $query = $this->pegawaiModel->where('pegawai_id', $id)->first();
        echo json_encode($query);
    }

    function hapus()
    {
        $id = $this->request->getPost('id');
        $this->pegawaiModel->delete($id);
    }
}
