<?php

$app->get('/', 'HomeController:index')->setName('home');

//註冊
$app->get('/auth/signup', 'AuthController:getSignUp')->setName('auth.signup');
$app->post('/auth/signup', 'AuthController:postSignUp');
//登入
$app->get('/auth/signin', 'AuthController:getSignIn')->setName('auth.signin');
$app->post('/auth/signin', 'AuthController:postSignIn');

//登出
$app->get('/auth/signout', 'AuthController:getSignOut')->setName('auth.signout');

/*
$app->get('/home', function ($request, $response) {
return $this->view->render($response, 'home.twig');
});
 */
