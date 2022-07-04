<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class playlist_users extends Seeder
{
    public function run(){
        $data = [
            [
                "playlist_id" => 1,
                "usr_id" => 3,
            ],
            [
                "playlist_id" => 2,
                "usr_id" => 4,
            ],
            [
                "playlist_id" => 3,
                "usr_id" => 1,
            ],
        ];

        foreach($data as $item){
            $playlistid = $item['playlist_id'];
            $userid = $item['usr_id'];

            $this->db->query("INSERT INTO playlist_users (playlist_id, usr_id) VALUES ($playlistid, $userid)");
        }
    }
}