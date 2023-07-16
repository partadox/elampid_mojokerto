<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_dt_Mati extends Model
{
    protected $table      = 'tb_data_mati';
    protected $primaryKey = 'id';
    protected $allowedFields = ['akta', 'nik', 'nama', 'kelamin', 'tgl_mati', 'tgl_aju', 'kecamatan', 'kelurahan', 'created', 'edited'];
}
