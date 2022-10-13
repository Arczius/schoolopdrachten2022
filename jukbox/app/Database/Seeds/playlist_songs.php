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
                "order" => 1,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 4,
                "order" => 2,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 3,
                "order" => 3,
            ],
            [
                "playlist_id" => 1,
                "song_id" => 11,
                "order" => 4,
            ],

            //playlist 2
            [
                "playlist_id" => 2,
                "song_id" => 3,
                "order" => 1,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 1,
                "order" => 2,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 6,
                "order" => 3,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 7,
                "order" => 4,
            ],
            [
                "playlist_id" => 2,
                "song_id" => 11,
                "order" => 5,
            ],

            //playlist 3
            [
                "playlist_id" => 3,
                "song_id" => 1,
                "order" => 1,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 5,
                "order" => 2,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 6,
                "order" => 3,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 2,
                "order" => 4,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 9,
                "order" => 5,
            ],
            [
                "playlist_id" => 3,
                "song_id" => 11,
                "order" => 6,
            ],
        ];

        foreach($data as $item){
            $playlistid = $item['playlist_id'];
            $songid = $item['song_id'];
            $order = $item['order'];

            $this->db->query("INSERT INTO playlist_songs (playlist_id, song_id, playlist_order) VALUES ($playlistid, $songid, $order)");
        }

    }
}