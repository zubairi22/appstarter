<?php

namespace App\Modules\Home\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelListPekerjaan;
use CodeIgniter\Modules\Modules;

class Home extends BaseController
{
    public function __construct()
    {
        $this->model = new ModelListPekerjaan();
    }

    public function index()
    {
        $hitung =  $this->model
            ->select('pekerjaan_setuju as stj, COUNT(pekerjaan_setuju) as jml')
            ->groupBy('pekerjaan_setuju')
            ->orderBy('pekerjaan_setuju', 'asc')
            ->where('user_user_id', session()->get('user_id'))
            ->get()->getResultArray();

        $proses = 0;
        $setuju = 0;
        $tolak = 0;

        if (count($hitung) == 3) {
            $proses = $hitung[0]['jml'];
            $setuju = $hitung[1]['jml'];
            $tolak = $hitung[2]['jml'];
        } else if (count($hitung) == 2) {
            $proses = $hitung[0]['jml'];
            if ($hitung[1]['stj'] == 1) {
                $setuju = $hitung[1]['jml'];
            } else {
                $tolak = $hitung[1]['jml'];
            }
        } else {
            $proses = $hitung[0]['jml'];
        }

        $data = [
            'title' => 'Home',
            'proses' => $proses,
            'setuju' => $setuju,
            'tolak' => $tolak,
            'validation' => \Config\Services::validation()
        ];

        return view('App\Modules\Home\Views\homeView', $data);
    }
}
