<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: CategoryModel
 * Spravuje data kategorií receptů
 */
class CategoryModel extends Model
{
    protected $table         = 'categories';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'description',
        'slug',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'slug' => 'required|min_length[2]|max_length[120]|is_unique[categories.slug,id,{id}]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Název kategorie je povinný.',
        ],
        'slug' => [
            'required'  => 'Slug je povinný.',
            'is_unique' => 'Tento slug je již použitý.',
        ],
    ];

    /**
     * Vrátí všechny kategorie jako pole pro dropdown
     *
     * @return array Pole [id => name]
     */
    public function getDropdown(): array
    {
        return $this->findAll() ? array_column($this->findAll(), 'name', 'id') : [];
    }

    /**
     * Vrátí kategorie s počtem receptů (agregace)
     *
     * @return array Pole kategorií s počtem receptů
     */
    public function getWithRecipeCount(): array
    {
        return $this->db->table('categories c')
            ->select('c.id, c.name, c.slug, c.description, COUNT(r.id) as recipe_count')
            ->join('recipes r', 'r.category_id = c.id AND r.deleted_at IS NULL', 'left')
            ->where('c.deleted_at IS NULL')
            ->groupBy('c.id')
            ->orderBy('recipe_count', 'DESC')
            ->get()
            ->getResultArray();
    }
}
