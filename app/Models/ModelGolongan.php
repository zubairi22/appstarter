<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelGolongan extends Model
{
    protected $table = 'golongan';
    protected $primaryKey = 'golongan_id';
    protected $allowedFields = ['golongan_id', 'golongan_nama'];
}
