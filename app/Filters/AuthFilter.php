<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filter: AuthFilter
 * Kontroluje, zda je uživatel přihlášen. Nepřihlášeného přesměruje na login.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Spustí se před zpracováním požadavku
     * Pokud uživatel není přihlášen, přesměruje na login stránku
     *
     * @param RequestInterface $request  HTTP požadavek
     * @param array|null       $arguments Argumenty filtru
     * @return ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Pro tuto akci musíte být přihlášeni.');
        }
    }

    /**
     * Spustí se po zpracování požadavku
     *
     * @param RequestInterface  $request  HTTP požadavek
     * @param ResponseInterface $response HTTP odpověď
     * @param array|null        $arguments Argumenty filtru
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nic po zpracování
    }
}
