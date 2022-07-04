<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class genres_songs extends Seeder
{
    public function run(){
        $data = [
            [
                "song_id" => 1,
                "genre_id" => 4,
            ],
            [
                "song_id" => 2,
                "genre_id" => 2,
            ],
            [
                "song_id" => 3,
                "genre_id" => 3,
            ],
            [
                "song_id" => 4,
                "genre_id" => 1,
            ],
            [
                "song_id" => 5,
                "genre_id" => 5,
            ],
            [
                "song_id" => 6,
                "genre_id" => 5,
            ],
            [
                "song_id" => 7,
                "genre_id" => 5,
            ],
            [
                "song_id" => 8,
                "genre_id" => 5,
            ],
            [
                "song_id" => 9,
                "genre_id" => 3,
            ],
            [
                "song_id" => 10,
                "genre_id" => 5,
            ],
            [
                "song_id" => 11,
                "genre_id" => 4,
            ]
        ];


        foreach($data as $item){
            $songid = $item['song_id'];
            $genreid = $item['genre_id'];
            $this->db->query("INSERT INTO genres_songs (genre_id,song_id) VALUES($genreid, $songid )");
        }
    }
}