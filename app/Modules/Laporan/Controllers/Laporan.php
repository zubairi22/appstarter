<?php

namespace App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelListPekerjaan;
use App\Models\ModelPegawai;
use CodeIgniter\Modules\Modules;

class Laporan extends BaseController
{
    protected $listModel;
    protected $pegawaiModel;

    public function __construct()
    {
        $this->listModel = new ModelListPekerjaan();
        $this->pegawaiModel = new ModelPegawai();
    }

    public function index()
    {
        $list = $this->listModel->where(['user_user_id' => session()->get('user_id'), 'pekerjaan_status' => 1])->find();

        $data = [
            'title' => 'Laporan Pekerjaan',
            'list' => $list
        ];

        return view('App\Modules\Laporan\Views\laporanPekerjaan', $data);
    }

    public function laporanPegawai()
    {
        $pegawaiSelected = $this->request->getGet('user_id');
        $tgl_awal = $this->request->getGet('tanggal_mulai');
        $tgl_akhir = $this->request->getGet('tanggal_akhir');

        // d(session()->get('jabatan'));
        // d(session()->get('struktur_parent'));

        if (session()->get('jabatan') == 'KEPALA' && session()->get('struktur_id') < 7) {
            $list = $this->listModel->getData($pegawaiSelected, $tgl_awal, $tgl_akhir);
            $pegawaiStruktur = $this->pegawaiModel->getPegawaiStrukturParent(session()->get('struktur_id'));
        } else if (session()->get('jabatan') == 'KEPALA' && session()->get('struktur_id') > 6) {
            $list = $this->listModel->getData($pegawaiSelected, $tgl_awal, $tgl_akhir);
            $pegawaiStruktur = $this->pegawaiModel->getPegawaiStruktur(session()->get('struktur_id'), session()->get('user_id'));
        }
        // d($this->pegawaiModel->getPegawai(session()->get('struktur')));
        // d(session()->get('struktur'));

        $data = [
            'title' => 'Laporan Pegawai',
            'pegawai' => $pegawaiStruktur,
            'selected' => $pegawaiSelected,
            'list' => $list
        ];

        return view('App\Modules\Laporan\Views\laporanPegawai', $data);
    }

    // function updatePekerjaan($id)
    // {

    //     $this->listModel->save([
    //         'pekerjaan_id' => ($id),
    //         'pekerjaan_setuju' => $this->request->getPost('tes'),
    //     ]);

    //     dd($this->request->getPost('tes'));

    //     session()->setFlashdata('pesan', 'Pekerjaan Berhasil diteruskan');

    //     return redirect()->to(base_url('user'));
    // }

    function update($id, $status)
    {

        $this->listModel->save([
            'pekerjaan_id' => $id,
            'pekerjaan_setuju' => $status,
        ]);

        return redirect()->to(base_url('laporan/laporanPegawai'))->withInput();
    }
}
