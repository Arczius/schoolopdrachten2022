<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'jar',
                'password' => 'bottle',
            ],
            [
                'username' => 'stijn',
                'password' => 'kaas',
            ],
            [
                'username' => 'Reg1',
                'password' => 'urDad',
            ],
            [
                'username' => 'Stefano',
                'password' => 'kattenspelletjes',
            ]
        ];

        foreach($data as $item){
            $username = $item['username'];
            $password = $item['password'];
            $this->db->query("INSERT INTO users (username,password) VALUES('$username', '$password')");
        }
    }
}