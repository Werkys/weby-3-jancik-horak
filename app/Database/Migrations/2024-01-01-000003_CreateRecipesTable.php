<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Create recipes table
 * Vytvoří hlavní tabulku receptů s dlouhým textem, datem a obrázkem
 */
class CreateRecipesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'short_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'description' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'image_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'     => true,
            ],
            'category_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null'     => true,
            ],
            'prep_time_minutes' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],
            'servings' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'null'       => true,
            ],
            'published_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('recipes');
    }

    public function down(): void
    {
        $this->forge->dropTable('recipes');
    }
}
