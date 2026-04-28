<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder: RecipeIngredientSeeder
 * Naplní tabulku recipe_ingredients (M:N) propojením receptů s ingrediencemi
 */
class RecipeIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $recipes     = $this->db->table('recipes')->get()->getResultArray();
        $ingredients = $this->db->table('ingredients')->get()->getResultArray();

        if (empty($recipes) || empty($ingredients)) {
            echo "Run RecipeSeeder and IngredientSeeder first!\n";
            return;
        }

        $batch = [];
        $now   = date('Y-m-d H:i:s');

        foreach ($recipes as $recipe) {
            $count = rand(4, 12);
            $ingredientSubset = (array) array_rand(array_column($ingredients, 'id', 'id'), min($count, count($ingredients)));

            foreach ($ingredientSubset as $ingKey) {
                $ingredient = $ingredients[$ingKey] ?? $ingredients[0];
                $batch[] = [
                    'recipe_id'     => $recipe['id'],
                    'ingredient_id' => $ingredient['id'],
                    'amount'        => round(rand(10, 500) / 10, 1),
                    'notes'         => rand(0, 1) ? null : 'dle chuti',
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];

                if (count($batch) >= 200) {
                    $this->db->table('recipe_ingredients')->insertBatch($batch);
                    $batch = [];
                }
            }
        }

        if (! empty($batch)) {
            $this->db->table('recipe_ingredients')->insertBatch($batch);
        }
    }
}
