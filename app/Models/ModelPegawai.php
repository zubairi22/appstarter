<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPegawai extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'pegawai_id';
    protected $allowedFields = ['pegawai_id', 'pegawai_nama', 'pegawai_status', 'pegawai_tempat_lahir', 'pegawai_tanggal_lahir', 'pegawai_kelamin', 'pegawai_agama', 'pegawai_email', 'pegawai_alamat', 'pegawai_foto'];

    public function getPegawaiStruktur($id_struktur, $id_user)
    {
        return $this
            ->join('user as b', 'b.pegawai_id = pegawai.pegawai_id')
            ->join('pegawai_jabatan AS c', 'pegawai.pegawai_id = c.pegawai_id')
            ->join('jabatan AS d', 'c.jabatan_id = d.jabatan_id')
            ->where('d.struktur_id', $id_struktur)
            ->where('b.user_id !=', $id_user)
            ->get()->getResultArray();
    }

    public function getPegawaiStrukturParent($id_struktur)
    {
        return $this
            ->join('user as b', 'b.pegawai_id = pegawai.pegawai_id')
            ->join('pegawai_jabatan AS c', 'pegawai.pegawai_id = c.pegawai_id')
            ->join('jabatan AS d', 'c.jabatan_id = d.jabatan_id')
            ->join('struktur as e', 'd.struktur_id = e.struktur_id')
            ->where('e.struktur_parent', $id_struktur)
            ->where('d.jabatan_status', 'KEPALA')
            ->get()->getResultArray();
    }
}
