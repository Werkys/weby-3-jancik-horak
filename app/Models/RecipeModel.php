<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: RecipeModel
 * Spravuje data receptů včetně joinů s kategoriemi a uživateli
 */
class RecipeModel extends Model
{
    protected $table         = 'recipes';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'title',
        'short_description',
        'description',
        'image_path',
        'user_id',
        'category_id',
        'prep_time_minutes',
        'servings',
        'published_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'title'       => 'required|min_length[3]|max_length[255]',
        'category_id' => 'required|is_not_unique[categories.id]',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Název receptu je povinný.',
        ],
        'category_id' => [
            'required'      => 'Kategorie je povinná.',
            'is_not_unique' => 'Vybraná kategorie neexistuje.',
        ],
    ];

    /**
     * Vrátí recepty s JOIN na kategorie a uživatele (stránkovaně)
     *
     * @param int $perPage Počet receptů na stránku
     * @param int|null $categoryId Filtr dle kategorie (volitelný)
     * @return array Pole receptů s daty z joinu
     */
    public function getWithDetails(int $perPage = 12, ?int $categoryId = null): array
    {
        $builder = $this->db->table('recipes r')
            ->select('r.*, c.name as category_name, c.slug as category_slug, u.username, u.full_name')
            ->join('categories c', 'c.id = r.category_id', 'left')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('r.deleted_at IS NULL');

        if ($categoryId !== null) {
            $builder->where('r.category_id', $categoryId);
        }

        return $builder->orderBy('r.created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Vrátí jeden recept s detaily (JOIN)
     *
     * @param int $id ID receptu
     * @return array|null Recept s detaily nebo null
     */
    public function getWithDetailsById(int $id): ?array
    {
        $result = $this->db->table('recipes r')
            ->select('r.*, c.name as category_name, c.slug as category_slug, u.username, u.full_name')
            ->join('categories c', 'c.id = r.category_id', 'left')
            ->join('users u', 'u.id = r.user_id', 'left')
            ->where('r.id', $id)
            ->where('r.deleted_at IS NULL')
            ->get()
            ->getRowArray();

        return $result ?: null;
    }

    /**
     * Vrátí statistiky receptů (agregace) - počty podle kategorie
     *
     * @return array Pole statistik
     */
    public function getStats(): array
    {
        return $this->db->table('recipes r')
            ->select('c.name as category_name, COUNT(r.id) as total, AVG(r.prep_time_minutes) as avg_prep_time')
            ->join('categories c', 'c.id = r.category_id', 'left')
            ->where('r.deleted_at IS NULL')
            ->groupBy('r.category_id')
            ->orderBy('total', 'DESC')
            ->get()
            ->getResultArray();
    }
}
