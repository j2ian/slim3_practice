<?php

use App\Middleware\AuthMiddleware;

$app->get('/', 'HomeController:index')->setName('home');

$app->group('', function () {
    //註冊
    $app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
    $app->post('/auth/signup', 'AuthController:postSignUp');
    //登入
    $app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
    $app->post('/auth/signin', 'AuthController:postSignIn');
})->add(new GuestMiddleware($container));


$app->group('', function () {
    //登出
    $this->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');
    //更改密碼
    $this->get('/auth/password/change', 'PasswordController:getChangePassword')->setName('auth.password.change');
    $this->post('/auth/password/change', 'PasswordController:postChangePassword');
})->add(new AuthMiddleware($container));
/*
$app->get('/home', function ($request, $response) {
return $this->view->render($response, 'home.twig');
});
 */
