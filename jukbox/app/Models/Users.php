<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $returnType = 'array';
    protected $allowedFields = ['username', 'password'];
}