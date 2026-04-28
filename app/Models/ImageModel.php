<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: ImageModel
 * Spravuje obrázky přiřazené k receptům
 */
class ImageModel extends Model
{
    protected $table         = 'images';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'recipe_id',
        'filename',
        'alt_text',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'filename' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'filename' => [
            'required' => 'Soubor obrázku je povinný.',
        ],
    ];

    /**
     * Vrátí obrázky pro daný recept
     *
     * @param int $recipeId ID receptu
     * @return array Pole obrázků
     */
    public function getForRecipe(int $recipeId): array
    {
        return $this->where('recipe_id', $recipeId)->findAll();
    }

    /**
     * Vrátí obrázky s názvem receptu (JOIN) pro galerii
     *
     * @param int $perPage Počet na stránku
     * @param int $offset  Offset pro stránkování
     * @return array Pole obrázků s daty receptu
     */
    public function getGallery(int $perPage = 12, int $offset = 0): array
    {
        return $this->db->table('images i')
            ->select('i.*, r.title as recipe_title')
            ->join('recipes r', 'r.id = i.recipe_id', 'left')
            ->where('i.deleted_at IS NULL')
            ->orderBy('i.created_at', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();
    }

    /**
     * Vrátí celkový počet obrázků (pro stránkování)
     *
     * @return int Celkový počet
     */
    public function countGallery(): int
    {
        return (int) $this->db->table('images')
            ->where('deleted_at IS NULL')
            ->countAllResults();
    }
}
