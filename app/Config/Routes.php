<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// -------------------------
// Veřejné routy
// -------------------------
$routes->get('/', 'Home::index');

// Auth routy
$routes->get('auth/prihlasit', 'Auth::login');
$routes->post('auth/prihlasit', 'Auth::loginPost');
$routes->get('auth/odhlasit', 'Auth::logout');

// Recepty - zobrazení (veřejné)
$routes->get('recepty', 'Recipe::index');
$routes->get('recepty/(:num)', 'Recipe::show/$1');

// Recepty se dvěma parametry (kategorie + autor) - splňuje požadavek na routu se 2 parametry
$routes->get('recepty/kategorie/(:num)/autor/(:num)', 'Recipe::index/$1/$2');

// Galerie - zobrazení (veřejná)
$routes->get('galerie', 'Gallery::index');
$routes->get('galerie/strana/(:num)', 'Gallery::index/$1');

// Kategorie - zobrazení (veřejné)
$routes->get('kategorie', 'Category::index');

// -------------------------
// Chráněné routy (vyžadují přihlášení - AuthFilter)
// -------------------------
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // Recepty - CRUD
    $routes->get('recepty/novy', 'Recipe::create');
    $routes->post('recepty', 'Recipe::store');
    $routes->get('recepty/(:num)/upravit', 'Recipe::edit/$1');
    $routes->post('recepty/(:num)', 'Recipe::update/$1');
    $routes->post('recepty/(:num)/smazat', 'Recipe::delete/$1');

    // Kategorie - CRUD
    $routes->get('kategorie/nova', 'Category::create');
    $routes->post('kategorie', 'Category::store');
    $routes->get('kategorie/(:num)/upravit', 'Category::edit/$1');
    $routes->post('kategorie/(:num)', 'Category::update/$1');
    $routes->post('kategorie/(:num)/smazat', 'Category::delete/$1');

    // Galerie - přidávání a mazání
    $routes->get('galerie/pridat', 'Gallery::create');
    $routes->post('galerie', 'Gallery::store');
    $routes->post('galerie/(:num)/smazat', 'Gallery::delete/$1');
});
