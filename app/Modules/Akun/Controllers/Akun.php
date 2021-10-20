<?php

namespace App\Modules\Akun\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAkun;
use App\Models\ModelTingkat;
use CodeIgniter\Modules\Modules;

class Akun extends BaseController
{

    public function __construct()
    {
        $this->akunModel = new ModelAkun();
        $this->tingkatModel = new ModelTingkat();
    }

    public function index()
    {
        $akun =  $this->akunModel
            ->join('pegawai as b', 'b.pegawai_id=user.pegawai_id')
            ->get()->getResultArray();

        $tersedia =  $this->akunModel
            ->join('pegawai as b', 'b.pegawai_id=user.pegawai_id', 'right')
            ->where('user_id is null')
            ->get()->getResultArray();

        $data = [
            'title' => 'Data Pengguna',
            'user'  => $akun,
            'tersedia' => $tersedia,
            'list' => $this->tingkatModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Akun\Views\adminAkun', $data);
    }

    public function tambah()
    {
        if (!$this->validate([
            'user_name' => [
                'rules' => 'required|min_length[16]|max_length[18]|is_unique[user.user_name]|is_not_unique[pegawai.pegawai_id]',
                'errors' => [
                    'required' => 'NIP Harus diisi',
                    'min_length' => 'NIP Minimal 16 Karakter',
                    'max_length' => 'NIP Maksimal 18 Karakter',
                    'is_unique' => 'NIP Sudah terdaftar',
                    'is_not_unique' => 'NIP Tidak ada didalam database pegawai'
                ]
            ],
            'user_password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Harus diisi',
                ]
            ],
        ])) {
            session()->setFlashdata('gagal', 'tambah');
            return redirect()->to(base_url('akun'))->withInput();
        }

        $data = [
            'user_name' => $this->request->getVar('user_name'),
            'pegawai_id' => $this->request->getVar('user_name'),
            'user_password' => password_hash($this->request->getVar('user_password'), PASSWORD_DEFAULT),
            'user_level_id' => $this->request->getVar('user_level')
        ];

        $this->akunModel->save($data);

        session()->setFlashdata('pesan', 'ditambah');

        return redirect()->to(base_url('akun'));
    }

    public function getDataUpdate()
    {
        $id = $this->request->getPost('id');
        $query = $this->akunModel->where('user_id', $id)->first();
        echo json_encode($query);
    }

    public function update()
    {
        if (!$this->validate([
            'user_password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Harus diisi',
                ]
            ]
        ])) {
            session()->setFlashdata('gagal', 'update');
            return redirect()->to(base_url('akun'))->withInput();
        }

        $user = $this->request->getVar('user_name');
        $level = $this->request->getVar('user_level');

        $data = [
            'user_name' => $user,
            'pegawai_id' => $user,
            'user_password' => password_hash($this->request->getVar('user_password'), PASSWORD_DEFAULT),
            'user_level_id' => $level
        ];

        $this->akunModel->update($this->request->getVar('id'), $data);

        if ($user == session()->get('user_name')) {
            session()->set('user_level_id', $level);
        }

        session()->setFlashdata('pesan', 'diubah');

        return redirect()->to(base_url('akun'));
    }

    function hapus()
    {
        $id = $this->request->getPost('id');
        $this->akunModel->delete($id);
    }
}
