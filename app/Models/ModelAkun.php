<?php


namespace App\Models;

use CodeIgniter\Model;

class ModelAkun extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id', 'user_name', 'pegawai_id', 'user_level_id', 'user_password'];

    public function getStruktur($id)
    {
        return $this
            ->select('user.user_id,user.user_name,user.user_level_id,b.pegawai_nama,b.pegawai_foto,c.pegawai_jabatan_id,d.jabatan_id, d.jabatan_nama,d.jabatan_status, e.struktur_id,e.struktur_nama,e.struktur_parent')
            ->join('pegawai AS b', 'user.pegawai_id = b.pegawai_id', 'left')
            ->join('pegawai_jabatan AS c', 'b.pegawai_id = c.pegawai_id', 'left')
            ->join('jabatan AS d', 'c.jabatan_id = d.jabatan_id', 'left')
            ->join('struktur AS e', 'd.struktur_id = e.struktur_id')
            ->where('user.user_name', $id)
            ->get()->getRowArray();
    }

    public function tes()
    {
        return $this->db->table('user as a')
            ->select('a.user_id,a.user_name,a.user_level_id,b.pegawai_nama,c.pegawai_jabatan_id,d.jabatan_id, d.jabatan_nama,d.jabatan_status, e.struktur_id,e.struktur_nama,e.struktur_parent')
            ->join('pegawai AS b', 'a.pegawai_id = b.pegawai_id', 'left')
            ->join('pegawai_jabatan AS c', 'b.pegawai_id = c.pegawai_id', 'left')
            ->join('jabatan AS d', 'c.jabatan_id = d.jabatan_id', 'left')
            ->join('struktur AS e', 'd.struktur_id = e.struktur_id')
            ->get()->getResultArray();
    }
}
