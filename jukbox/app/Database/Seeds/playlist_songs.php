<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class playlist_songs extends Seeder
{
    public function run()
    {
        $data = [
            //playlist 1
            [
                "playlist_id" => 1,
                "song_id" => 2,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 4,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 3,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 11,
            ],

            //playlist 2
            [
                "playlist_id" => 2,
                "song_id" => 3,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 1,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 6,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 7,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 11,
            ],

            //playlist 3
            [
                "playlist_id" => 3,
                "song_id" => 1,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 5,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 6,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 2,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 9,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 11,
            ],
        ];

        foreach($data as $item){
            $playlistid = $item['playlist_id'];
            $songid = $item['song_id'];

            $this->db->query("INSERT INTO playlist_songs (playlist_id, song_id) VALUES ($playlistid, $songid)");
        }

    }
}