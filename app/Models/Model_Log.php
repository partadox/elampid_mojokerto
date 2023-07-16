<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Log extends Model
{
    protected $table      = 'tb_log';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user', 'status', 'activity', 'datetime'];
}
