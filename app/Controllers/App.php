<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\Home;
use App\Controllers\Login;

class App extends Controller
{
    /** 
     * Inicializa la aplicación.
     * 
     */
    public function init()
    {
        return parent::initialize();
    }

    /** 
     * Establecer las rutas.
     * 
     */
    protected function routes()
    {
        return [
            'GET /' => [Home::class, 'index'],
            'GET /logout' => [Login::class, 'logout'],
            'POST /login' => [Login::class, 'index'],
            'POST /register' => [Login::class, 'register'],
        ];
    }
}
