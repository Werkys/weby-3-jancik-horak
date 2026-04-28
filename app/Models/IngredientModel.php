<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: IngredientModel
 * Spravuje data ingrediencí
 */
class IngredientModel extends Model
{
    protected $table         = 'ingredients';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'unit',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[150]',
        'unit' => 'max_length[50]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Název ingredience je povinný.',
        ],
    ];

    /**
     * Vrátí ingredience jako pole pro dropdown / multiselect
     *
     * @return array Pole [id => name (unit)]
     */
    public function getDropdown(): array
    {
        $items  = $this->orderBy('name', 'ASC')->findAll();
        $result = [];
        foreach ($items as $item) {
            $result[$item['id']] = $item['name'] . ($item['unit'] ? ' (' . $item['unit'] . ')' : '');
        }
        return $result;
    }
}
