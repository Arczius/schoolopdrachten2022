<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Songs extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'songName' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],
            'songLength' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ],
            'artistName' => [
                'type' => 'VARCHAR',
                'constraint' => '64',
            ],

        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('songs');
    }

    public function down()
    {
        $this->forge->dropTable('songs');        
    }
}
