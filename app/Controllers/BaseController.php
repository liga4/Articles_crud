<?php

namespace App\Controllers;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Dotenv;

abstract class BaseController
{
    protected Connection $database;
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $connectionParams = [
            'dbname' => 'articles',
            'user' => 'root',
            'password' => $_ENV['mysql_password'],
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $this->database = DriverManager::getConnection($connectionParams);
    }
}