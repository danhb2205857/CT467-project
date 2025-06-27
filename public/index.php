<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Core\Database;
use App\Core\Session;

// Start session at the beginning
Session::init();

// Load configuration
$config = require_once __DIR__ . '/../config/app.php';

// Initialize database
Database::getInstance($config['database']);

// Initialize router
$router = new Router();

// Define routes
require_once __DIR__ . '/../routes/router.php';

// Handle request
$router->dispatch();
