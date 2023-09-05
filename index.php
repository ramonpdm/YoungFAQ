<?php

/**
 * YoungFAQ - 2021
 *  
 * @author Ramón Perdomo <inoelperdomo@gmail.com> */

namespace App;

use App\Controllers\App;

session_start();

require 'app/Config/init.php';

$aplication = new App();
echo $aplication->init();
