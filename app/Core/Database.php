<?php

namespace App\Core;

use PDO;
use PDOException;
use Exception;
use App\Core\Exceptions\DatabaseException;

class Database
{
    protected $model;
    protected $conn;

    /** 
     * Constructor. Intenta realizar la conexión
     * a la base de datos.
     * 
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE,  DB_USERNAME, DB_PASSWORD);
            $this->conn->exec("set names utf8");

            if (!$this->model)
                throw new Exception('La propiedad <b>$model</b> no ha sido establecida en la clase: <b>' . get_class($this) . '</b>');
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /** 
     * Ejecuta una consulta y retorna un Array
     * asociativo los datos seleccionados.
     * 
     * @param string $query     Consulta SQL.
     * @param array  $params    Párametros a Bindear
     * 
     * @throws Exception
     * @return array
     */
    protected function select($query = "", $params = [], $limit = [])
    {
        try {
            $stmt = $this->sql_exec($query, $params, $limit);
            $stmt->execute();

            // Si el modelo proporcionado existe,
            // retornar un arreglo de objetos del modelo
            if (class_exists($this->model))
                return $stmt->fetchAll(PDO::FETCH_CLASS, $this->model);

            // Si el modelo no existe,
            // retornar un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /** 
     * Ejecuta una comando SQL.
     * 
     * @param string    $query          Consulta SQL.
     * @param array     $params         Párametros a bindear
     * @param array     $limit          Límites de registros
     * @param bool      $lastInsertId   Retornar o no, el ID del
     *                                  último registro insertado.
     * 
     * @throws Exception
     * @return PDOStatement|false|int
     */
    protected function sql_exec($query = "", $params = [], $limit = [], $lastInsertId = false)
    {
        try {
            // Si hay limites, establecerlos
            if ($limit && $limit[0]) {
                $query .= ' LIMIT ' . $limit[0];
            }

            $stmt = $this->conn->prepare($query);

            // Si hay parámetros, bindear cada uno de ellos
            if ($params) {
                foreach ($params as $param) {
                    $stmt->bindParam($param[0], $param[1]);
                }
            }

            $stmt->execute();

            if ($lastInsertId)
                return $this->conn->lastInsertId();

            return $stmt;
        } catch (PDOException $e) {
            throw new DatabaseException($e->getMessage(), $e->getCode());
        }
    }

    /** 
     * Convertir elementos de un arreglo 
     * a objetos de la clase model.
     * 
     * @param array $data 
     * @return void
     */
    protected function parse(&$data)
    {
        // Si no hay datos, no hacer nada
        if (empty($data))
            return;

        // Si el modelo no existe, no hacer nada
        if (!class_exists($this->model))
            return;

        // Validar y convertir a objetos si es necesario
        foreach ($data as &$object) {
            if (!is_object($object)) {
                $object = new $this->model($object);
            }
        }
    }
}
