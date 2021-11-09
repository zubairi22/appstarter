<?php

namespace App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelPekerjaan;
use App\Models\ModelPegawai;
use CodeIgniter\Modules\Modules;

class Laporan extends BaseController
{
    protected $listModel;
    protected $pegawaiModel;

    public function __construct()
    {
        $this->listModel = new ModelPekerjaan();
        $this->pegawaiModel = new ModelPegawai();
    }

    public function index()
    {
        $list = $this->listModel->where(['pegawai_id' => session()->get('user_name'), 'pekerjaan_status' => 1])->find();

        $data = [
            'title' => 'Laporan Pekerjaan',
            'list' => $list
        ];

        return view('App\Modules\Laporan\Views\laporanPekerjaan', $data);
    }

    public function laporanPegawai()
    {
        $pegawaiSelected = $this->request->getGet('pegawai_id');
        $tgl_awal = $this->request->getGet('tanggal_mulai');
        $tgl_akhir = $this->request->getGet('tanggal_akhir');

        if (session()->get('jabatan') == 'KEPALA' && session()->get('struktur_id') < 7) {
            $list = $this->listModel->getData($pegawaiSelected, $tgl_awal, $tgl_akhir);
            $pegawaiStruktur = $this->pegawaiModel->getPegawaiStrukturParent(session()->get('struktur_id'));
        } else if (session()->get('jabatan') == 'KEPALA' && session()->get('struktur_id') > 6) {
            $list = $this->listModel->getData($pegawaiSelected, $tgl_awal, $tgl_akhir);
            $pegawaiStruktur = $this->pegawaiModel->getPegawaiStruktur(session()->get('struktur_id'));
        }

        $data = [
            'title' => 'Laporan Pegawai',
            'pegawai' => $pegawaiStruktur,
            'selected' => $pegawaiSelected,
            'list' => $list
        ];

        return view('App\Modules\Laporan\Views\laporanPegawai', $data);
    }

    function setuju()
    {
        $id = $this->request->getPost('id');

        $this->listModel->save([
            'pekerjaan_id' => $id,
            'pekerjaan_setuju' => 3,
            'nilai' => 5,
            'tgl_verifikasi' => date("Y-m-d")
        ]);
    }

    function update()
    {

        $id = $this->request->getPost('id');
        $status = $this->request->getPost('st');

        if ($status == 2) {
            $nilai = 3;
        } else {
            $nilai = 0;
        }

        $this->listModel->save([
            'pekerjaan_id' => $id,
            'pekerjaan_setuju' => $status,
            'nilai' => $nilai,
            'catatan' => $this->request->getPost('catatan'),
            'tgl_verifikasi' => date("Y-m-d")

        ]);
    }
}
