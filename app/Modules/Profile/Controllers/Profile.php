<?php

namespace App\Modules\Profile\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelPegawai;
use CodeIgniter\Modules\Modules;

class Profile extends BaseController
{
    public function __construct()
    {
        $this->model = new ModelPegawai();
    }

    public function index()
    {
        $agama = ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Khonghucu'];

        $data = [
            'title' => 'Profile Pengguna',
            'pegawai'  => $this->model->where(['pegawai_id' => session()->get('user_name')])->first(),
            'agama' => $agama,
            'validation' => \Config\Services::validation()
        ];

        echo view('App\Modules\Profile\Views\profileUser', $data);
    }

    public function updateProfile($id)
    {

        $this->model->save([
            'pegawai_id' => ($id),
            'pegawai_nama' => $this->request->getVar('pegawai_nama'),
            'pegawai_tempat_lahir' => $this->request->getVar('pegawai_tempat_lahir'),
            'pegawai_tanggal_lahir' => $this->request->getVar('pegawai_tanggal_lahir'),
            'pegawai_kelamin' => $this->request->getVar('pegawai_kelamin'),
            'pegawai_agama' => $this->request->getVar('pegawai_agama'),
            'pegawai_email' => $this->request->getVar('pegawai_email'),
            'pegawai_alamat' => $this->request->getVar('pegawai_alamat')

        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to(base_url('profile'));
    }

    public function updateFoto($id)
    {
        if (!$this->validate([
            'file_upload' => [
                'rules' => 'uploaded[file_upload]|mime_in[file_upload,image/jpg,image/jpeg,image/gif,image/png,image/svg]|max_size[file_upload,4096]',
            ],
        ])) {
            session()->setFlashdata('error', 'Ada Kesalahan');
            return redirect()->to(base_url('profile'));
        }

        $avatar = $this->request->getFile('file_upload');
        $avatar->move(ROOTPATH . 'public/assets/img/foto/');

        $this->model->save([
            'pegawai_id' => ($id),
            'pegawai_foto' => $avatar->getName()

        ]);

        session()->set('pegawai_foto', $avatar->getName());
        session()->setFlashdata('pesan', 'Foto berhasil diubah');

        return redirect()->to(base_url('profile'));
    }
}
