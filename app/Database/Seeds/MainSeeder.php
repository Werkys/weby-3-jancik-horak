<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: MainSeeder
 * Hlavní seeder - spouští všechny seedery ve správném pořadí
 */
class MainSeeder extends Seeder
{
    public function run(): void
    {
        $this->call('UserSeeder');
        $this->call('CategorySeeder');
        $this->call('IngredientSeeder');
        $this->call('RecipeSeeder');
        $this->call('RecipeIngredientSeeder');
        $this->call('ImageSeeder');
    }
}
