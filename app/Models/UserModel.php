<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model: UserModel
 * Spravuje data uživatelů - přihlašování, CRUD operace
 */
class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'full_name',
        'role',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'role'     => 'required|in_list[admin,user]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Uživatelské jméno je povinné.',
            'is_unique'  => 'Toto uživatelské jméno je již obsazeno.',
        ],
        'email' => [
            'required'    => 'E-mail je povinný.',
            'valid_email' => 'Zadejte platný e-mail.',
            'is_unique'   => 'Tento e-mail je již registrován.',
        ],
    ];

    /**
     * Najde uživatele podle uživatelského jména
     *
     * @param string $username Uživatelské jméno
     * @return array|null Uživatel nebo null
     */
    public function findByUsername(string $username): ?array
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Najde uživatele podle e-mailu
     *
     * @param string $email E-mailová adresa
     * @return array|null Uživatel nebo null
     */
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }
}
