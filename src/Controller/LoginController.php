<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class LoginController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $this->request->allowMethod(['get', 'post']);

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            return $this->redirect($this->Authentication->getLoginRedirect() ?? '/');
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error('Email ou mot de passe incorrect.');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['action' => 'index']);
    }
    
}
