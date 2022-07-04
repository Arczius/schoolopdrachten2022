<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class genres extends Seeder
{
    public function run()
    {
        $data = [
            'hardcore', 
            'uptempo', 
            'metal', 
            'rap', 
            'indie'
        ];

        foreach($data as $item){
            $this->db->query("INSERT INTO genres (name) VALUES ('$item')");
        }
    }
}