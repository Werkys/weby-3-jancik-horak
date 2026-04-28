<?php

namespace App\Controllers;

use App\Models\UserModel;

/**
 * Controller: Auth
 * Spravuje autentizaci uživatelů - přihlášení a odhlášení
 */
class Auth extends BaseController
{
    /**
     * Zobrazí přihlašovací formulář
     *
     * @return string Vykreslená view přihlašovacího formuláře
     */
    public function login(): string
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login', [
            'title' => 'Přihlášení',
        ]);
    }

    /**
     * Zpracuje přihlašovací formulář (POST)
     * Ověří přihlašovací údaje a nastaví session
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function loginPost(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->findByUsername($this->request->getPost('username'));

        if ($user === null || ! password_verify($this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Nesprávné přihlašovací údaje.');
        }

        $sessionData = [
            'user_id'    => $user['id'],
            'username'   => $user['username'],
            'full_name'  => $user['full_name'],
            'role'       => $user['role'],
            'logged_in'  => true,
        ];

        session()->set($sessionData);

        return redirect()->to(base_url())->with('success', 'Přihlášení proběhlo úspěšně. Vítejte, ' . $user['full_name'] . '!');
    }

    /**
     * Odhlásí uživatele - vymaže session a přesměruje na login
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'))->with('success', 'Byli jste úspěšně odhlášeni.');
    }
}
