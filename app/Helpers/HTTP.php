<?php

namespace App\Helpers;

class HTTP
{
    /** 
     * Envía la salida de la API. 
     * 
     * @param mixed $data               Los datos que serán devueltos.
     * @param int   $http_response_code El código HTTP de la respuesta.
     * @param array $http_headers       Los encabezados que serán establecidos.
     * 
     * @return string codificado en JSON.
     */
    public static function sendOutput($data, $http_response_code = 200, $http_headers = array())
    {
        // Establecer los headers recibidos
        if (is_array($http_headers) && count($http_headers)) {
            foreach ($http_headers as $httpHeader) {
                header($httpHeader);
            }
        }

        // Evitar retornar JSON y establecer un código
        if ($data === 404)
            return;

        header('Content-Type: application/json; charset=UTF-8');

        if ($http_response_code)
            http_response_code($http_response_code);

        return json_encode($data);
    }


    public static function redirect($location = '/')
    {
        return header('location: ' . APP_URL . $location);
    }
}
