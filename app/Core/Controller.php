<?php

namespace App\Core;

use App\Core\Exceptions\RouteException;
use App\Helpers\HTTP;

class Controller
{
    private $viewPath = 'app/Views/';
    protected $controller = '';
    private $view = '';

    public $app_exceptions = [];

    protected function routes()
    {
        return [];
    }

    /** 
     * Inicializa la aplicación.
     * 
     */
    protected function initialize()
    {
        try {
            $routes = new Routes($this->routes());
            $this->controller = $routes->controller();
            $this->view = $routes->view();

            // Si el controlador no existe, terminar la ejecución
            if (!class_exists($this->controller)) {
                HTTP::sendOutput(404, 404, array('HTTP/1.1 404 Not Found'));
                return $this->renderView('Pages/Error', ['error' => 'Página no encontrada']);
            }

            return (new $this->controller())->{$this->view}();
        } catch (RouteException $e) {
            return $this->renderView('Pages/Error', ['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            return $this->renderView('Pages/Error', ['error' => $e->getMessage()]);
        }
    }

    /** 
     * Renderiza la vista por defecto.
     * 
     */
    protected function index()
    {
        return $this->renderView();
    }

    /** 
     * Renderiza una vista según su ruta 
     * o nombre.
     * 
     */
    protected function renderView($page = '', $data = null)
    {
        $view = $this->viewPath . $page . '.php';

        if (!is_file($view)) {
            throw new \Exception('La vista que se pretende renderizar no existe. <b>Ruta: ' . $view . '</b>');
        }

        $output = (function ($view, $data): string {
            if ($data)
                extract($data);

            ob_start();
            include $view;
            return ob_get_clean() ?: '';
        })($view, $data);

        return $output;
    }
}
