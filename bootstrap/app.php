<?php

use Respect\Validation\Validator as v;


session_start();
require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, //顯示錯誤
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'slim3',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]
    ],
]);

$container = $app->getContainer();

//資料庫實作
$capsule = new Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

//註冊資料庫
$container['db'] = function ($container) use ($capsule) {
    return $capsule;
};
//註冊Auth
$container['auth'] = function ($container) {
    return new \App\Auth\Auth;
};
//flash message
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};
//註冊view
$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
        'cache' => false,
    ]);
    $view->addExtension(new Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->auth->check(),
        'user' => $container->auth->user(),
    ]);

    $view->getEnvironment()->addGlobal('flash', $container->flash);
    return $view;
};
//資料驗證
$container['validator'] = function ($container) {
    return new App\Validation\Validator;
};
//csrf驗證
$container['csrf'] = function ($container) {
    return new \Slim\Csrf\Guard;
};


/**
 * Controller
 */

$container['HomeController'] = function ($container) {
    return new \App\Controllers\HomeController($container);
};
$container['AuthController'] = function ($container) {
    return new \App\Controllers\Auth\AuthController($container);
};
$container['PasswordController'] = function ($container) {
    return new \App\Controllers\Auth\PasswordController($container);
};
/*
 *   Middleware
 */
$app->add(new \App\Middleware\ValidationErrorsMiddleware($container));
$app->add(new \App\Middleware\OldInputMiddleware($container));
$app->add(new \App\Middleware\CsrfViewMiddleware($container));

//csrf check
$app->add($container->csrf);

v::with('App\\Validation\\Rules\\');


require __DIR__ . '/../app/routes.php';
