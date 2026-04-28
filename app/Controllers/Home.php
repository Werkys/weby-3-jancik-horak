<?php

namespace App\Controllers;

use App\Models\RecipeModel;
use App\Models\CategoryModel;

/**
 * Controller: Home
 * Domovská stránka aplikace - přehled nejnovějších receptů a statistiky
 */
class Home extends BaseController
{
    /**
     * Zobrazí domovskou stránku s nejnovějšími recepty a statistikami kategorií
     *
     * @return string Vykreslená view domovské stránky
     */
    public function index(): string
    {
        $recipeModel   = new RecipeModel();
        $categoryModel = new CategoryModel();

        $data = [
            'title'           => 'Receptář - Domů',
            'recentRecipes'   => array_slice($recipeModel->getWithDetails(), 0, 6),
            'categoriesStats' => $categoryModel->getWithRecipeCount(),
        ];

        return view('home/index', $data);
    }
}
