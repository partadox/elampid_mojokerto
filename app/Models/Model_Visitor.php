<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Visitor extends Model
{
    protected $table      = 'tb_visitor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ip', 'datetime'];
}
