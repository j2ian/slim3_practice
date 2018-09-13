<?php

namespace App\Controllers;

use Slim\Views\Twig as View;

class HomeController extends Controller
{

    public function index($request, $response)
    {
        //var_dump($request->getParam('n'));
        return $this->view->render($response, 'home.twig');
    }
}
