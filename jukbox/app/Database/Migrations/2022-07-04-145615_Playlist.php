<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Playlist extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'playlist_title' => [
                'type' => 'VARCHAR',
                'constraint' => '96',
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('playlist');
    }

    public function down()
    {
        $this->forge->dropTable('playlist');
    }
}

