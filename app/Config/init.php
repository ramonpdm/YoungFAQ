<?php

date_default_timezone_set('America/Santo_Domingo');

define("APP_DIR", __DIR__ . '/../../');
define("APP_URL", 'http://localhost/YoungFAQ');

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "YoungFAQ");

// Manual Files Include
require 'app/Core/Functions.php';

// PSR-4 Composer Auto Class Loader
require 'app/vendor/autoload.php';
