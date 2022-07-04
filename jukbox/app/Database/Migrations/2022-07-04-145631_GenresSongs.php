<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class GenresSongs extends Migration
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

            'genre_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ],

            'song_id' => [
                'type' => 'INT',
                'constraint' => 5,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('genres_songs');
    }

    public function down()
    {
        $this->forge->dropTable('genres_songs');
    }
}
