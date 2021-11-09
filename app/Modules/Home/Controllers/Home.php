<?php

namespace App\Modules\Home\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelPekerjaan;
use CodeIgniter\Modules\Modules;

class Home extends BaseController
{
    public function __construct()
    {
        $this->model = new ModelPekerjaan();
    }

    public function index()
    {

        $nilai = $this->model
            ->select('sum(nilai) as nilai, b.pegawai_id, pegawai_nama, pekerjaan_tgl')
            ->join('pegawai as b', 'b.pegawai_id = pekerjaan.pegawai_id', 'right')
            ->groupBy('b.pegawai_id')
            ->where('month(pekerjaan_tgl)', date('m'))
            ->get()->getResultArray();

        //dd($nilai);

        $data = [
            'title' => 'Home',
            'proses' => $this->model->getJumlah(0),
            'tolak' => $this->model->getJumlah(1),
            'setuju' => $this->model->getJumlah(2) + $this->model->getJumlah(3),
            'nilai' => $nilai,
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Home\Views\homeView', $data);
    }
}
