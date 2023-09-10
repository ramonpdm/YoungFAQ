<?php

namespace App\Core;

use Exception;

class Model
{
    public function __construct($data)
    {
        $this->setData($data);
    }

    /** 
     * Completa las propiedades de la clase.
     * 
     * @param array $data
     * @return void
     */
    protected function setData($data)
    {
        if (is_null($data))
            return null;

        if (!is_array($data) || empty($data))
            throw new Exception('No se pasaron datos para completar el objeto.');

        extract($data);

        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    /** 
     * Verifica si las propiedades son 
     * nulas.
     * 
     * @throws Exception
     */
    public function validateInstance()
    {
        // Lista de propiedades que no importa si son nulas
        $nullProps = ['updated_by', 'updated_at'];

        foreach (get_object_vars($this) as $prop => $val) {
            // Verificar si la propiedad no está en la lista de permitidas nulas y es nula
            if (!in_array($prop, $nullProps) && $val === null) {
                throw new Exception('El objeto ' . __CLASS__ . ' no tiene suficientes datos. La propiedad ' . $prop . ' es nula.');
            }
        }
    }
}
