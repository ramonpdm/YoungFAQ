<?php

namespace App\Core;

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
        if (is_array($data)) {
            extract($data[0]);

            foreach ($data as $key => $val) {
                $this->$key = $val;
            }
        }
    }
}
