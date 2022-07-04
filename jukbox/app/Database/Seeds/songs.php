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
            ],
            [
                'songname' => 'DISCOTEK',
                'artistname' => 'Rooler',
            ],
            [
                'songname' => 'Monster',
                'artistname' => 'Skillet',
            ],
            [
                'songname' => 'Critter',
                'artistname' => 'Angerfist'
            ],
            [
                'songname' => 'Devil Town',
                'artistname' => 'Cavetown',
            ],
            [
                'songname' => 'Rät',
                'artistname' => 'Penelope Scott',
            ],
            [
                'songname' => 'Art Is Dead',
                'artistname' => 'Bo Burnham',
            ],
            [
                'songname' => 'Everywhere I Go',
                'artistname' => 'Hollywood Undead',
            ],
            [
                'songname' => 'The Rumbling',
                'artistname' => 'SiM',
            ],
            [
                'songname' => 'Im Yer Dad',
                'artistname' => 'GRLwood',
            ],
            [
                'songname' => 'life waster',
                'artistname' => 'CORPSE'
            ]
        ];

        foreach($data as $item){
            $songname = $item['songname'];
            $artistname = $item['artistname'];
            $this->db->query("INSERT INTO songs (songName,artistName) VALUES('$songname', '$artistname')");
        }

    }
}