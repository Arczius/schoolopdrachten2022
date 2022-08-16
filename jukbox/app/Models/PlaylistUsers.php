<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaylistUsers extends Model
{
    protected $table = 'playlist_users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['playlist_id', 'usr_id'];
}