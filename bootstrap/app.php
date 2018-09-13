<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true, //顯示錯誤

    ],

]);

$app->get('/',function($request,$response){

    return 'Home';
});