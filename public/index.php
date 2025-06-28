<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Core\Session;

//session
Session::init();

//config
$config = require_once __DIR__ . '/../config/app.php';
//set db
Database::getInstance($config['database']);

//router
$router = new Router();
require_once __DIR__ . '/../routes/router.php';
$router->dispatch();
