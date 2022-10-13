<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class songs extends Seeder
{
    public function run(){
        $data = [
            [
                'songname' => 'Paracetamol',
                'artistname' => 'Appelkaas',
                'length' => '02:02',
            ],
            [
                'songname' => 'DISCOTEK',
                'artistname' => 'Rooler',
                'length' => '04:27',
            ],
            [
                'songname' => 'Monster',
                'artistname' => 'Skillet',
                'length' => '03:07',
            ],
            [
                'songname' => 'Critter',
                'artistname' => 'Angerfist',
                'length' => '03:04',
            ],
            [
                'songname' => 'Devil Town',
                'artistname' => 'Cavetown',
                'length' => '03:00',
            ],
            [
                'songname' => 'Rät',
                'artistname' => 'Penelope Scott',
                'length' => '03:15',
            ],
            [
                'songname' => 'Art Is Dead',
                'artistname' => 'Bo Burnham',
                'length' => '02:33',
            ],
            [
                'songname' => 'Everywhere I Go',
                'artistname' => 'Hollywood Undead',
                'length' => '03:31',
            ],
            [
                'songname' => 'The Rumbling',
                'artistname' => 'SiM',
                'length' => '03:44',
            ],
            [
                'songname' => 'Im Yer Dad',
                'artistname' => 'GRLwood',
                'length' => '02:25',
            ],
            [
                'songname' => 'life waster',
                'artistname' => 'CORPSE',
                'length' => '02:23',
            ]
        ];

        foreach($data as $item){
            $songname = $item['songname'];
            $artistname = $item['artistname'];
            $length = $item['length'];
            $this->db->query("INSERT INTO songs (songName,artistName, songLength) VALUES('$songname', '$artistname', '$length')");
        }

    }
}