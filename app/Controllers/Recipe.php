<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\CategoryModel;
use App\Models\RecipeIngredientModel;
use App\Libraries\UploadHelper;
use App\Libraries\BreadcrumbHelper;

/**
 * Controller: Recipe
 * Spravuje recepty - zobrazení, přidávání, editace a mazání (CRUD)
 * Přidávání, editace a mazání pouze pro přihlášené uživatele (chráněno AuthFilterem)
 */
class Recipe extends BaseController
{
    private RecipeModel $recipeModel;
    private CategoryModel $categoryModel;
    private RecipeIngredientModel $ingredientModel;
    private UploadHelper $uploadHelper;
    private BreadcrumbHelper $breadcrumb;

    public function __construct()
    {
        $this->recipeModel     = new RecipeModel();
        $this->categoryModel   = new CategoryModel();
        $this->ingredientModel = new RecipeIngredientModel();
        $this->uploadHelper    = new UploadHelper();
        $this->breadcrumb      = new BreadcrumbHelper();
    }

    /**
     * Zobrazí seznam receptů s volitelným filtrem kategorie a autora
     * Využívá JOIN s tabulkou kategorií a uživatelů
     * Routa s dvěma parametry: /recepty/kategorie/{categoryId}/autor/{userId}
     *
     * @param int|null $categoryId Filtr podle kategorie (volitelný parametr)
     * @param int|null $userId     Filtr podle autora (volitelný parametr)
     * @return string Vykreslená view seznamu receptů
     */
    public function index(?int $categoryId = null, ?int $userId = null): string
    {
        $recipes    = $this->recipeModel->getWithDetails(12, $categoryId);
        $categories = $this->categoryModel->findAll();

        $this->breadcrumb->add('Domů', base_url())->add('Recepty');

        return view('recipe/index', [
            'title'      => 'Recepty',
            'recipes'    => $recipes,
            'categories' => $categories,
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zobrazí detail jednoho receptu s ingrediencemi
     * Využívá JOIN pro data kategorie a autora
     *
     * @param int $id ID receptu
     * @return string|\CodeIgniter\HTTP\RedirectResponse Vykreslená view nebo přesměrování
     */
    public function show(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $recipe = $this->recipeModel->getWithDetailsById($id);

        if ($recipe === null) {
            return redirect()->to(base_url('recepty'))->with('error', 'Recept nebyl nalezen.');
        }

        $ingredients = $this->ingredientModel->getForRecipe($id);

        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Recepty', base_url('recepty'))
            ->add($recipe['title']);

        return view('recipe/show', [
            'title'       => $recipe['title'],
            'recipe'      => $recipe,
            'ingredients' => $ingredients,
            'breadcrumb'  => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zobrazí formulář pro přidání nového receptu
     * Přístupné pouze pro přihlášené uživatele
     *
     * @return string Vykreslená view formuláře
     */
    public function create(): string
    {
        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Recepty', base_url('recepty'))
            ->add('Nový recept');

        return view('recipe/create', [
            'title'      => 'Nový recept',
            'categories' => $this->categoryModel->getDropdown(),
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zpracuje odeslání formuláře pro přidání receptu (POST)
     * Nahraje obrázek, validuje data, uloží recept do DB
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Přesměrování po úspěchu/neúspěchu
     */
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required',
            'description' => 'permit_empty',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imagePath = null;
        try {
            $imagePath = $this->uploadHelper->uploadImage($this->request, 'image');
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'title'             => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'category_id'       => $this->request->getPost('category_id'),
            'prep_time_minutes' => $this->request->getPost('prep_time_minutes') ?: null,
            'servings'          => $this->request->getPost('servings') ?: null,
            'user_id'           => session()->get('user_id'),
            'image_path'        => $imagePath,
            'published_at'      => date('Y-m-d H:i:s'),
        ];

        if (! $this->recipeModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Recept se nepodařilo uložit.');
        }

        return redirect()->to(base_url('recepty'))->with('success', 'Recept byl úspěšně přidán.');
    }

    /**
     * Zobrazí formulář pro editaci existujícího receptu
     * Přístupné pouze pro přihlášené uživatele
     *
     * @param int $id ID receptu k editaci
     * @return string|\CodeIgniter\HTTP\RedirectResponse Vykreslená view nebo přesměrování
     */
    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $recipe = $this->recipeModel->find($id);

        if ($recipe === null) {
            return redirect()->to(base_url('recepty'))->with('error', 'Recept nebyl nalezen.');
        }

        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Recepty', base_url('recepty'))
            ->add('Editace: ' . $recipe['title']);

        return view('recipe/edit', [
            'title'      => 'Editace receptu',
            'recipe'     => $recipe,
            'categories' => $this->categoryModel->getDropdown(),
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zpracuje odeslání editačního formuláře receptu (POST)
     * Validuje data, nahradí obrázek pokud byl nahrán nový
     *
     * @param int $id ID receptu k aktualizaci
     * @return \CodeIgniter\HTTP\RedirectResponse Přesměrování po úspěchu/neúspěchu
     */
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $recipe = $this->recipeModel->find($id);
        if ($recipe === null) {
            return redirect()->to(base_url('recepty'))->with('error', 'Recept nebyl nalezen.');
        }

        $rules = [
            'title'       => 'required|min_length[3]|max_length[255]',
            'category_id' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imagePath = $recipe['image_path'];
        try {
            $newImage = $this->uploadHelper->uploadImage($this->request, 'image');
            if ($newImage !== null) {
                if ($imagePath) {
                    $this->uploadHelper->deleteImage($imagePath);
                }
                $imagePath = $newImage;
            }
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'title'             => $this->request->getPost('title'),
            'short_description' => $this->request->getPost('short_description'),
            'description'       => $this->request->getPost('description'),
            'category_id'       => $this->request->getPost('category_id'),
            'prep_time_minutes' => $this->request->getPost('prep_time_minutes') ?: null,
            'servings'          => $this->request->getPost('servings') ?: null,
            'image_path'        => $imagePath,
        ];

        if (! $this->recipeModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Recept se nepodařilo aktualizovat.');
        }

        return redirect()->to(base_url('recepty/' . $id))->with('success', 'Recept byl úspěšně aktualizován.');
    }

    /**
     * Provede soft delete receptu (POST)
     * Uchovává záznam v DB s nastaveným deleted_at
     * Přístupné pouze pro přihlášené uživatele
     *
     * @param int $id ID receptu ke smazání
     * @return \CodeIgniter\HTTP\RedirectResponse Přesměrování po operaci
     */
    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $recipe = $this->recipeModel->find($id);
        if ($recipe === null) {
            return redirect()->to(base_url('recepty'))->with('error', 'Recept nebyl nalezen.');
        }

        if (! $this->recipeModel->delete($id)) {
            return redirect()->to(base_url('recepty'))->with('error', 'Recept se nepodařilo smazat.');
        }

        return redirect()->to(base_url('recepty'))->with('success', 'Recept byl úspěšně smazán.');
    }
}
