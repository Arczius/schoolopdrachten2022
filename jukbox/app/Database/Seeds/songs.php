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
                'length' => '2:02',
            ],
            [
                'songname' => 'DISCOTEK',
                'artistname' => 'Rooler',
                'length' => '4:27',
            ],
            [
                'songname' => 'Monster',
                'artistname' => 'Skillet',
                'length' => '3:07',
            ],
            [
                'songname' => 'Critter',
                'artistname' => 'Angerfist',
                'length' => '3:04',
            ],
            [
                'songname' => 'Devil Town',
                'artistname' => 'Cavetown',
                'length' => '3:00',
            ],
            [
                'songname' => 'Rät',
                'artistname' => 'Penelope Scott',
                'length' => '3:15',
            ],
            [
                'songname' => 'Art Is Dead',
                'artistname' => 'Bo Burnham',
                'length' => '2:33',
            ],
            [
                'songname' => 'Everywhere I Go',
                'artistname' => 'Hollywood Undead',
                'length' => '3:31',
            ],
            [
                'songname' => 'The Rumbling',
                'artistname' => 'SiM',
                'length' => '3:44',
            ],
            [
                'songname' => 'Im Yer Dad',
                'artistname' => 'GRLwood',
                'length' => '2:25',
            ],
            [
                'songname' => 'life waster',
                'artistname' => 'CORPSE',
                'length' => '2:23',
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