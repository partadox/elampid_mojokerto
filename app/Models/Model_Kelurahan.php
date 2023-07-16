<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Kelurahan extends Model
{
    protected $table      = 'tb_kelurahan';
    protected $primaryKey = 'idl';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['kec'];

    public function list()
    {
        return $this->table('tb_kelurahan')
            ->orderBy('idl', 'ASC')
            ->get()->getResultArray();
    }

    public function list_only_kelurahan()
    {
        return $this->table('tb_kelurahan')
            ->select('idl')
            ->orderBy('idl', 'ASC')
            ->get()->getResultArray();
    }
}
