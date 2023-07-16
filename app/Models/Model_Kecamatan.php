<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Kecamatan extends Model
{
    protected $table      = 'tb_kecamatan';
    protected $primaryKey = 'idc';
    protected $useAutoIncrement = false;
    protected $allowedFields = [];

    public function list()
    {
        return $this->table('tb_kecamatan')
            ->orderBy('idc', 'ASC')
            ->get()->getResultArray();
    }
}
