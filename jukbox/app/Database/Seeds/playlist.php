<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class playlist extends Seeder
{
    public function run()
    {
        $data = [
            "i want that headache",
            "my mood today is violence",
            "bread is a god",
        ];

        foreach($data as $item){
            $this->db->query("INSERT INTO playlist (playlist_title) VALUES ('$item')");
        }
    }
}