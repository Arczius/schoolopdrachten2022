<?php

namespace App\Models;

use CodeIgniter\Model;

class Playlists extends Model
{
    protected $table = 'playlist';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['playlist_title'];
}