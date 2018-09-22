<?php

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Models\User;
use Slim\Views\Twig as View;
use Respect\Validation\Validator as v;
use App\Validation\Rules\EmailAvailable;

class AuthController extends Controller
{
    public function getSignOut($request, $response)
    {
        $this->auth->logout();
        $this->flash->addMessage('info', '您已經登出');
        return $response->withRedirect($this->router->pathFor('home'));

    }
    public function getSignIn($request, $response)
    {
        return $this->view->render($response, 'auth/signin.twig');
    }
    public function postSignIn($request, $response)
    {
        $auth = $this->auth->attempt(
            $request->getParam('email'),
            $request->getParam('password')
        );

        if (!$auth) {
            $this->flash->addMessage('error', '登入失敗!帳號或密碼錯誤');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
        }
        $this->flash->addMessage('success', '您已登入');
        return $response->withRedirect($this->router->pathFor('home'));

    }

    public function getSignUp($request, $response)
    {
        return $this->view->render($response, 'auth/signup.twig');
    }
    public function postSignUp($request, $response)
    {
        //var_dump($request->getParam());
        $validation = $this->validator->validate($request, [
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(),
            'name' => v::notEmpty(),
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        if ($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }

        $user = User::create([
            'email' => $request->getParam('email'),
            'name' => $request->getParam('name'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT),
        ]);

        $this->flash->addMessage('success', '您已成功註冊並且登入');
        //註冊後自動登入
        $this->auth->attempt($user->email, $request->getParam('password'));

        return $response->withRedirect($this->router->pathFor('home'));

    }
}
