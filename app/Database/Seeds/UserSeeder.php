<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: UserSeeder
 * Vytvoří testovací uživatele pro systém
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'username'      => 'admin',
                'email'         => 'admin@recepty.cz',
                'password_hash' => password_hash('Admin123!', PASSWORD_BCRYPT),
                'full_name'     => 'Administrátor',
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'jancik',
                'email'         => 'jancik@recepty.cz',
                'password_hash' => password_hash('Jancik123!', PASSWORD_BCRYPT),
                'full_name'     => 'Jan Jančík',
                'role'          => 'user',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'horak',
                'email'         => 'horak@recepty.cz',
                'password_hash' => password_hash('Horak123!', PASSWORD_BCRYPT),
                'full_name'     => 'Pavel Horák',
                'role'          => 'user',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
