<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Libraries\AuthUser;
use CodeIgniter\Events\Events;
use App\Events\LoginEvent;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }
    public function auth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel = new UsuarioModel();
        $user = $userModel->where('username', $username)->first();
        // var_dump(password_hash($password,PASSWORD_BCRYPT));
        // var_dump( $user['contrasena']);exit;
        if ($user && password_verify($password,$user['contrasena'])) {
            // Guardar en Singleton
            $auth = AuthUser::getInstance();
            $auth->setUser($user);
            $observer = new \App\Observers\AuditObserver();
            $observer->onUserLoggedIn($user);
            session()->set('isLoggedIn', true);
            return redirect()->to('/dashboard');
        } else {
            return redirect()->back()->with('error', 'Credenciales incorrectas');
        }
    }

    public function logout()
    {
        $auth = AuthUser::getInstance();
        $user = $auth->getUser();
        $observer = new \App\Observers\AuditObserver();
        $observer->onUserLoggedIn($user,true);
        session()->destroy();
        return redirect()->to('/login');
    }
}
