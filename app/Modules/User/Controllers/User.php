<?php

namespace App\Modules\user\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelListPekerjaan;
use CodeIgniter\Modules\Modules;

class User extends BaseController
{
    protected $listModel;

    public function __construct()
    {
        $this->listModel = new ModelListPekerjaan();
    }

    public function index()
    {
        $data = [
            'title' => 'Pekerjaan',
            'list'  => $this->listModel->getListPekerjaan(session()->get('user_id')),
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\user\Views\userDashboard', $data);
    }

    function prosesTambahPekerjaan()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|max_length[40]',
                'errors' => [
                    'required' => 'Judul Harus diisi',
                    'max_length' => 'Judul Maksimal 40 Karakter'
                ]
            ],
            'deskripsi' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi Harus diisi',
                ]
            ],
            'tanggal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal Harus diisi',
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->to(base_url('user'))->withInput()->with('validation', $validation);
        }

        $this->listModel->save([
            'pekerjaan_judul' => $this->request->getVar('judul'),
            'pekerjaan_deskripsi' => $this->request->getVar('deskripsi'),
            'pekerjaan_tgl' => $this->request->getVar('tanggal'),
            'pekerjaan_status' => 0,
            'pekerjaan_setuju' => 0,
            'user_user_id' => session()->get('user_id')
        ]);

        session()->setFlashdata('pesan', 'Pekerjaan berhasil ditambah');

        return redirect()->to(base_url('user'));
    }

    function update()
    {
        $id = $this->request->getPost('id');

        $this->listModel->save([
            'pekerjaan_id' => ($id),
            'pekerjaan_status' => 1,
        ]);
    }

    function hapus()
    {
        $id = $this->request->getPost('id');
        $this->listModel->delete($id);
    }
}
