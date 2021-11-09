<?php

namespace App\Modules\Nilai\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelPekerjaan;
use App\Models\ModelPegawai;
use CodeIgniter\Modules\Modules;

class Nilai extends BaseController
{

    public function __construct()
    {
        $this->model = new ModelPekerjaan();
        $this->pegawaiModel = new ModelPegawai();
    }

    public function index()
    {
        $bulan = $this->request->getGet('bulan');

        $nilai = $this->model
            ->select('sum(nilai) as nilai, b.pegawai_id, pegawai_nama, pekerjaan_tgl, pegawai_foto, jabatan_nama')
            ->join('pegawai as b', 'b.pegawai_id = pekerjaan.pegawai_id', 'right')
            ->join('pegawai_jabatan AS c', 'b.pegawai_id = c.pegawai_id')
            ->join('jabatan AS d', 'c.jabatan_id = d.jabatan_id')
            ->groupBy('b.pegawai_id')
            ->where('month(pekerjaan_tgl)', substr($bulan, -2))
            ->where('year(pekerjaan_tgl)', substr($bulan, 0, -3))
            ->get()->getResultArray();

        $data = [
            'title' => 'Laporan Kinerja',
            'nilai' => $nilai,
            'bulan' => $bulan,
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Nilai\Views\nilaiView', $data);
    }
}
