<?php
/**
 * Created by PhpStorm.
 * User: Karine
 * Date: 02/01/2017
 * Time: 22:32
 */
// enable the debug mode
$app['debug'] = true;

$CONF['bdd_hote']  = 'localhost';
$CONF['bdd']       = 'ydays_dev_db';
$CONF['bdd_login'] = 'root';
$CONF['bdd_pass']  = 'root';
$CONF['bdd_port']  = 8889;

// Doctrine (db)
$app['db.options'] = array(
    'driver'   => 'pdo_mysql',
    'dbname'   => $CONF['bdd'],
    'host'     => $CONF['bdd_hote'],
    'user'     => $CONF['bdd_login'],
    'password' => $CONF['bdd_pass'],
    'port'     => $CONF['bdd_port'],
    'charset'  => "utf8"
);
