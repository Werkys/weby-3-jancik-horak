<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Create images table
 * Vytvoří tabulku obrázků přiřazených k receptům
 */
class CreateImagesTable extends Migration
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
            'recipe_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'alt_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->addForeignKey('recipe_id', 'recipes', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('images');
    }

    public function down(): void
    {
        $this->forge->dropTable('images');
    }
}
