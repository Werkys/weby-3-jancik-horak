<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: ImageSeeder
 * Naplní tabulku images ukázkovými záznamy obrázků
 */
class ImageSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = $this->db->table('recipes')->limit(200)->get()->getResultArray();

        if (empty($recipes)) {
            echo "Run RecipeSeeder first!\n";
            return;
        }

        $batch = [];
        $now   = date('Y-m-d H:i:s');

        $sampleImages = [
            'placeholder_soup.jpg',
            'placeholder_meat.jpg',
            'placeholder_pasta.jpg',
            'placeholder_salad.jpg',
            'placeholder_dessert.jpg',
            'placeholder_bread.jpg',
            'placeholder_cake.jpg',
            'placeholder_drink.jpg',
            'placeholder_vegetable.jpg',
            'placeholder_fish.jpg',
        ];

        foreach ($recipes as $recipe) {
            $imgCount = rand(1, 3);
            for ($i = 0; $i < $imgCount; $i++) {
                $batch[] = [
                    'recipe_id'  => $recipe['id'],
                    'filename'   => $sampleImages[array_rand($sampleImages)],
                    'alt_text'   => 'Fotografie receptu: ' . $recipe['title'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            if (count($batch) >= 200) {
                $this->db->table('images')->insertBatch($batch);
                $batch = [];
            }
        }

        if (! empty($batch)) {
            $this->db->table('images')->insertBatch($batch);
        }
    }
}
