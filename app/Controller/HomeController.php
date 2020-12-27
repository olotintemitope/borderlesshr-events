<?php

namespace Laztopaz\Controller;

use Laztopaz\Lib\BaseController;
use Laztopaz\Lib\Request;

class HomeController extends BaseController
{
    public function indexAction()
    {
        $this->render('index', [
            'name' => 'Olotin Temitope',
        ]);
    }
}