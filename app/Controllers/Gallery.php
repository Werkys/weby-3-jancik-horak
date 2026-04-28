<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\RecipeModel;
use App\Libraries\UploadHelper;
use App\Libraries\BreadcrumbHelper;

/**
 * Controller: Gallery
 * Spravuje galerii obrázků - zobrazení v kartách, přidávání a mazání
 * Tabulka images se zobrazuje jako karty s konfigurovatelným stránkováním
 */
class Gallery extends BaseController
{
    private ImageModel $imageModel;
    private RecipeModel $recipeModel;
    private UploadHelper $uploadHelper;
    private BreadcrumbHelper $breadcrumb;

    public function __construct()
    {
        $this->imageModel   = new ImageModel();
        $this->recipeModel  = new RecipeModel();
        $this->uploadHelper = new UploadHelper();
        $this->breadcrumb   = new BreadcrumbHelper();
    }

    /**
     * Zobrazí galerii obrázků v kartách se stránkováním
     * Počet obrázků na stránku je nastaven z konfiguračního souboru (RecipeConfig)
     *
     * @param int $page Číslo stránky (výchozí: 1)
     * @return string Vykreslená view galerie
     */
    public function index(int $page = 1): string
    {
        $config  = config('RecipeConfig');
        $perPage = $config->imagesPerPage ?? 12;
        $total   = $this->imageModel->countGallery();
        $offset  = ($page - 1) * $perPage;

        $images  = $this->imageModel->getGallery($perPage, $offset);

        $this->breadcrumb->add('Domů', base_url())->add('Galerie');

        return view('gallery/index', [
            'title'       => 'Galerie obrázků',
            'images'      => $images,
            'total'       => $total,
            'perPage'     => $perPage,
            'currentPage' => $page,
            'totalPages'  => (int) ceil($total / $perPage),
            'breadcrumb'  => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zobrazí formulář pro přidání obrázku
     * Přístupné pouze pro přihlášené uživatele
     *
     * @return string Vykreslená view formuláře
     */
    public function create(): string
    {
        $recipes = $this->recipeModel->findAll();
        $recipeDropdown = array_column($recipes, 'title', 'id');

        $this->breadcrumb
            ->add('Domů', base_url())
            ->add('Galerie', base_url('galerie'))
            ->add('Přidat obrázek');

        return view('gallery/create', [
            'title'      => 'Přidat obrázek',
            'recipes'    => $recipeDropdown,
            'breadcrumb' => $this->breadcrumb->render(),
        ]);
    }

    /**
     * Zpracuje odeslání formuláře pro přidání obrázku (POST)
     * Nahraje soubor a uloží záznam do DB
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        try {
            $filename = $this->uploadHelper->uploadImage($this->request, 'image');
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        if ($filename === null) {
            return redirect()->back()->withInput()->with('error', 'Soubor obrázku nebyl nahrán.');
        }

        $data = [
            'recipe_id' => $this->request->getPost('recipe_id') ?: null,
            'filename'  => $filename,
            'alt_text'  => $this->request->getPost('alt_text'),
        ];

        if (! $this->imageModel->insert($data)) {
            $this->uploadHelper->deleteImage($filename);
            return redirect()->back()->withInput()->with('error', 'Obrázek se nepodařilo uložit.');
        }

        return redirect()->to(base_url('galerie'))->with('success', 'Obrázek byl úspěšně přidán.');
    }

    /**
     * Provede soft delete obrázku (POST)
     * Uchovává záznam s nastaveným deleted_at
     *
     * @param int $id ID obrázku ke smazání
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $image = $this->imageModel->find($id);
        if ($image === null) {
            return redirect()->to(base_url('galerie'))->with('error', 'Obrázek nebyl nalezen.');
        }

        if (! $this->imageModel->delete($id)) {
            return redirect()->to(base_url('galerie'))->with('error', 'Obrázek se nepodařilo smazat.');
        }

        return redirect()->to(base_url('galerie'))->with('success', 'Obrázek byl úspěšně smazán.');
    }
}
