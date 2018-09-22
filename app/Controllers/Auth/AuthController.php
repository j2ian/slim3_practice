<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;
use App\Validation\Rules\EmailAvailable;

class AuthController extends Controller
{
    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }
    public function postSignUp($request, $response)
    {
        //var_dump($request->getParam());
        $validation = $this->validator->validate($request, [
            'email'    => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'name'     => v::notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
		}
        
        $user = User::create([
            'email'    => $request->getParam('email'),
            'name'     => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
            ]);
            
            return $response->withRedirect($this->router->pathFor('home'));
            
    }
}
