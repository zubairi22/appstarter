<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPekerjaan extends Model
{
    protected $table = 'pekerjaan';
    protected $primaryKey = 'pekerjaan_id';
    protected $allowedFields = ['pekerjaan_judul', 'pekerjaan_deskripsi', 'pekerjaan_tgl', 'pekerjaan_status', 'pegawai_id', 'pekerjaan_setuju', 'nilai', 'catatan', 'tgl_verifikasi'];

    public function getData($id, $tgl_awal, $tgl_akhir)
    {
        return $this
            ->where('pegawai_id', $id)
            ->where('pekerjaan_tgl BETWEEN "' . date('Y-m-d', strtotime($tgl_awal)) . '" and "' . date('Y-m-d', strtotime($tgl_akhir)) . '"')
            ->where('pekerjaan_setuju', 0)
            ->orderBy('pekerjaan_tgl', 'asc')
            ->get()->getResultArray();
    }

    public function getJumlah($status)
    {
        return $this
            ->where('pegawai_id', session()->get('user_name'))
            ->where('pekerjaan_setuju', $status)
            ->countAllResults();
    }

    public function getListPekerjaan($id)
    {
        return $this
            ->where('pegawai_id', $id)
            ->where('pekerjaan_status', 0)
            ->orderBy('pekerjaan_tgl', 'asc')
            ->get()->getResultArray();
    }
}
