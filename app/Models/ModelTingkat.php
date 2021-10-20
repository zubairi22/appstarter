<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTingkat extends Model
{
    protected $table = 'user_level';
    protected $primaryKey = 'user_level_id';
    protected $allowedFields = ['user_level_id', 'user_level_name'];
}
