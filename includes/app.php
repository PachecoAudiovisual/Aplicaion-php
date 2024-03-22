<?php

use Dotenv\Dotenv;
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'database.php';

require __DIR__ . '/../models/ActiveRecord.php';


// Conectarnos a la base de datos

ActiveRecord::setDB($db);