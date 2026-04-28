<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: CategorySeeder
 * Naplní tabulku kategorií receptů
 */
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Polévky', 'description' => 'Různé druhy polévek a vývarů', 'slug' => 'polevky'],
            ['name' => 'Předkrmy', 'description' => 'Lehká jídla před hlavním chodem', 'slug' => 'predkrmy'],
            ['name' => 'Hlavní chody', 'description' => 'Vydatná hlavní jídla', 'slug' => 'hlavni-chody'],
            ['name' => 'Přílohy', 'description' => 'Přílohy k hlavním chodům', 'slug' => 'prilohy'],
            ['name' => 'Dezerty', 'description' => 'Sladká jídla a moučníky', 'slug' => 'dezerty'],
            ['name' => 'Nápoje', 'description' => 'Horké i studené nápoje', 'slug' => 'napoje'],
            ['name' => 'Snídaně', 'description' => 'Jídla na snídani', 'slug' => 'snidane'],
            ['name' => 'Vegetariánské', 'description' => 'Bezmasá jídla', 'slug' => 'vegetarianske'],
            ['name' => 'Veganské', 'description' => 'Jídla bez živočišných produktů', 'slug' => 'veganske'],
            ['name' => 'Bezlepkové', 'description' => 'Jídla bez lepku', 'slug' => 'bezlepkove'],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($categories as &$cat) {
            $cat['created_at'] = $now;
            $cat['updated_at'] = $now;
        }

        $this->db->table('categories')->insertBatch($categories);
    }
}
