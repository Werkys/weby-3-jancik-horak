<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Libraries\SlugHelper;
use App\Libraries\BreadcrumbHelper;

/**
 * Controller: Category
 * Spravuje kategorie receptů - CRUD operace
 */
class Category extends BaseController
{
    private CategoryModel $categoryModel;
    private SlugHelper $slugHelper;
    private BreadcrumbHelper $breadcrumb;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->slugHelper    = new SlugHelper();
        $this->breadcrumb    = new BreadcrumbHelper();
    }

    /**
     * Zobrazí seznam kategorií s počty receptů (využívá agregaci)
     *
     * @return string Vykreslená view seznamu kategorií
     */
    public function index(): string
    {
        $this->breadcrumb->add('Domů', base_url())->add('Kategorie');

        return view('category/index', [
            'title'      => 'Kategorie',
            'categories' => $this->categoryModel->getWithRecipeCount(),
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zobrazí formulář pro přidání nové kategorie
     *
     * @return string Vykreslená view formuláře
     */
    public function create(): string
    {
        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Kategorie', base_url('kategorie'))
            ->add('Nová kategorie');

        return view('category/create', [
            'title'      => 'Nová kategorie',
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zpracuje odeslání formuláře pro přidání kategorie (POST)
     * Automaticky generuje slug z názvu
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $slug = $this->slugHelper->makeUnique(
            $this->slugHelper->generate($name),
            'categories'
        );

        $data = [
            'name'        => $name,
            'description' => $this->request->getPost('description'),
            'slug'        => $slug,
        ];

        if (! $this->categoryModel->insert($data)) {
            return redirect()->back()->withInput()->with('error', 'Kategorii se nepodařilo uložit.');
        }

        return redirect()->to(base_url('kategorie'))->with('success', 'Kategorie byla úspěšně přidána.');
    }

    /**
     * Zobrazí formulář pro editaci kategorie
     *
     * @param int $id ID kategorie
     * @return string|\CodeIgniter\HTTP\RedirectResponse
     */
    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $category = $this->categoryModel->find($id);
        if ($category === null) {
            return redirect()->to(base_url('kategorie'))->with('error', 'Kategorie nebyla nalezena.');
        }

        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Kategorie', base_url('kategorie'))
            ->add('Editace: ' . $category['name']);

        return view('category/edit', [
            'title'      => 'Editace kategorie',
            'category'   => $category,
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zpracuje odeslání editačního formuláře kategorie (POST)
     *
     * @param int $id ID kategorie k aktualizaci
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $category = $this->categoryModel->find($id);
        if ($category === null) {
            return redirect()->to(base_url('kategorie'))->with('error', 'Kategorie nebyla nalezena.');
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $slug = $this->slugHelper->makeUnique(
            $this->slugHelper->generate($name),
            'categories',
            'slug',
            $id
        );

        $data = [
            'name'        => $name,
            'description' => $this->request->getPost('description'),
            'slug'        => $slug,
        ];

        if (! $this->categoryModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', 'Kategorii se nepodařilo aktualizovat.');
        }

        return redirect()->to(base_url('kategorie'))->with('success', 'Kategorie byla úspěšně aktualizována.');
    }

    /**
     * Provede soft delete kategorie (POST)
     *
     * @param int $id ID kategorie ke smazání
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->categoryModel->delete($id)) {
            return redirect()->to(base_url('kategorie'))->with('error', 'Kategorii se nepodařilo smazat.');
        }

        return redirect()->to(base_url('kategorie'))->with('success', 'Kategorie byla úspěšně smazána.');
    }
}
