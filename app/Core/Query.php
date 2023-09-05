<?php

namespace App\Core;

use App\Models\User;

class Query extends Database
{
    protected $conn;
    protected $model;
    protected $db_table = '';

    /** 
     * Devuelve todos los registros y
     * convierte el arreglo de datos
     * en un arreglo de objetos.
     * 
     * @param string $query Consulta SQL
     * @param array $params Parámetros para bindear
     * @param array $limit  Límites de los registros
     * 
     * @return array
     */
    protected function select($query = "", $params = [], $limit = [])
    {
        $data = parent::select($query, $params, $limit);
        parent::parse($data);

        return $data;
    }

    /** 
     * Devuelve todos los registros.
     * 
     * @return array
     */
    public function findAll()
    {
        return parent::select("SELECT * FROM $this->db_table");
    }

    /** 
     * Devuelve un solo registro por su ID.
     * 
     * @param int $id       ID del registro
     * @param array $limit  Límites de los registros
     * 
     * @return array     
     */
    public function find($id)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE id = :id", [[":id", htmlspecialchars(strip_tags($id))]])[0] ?? null;
    }

    /** 
     * Inserta un registro.
     * 
     * @return array|bool
     */
    public function insert($data)
    {
        if (!is_array($data))
            return false;

        $bindings = [];
        $set = [];

        foreach ($data as $key => $val) {
            $bindings[] =  [':' . $key,  $val];
            $set[] = $key . ' = '  . ':' . $key;
        }

        $bindings[] =  [':created_by',  $_SESSION[User::SESSION_LABEL_ID]];

        return $this->sql_exec("INSERT INTO $this->db_table SET " . implode(', ', $set), $bindings);
    }

    /** 
     * Elimina un registro por su ID.
     * 
     * @param int $id ID del registro
     * 
     * @return PDOStatement
     */
    public function delete($id)
    {
        return $this->sql_exec("DELETE FROM $this->db_table WHERE id = :id", [[":id", htmlspecialchars(strip_tags($id))]]);
    }
}
