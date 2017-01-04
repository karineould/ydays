<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

require __DIR__.'/../config/dev.php';
require __DIR__.'/../app/app.php';
//require __DIR__.'/../app/routes.php';

$app->get('/', function() use ($app) {
    
    $users = $app['dao.user']->findAll();

    foreach ($users as $user){
        echo $user->getNom();
    }


    return 'test';
//    return $app['test'];
});



$app->run();