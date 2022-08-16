<?php

namespace App\Models;

use CodeIgniter\Model;

class Songs extends Model
{
    protected $table = 'songs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowFields = ['id','songName', 'songLength', 'artistName'];
}