<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_User extends Model
{
    protected $table      = 'tb_user';
    protected $primaryKey = 'uid';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['nama', 'username', 'password', 'role', 'idcl'];

    //backend
    public function list()
    {
        return $this->table('tb_user')
            ->orderBy('uid', 'ASC')
            ->get()->getResultArray();
    }
}
