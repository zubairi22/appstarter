<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelListPekerjaan extends Model
{
    protected $table = 'list_pekerjaan';
    protected $primaryKey = 'pekerjaan_id';
    protected $allowedFields = ['pekerjaan_judul', 'pekerjaan_deskripsi', 'pekerjaan_tgl', 'pekerjaan_status', 'user_user_id', 'pekerjaan_setuju'];

    public function getData($id, $tgl_awal, $tgl_akhir)
    {
        return $this
            ->where('user_user_id', $id)
            ->where('pekerjaan_tgl BETWEEN "' . date('Y-m-d', strtotime($tgl_awal)) . '" and "' . date('Y-m-d', strtotime($tgl_akhir)) . '"')
            ->where('pekerjaan_setuju', 0)
            ->orderBy('pekerjaan_tgl', 'asc')
            ->get()->getResultArray();
    }

    public function getListPekerjaan($id)
    {
        return $this
            ->where('user_user_id', $id)
            ->where('pekerjaan_status', 0)
            ->orderBy('pekerjaan_tgl', 'asc')
            ->get()->getResultArray();
    }
}
