<?php

namespace App\Core;

use Exception;

class Controller
{
    private $namespace = 'App\Controllers\\';
    private $viewPath = 'app/Views/';
    private $controller = '';

    public $app_exceptions = [];

    /** 
     * Constructor. Identifica cual es exactamente el 
     * controlador al que se está accesando.
     */
    public function __construct()
    {
        $this->controller = Routes::init($this->namespace);

        // Si no se estableció o consiguió una ruta válida
        // se utilizará la ruta de Home por defecto
        if (empty($this->controller))
            $this->controller = $this->namespace . 'Home';
    }

    /** 
     * Inicializa la aplicación.
     * 
     */
    public function initialize()
    {
        // Si el controlador no existe, terminar la ejecución
        if (!class_exists($this->controller)) {
            return $this->renderView('Pages/Error', ['error' => 'Controlador no encontrado']);
        }

        try {
            $controller = new $this->controller();
            return $controller->view();
        } catch (Exception $e) {
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

    protected function view($page  = null, $data = null)
    {
        if (!isset($_GET['view']))
            return $this->index();
    }

    /** 
     * Renderiza una vista según su ruta 
     * o nombre.
     * 
     */
    protected function renderView($page = '', $data = null)
    {
        $page = $page === '' ? 'Pages/' . str_replace($this->namespace, '', $this->controller) : $page;
        $view = $this->viewPath . $page . '.php';

        if (!is_file($view)) {
            throw new Exception('La vista que se pretende renderizar no existe. <b>Ruta: ' . $view . '</b>');
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
