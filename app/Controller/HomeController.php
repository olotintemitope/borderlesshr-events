<?php

namespace Laztopaz\Controller;

use Laztopaz\Models\User;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->render('index', [
            'name' => 'Olotin Temitope',
        ]);
    }

    public function loginAction()
    {
        $this->render('auth/login');
    }

    public function processLoginAction()
    {
        $this->render('auth/login');
    }
}