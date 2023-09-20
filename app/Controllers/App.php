<?php

namespace App\Controllers;

use App\Core\Controller;

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
            'GET /topic' => [Topic::class, 'view'],
            'POST /login' => [Login::class, 'index'],
            'POST /register' => [Login::class, 'register'],
            'POST /topic' => [Topic::class, 'create'],
        ];
    }
}
