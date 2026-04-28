<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: RecipeIngredientModel
 * Spravuje propojení receptů a ingrediencí (M:N relace)
 */
class RecipeIngredientModel extends Model
{
    protected $table         = 'recipe_ingredients';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'recipe_id',
        'ingredient_id',
        'amount',
        'notes',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Vrátí ingredience pro daný recept s detaily
     *
     * @param int $recipeId ID receptu
     * @return array Pole ingrediencí s množstvím a jednotkou
     */
    public function getForRecipe(int $recipeId): array
    {
        return $this->db->table('recipe_ingredients ri')
            ->select('ri.id, ri.amount, ri.notes, i.name as ingredient_name, i.unit')
            ->join('ingredients i', 'i.id = ri.ingredient_id')
            ->where('ri.recipe_id', $recipeId)
            ->where('ri.deleted_at IS NULL')
            ->get()
            ->getResultArray();
    }

    /**
     * Smaže všechny ingredience receptu a vloží nové (pro editaci)
     *
     * @param int   $recipeId    ID receptu
     * @param array $ingredients Pole ingrediencí [ingredient_id, amount, notes]
     * @return void
     */
    public function replaceForRecipe(int $recipeId, array $ingredients): void
    {
        $this->where('recipe_id', $recipeId)->delete();

        if (! empty($ingredients)) {
            $now  = date('Y-m-d H:i:s');
            $data = [];
            foreach ($ingredients as $ing) {
                $data[] = [
                    'recipe_id'     => $recipeId,
                    'ingredient_id' => $ing['ingredient_id'],
                    'amount'        => $ing['amount'] ?? null,
                    'notes'         => $ing['notes'] ?? null,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
            $this->db->table('recipe_ingredients')->insertBatch($data);
        }
    }
}
