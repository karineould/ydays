<?php
/**
 * Created by PhpStorm.
 * User: Karine
 * Date: 02/01/2017
 * Time: 22:34
 */

$phinxConf = [
    "paths" => [
        "migrations" =>  __DIR__ . "/db/migrations"
    ],
    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "development",
        "development" => [
            "adapter" => "mysql",
            "host" => "localhost",
            "name" => "ydays_dev_db",
            "user" => "root",
            "pass" => "root",
            "port" => 8889
        ]
    ]
];

return $phinxConf;

