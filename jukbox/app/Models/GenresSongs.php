<?php

namespace App\Models;

use CodeIgniter\Model;

class GenresSongs extends Model
{
    protected $table = 'genres_songs';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowFields = ['genre_id', 'song_id'];
}