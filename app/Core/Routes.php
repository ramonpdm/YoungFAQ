<?php

namespace App\Core;

use App\Core\Exceptions\RouteException;

class Routes
{
    private $routes;
    private $current_method;
    private $current_controller;
    private $current_view;

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->current_method = $_SERVER['REQUEST_METHOD'];
        $this->validate();
    }

    private function validate()
    {
        foreach ($this->routes as $route => $controller) {
            $route = explode(' ', $route);

            if (count($route) < 2)
                throw new RouteException('No se especificó correctamente la ruta');

            if (!isset($_GET['route']))
                throw new RouteException('La ruta no ha sido establecida');

            if (count($controller) < 2)
                throw new RouteException('No se especificó el controlador y la función que manejará la ruta correctamente');

            if (!class_exists($controller[0]))
                throw new RouteException('El controlador ' . $controller[0] . ' no existe');

            if (!method_exists($controller[0], $controller[1]))
                throw new RouteException('La vista ' . $controller[1] . ' no existe');

            $url_route = $_GET['route'] === 'index.php' ? '/' : '/' . $_GET['route'];
            if ($route[0] === $this->current_method && $route[1] ===  $url_route) {
                $this->current_controller = $controller[0];
                $this->current_view = $controller[1];
                return;
            }
        }

        return null;
    }

    public function controller()
    {
        return $this->current_controller;
    }

    public function view()
    {
        return $this->current_view;
    }
}
