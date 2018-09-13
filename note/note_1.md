# Slim 3 Note1 0903


## Install：使用 composer安裝
    composer require slim/slim "^3.0"

## 目錄結構
    .
    ├── app/
    │   └── routes.php
    ├── bootstrap/
    │   └── app.php
    ├── public/             Web server files (DocumentRoot)
    │   └── .htaccess       Apache redirect rules for the front controller
    │   └── index.php       The front controller
    ├── resources/
    │   └── views
    │       └── home.twig
    ├── vendor/             Reserved for composer
    ├── composer.json       套件管理
    └──  .htaccess          Internal redirect to the public/ directory

## public/index.php
    require __DIR__ . '/../bootstrap/app.php';
    $app->run();

## bootstrap/app.php

    session_start();
    require __DIR__ . '/../vendor/autoload.php';
    $app = new \Slim\App([
        'settings' => [
            'displayErrorDetails' => true, //顯示錯誤
        ],
    ]);


## public/.htaccess：ClearURL

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^ index.php [QSA,L]

## ./.htaccess 引入public

    <IfModule mod_rewrite.c>
        RewriteEngine on
        RewriteRule ^$ public/     [L]
        RewriteRule (.*) public/$1 [L]
    </IfModule>

# twig-view

## install
    composer require slim/twig-view

## make a view ：
###/bootstrap/app.php
    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig(__DIR__ . '/../resources/views', [
            'cache' => false,
        ]);
        $view->addExtension(new Slim\Views\TwigExtension(
            $container->router,
            $container->request->getUri()
        ));
        return $view;
    };
### /resources/views/home.twig
    Hello world

### /app/routes.php
    $app->get('/home', function ($request, $response) {
        return $this->view->render($response, 'home.twig');
    });