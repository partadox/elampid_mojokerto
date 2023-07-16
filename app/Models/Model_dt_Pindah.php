<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_dt_Pindah extends Model
{
    protected $table      = 'tb_data_pindah';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tgl_pindah', 'skpwni', 'kk', 'nik', 'nama', 'kelamin', 'alamat', 'tujuan', 'kecamatan', 'kelurahan', 'created', 'edited'];
}
