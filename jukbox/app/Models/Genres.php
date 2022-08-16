<?php

namespace App\Models;

use CodeIgniter\Model;

class Genres extends Model
{
    protected $table = 'genres';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowFields = ['id', 'name'];
}