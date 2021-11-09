<?php

namespace App\Modules\Login\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelAkun;
use CodeIgniter\Modules\Modules;

class Login extends BaseController
{
    public function __construct()
    {
        $this->model = new ModelAkun();
    }

    public function index()
    {
        $data = [
            'title' => 'Login Pengguna',
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Login\Views\loginForm', $data);
    }

    public function prosesLogin()
    {
        if (!$this->validate([
            'user_name' => [
                'rules' => 'required|is_not_unique[user.user_name]',
                'errors' => [
                    'required' => 'Username Tidak Boleh Kosong',
                    'is_not_unique' => 'Akun tidak ditemukan'
                ]
            ],
            'user_password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '*Password Tidak Boleh Kosong'
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $data = [
            'user_name' => $this->request->getPost('user_name'),
            'user_password' => $this->request->getPost('user_password'),
        ];

        $tabel = $this->model->where(['user_name' => $data['user_name']])->first();
        //dd($this->model->tes());

        //dd($tabel);

        if ($tabel) {
            if (password_verify($data['user_password'], $tabel['user_password'])) {
                $struktur = $this->model->getStruktur($tabel['user_name']);
                session()->set([
                    'user_name' => $data['user_name'],
                    'user_id' => $tabel['user_id'],
                    'jabatan' => $struktur['jabatan_status'],
                    'jabatan_id' => $struktur['jabatan_id'],
                    'struktur_id' => $struktur['struktur_id'],
                    'struktur_parent' => $struktur['struktur_parent'],
                    'pegawai_foto' => $struktur['pegawai_foto'],
                    'logged_in' => TRUE
                ]);

                if ($tabel['user_level_id'] == 1) {
                    session()->set([
                        'user_level_id' => 1
                    ]);
                } else if ($tabel['user_level_id'] == 2) {
                    session()->set([
                        'user_level_id' => 2
                    ]);
                } else if ($tabel['user_level_id'] == 3) {
                    session()->set([
                        'user_level_id' => 3
                    ]);
                } else {
                    session()->set([
                        'user_level_id' => 4,
                    ]);
                }
                return redirect()->to(base_url('home'));
            } else {
                session()->setFlashdata('pesan', 'Password Salah');
                return redirect()->back()->withInput();
            }
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
