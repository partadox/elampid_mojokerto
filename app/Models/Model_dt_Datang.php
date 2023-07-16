<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_dt_Datang extends Model
{
    protected $table      = 'tb_data_datang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tgl_datang', 'no_datang', 'kecamatan', 'kelurahan', 'alamat', 'kk', 'asal', 'no', 'nik', 'nama', 'shbkel', 'kelamin', 'created', 'edited'];
}
