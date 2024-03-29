<?php

namespace App\Core;

use App\Models\User;

class Query extends Database
{
    protected $conn;
    protected $model;
    protected $db_table = '';

    /** 
     * Convierte los registros obtenidos
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
     * @return array|null     
     */
    public function find($id)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE id = :id", [[':id', $id]])[0] ?? null;
    }

    /** 
     * Inserta un registro.
     * 
     * @return int El ID del último registro insertado,
     *             o '0' si no se insertó nada.
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

        return $this->sql_exec("INSERT INTO $this->db_table SET " . implode(', ', $set), $bindings, [], true);
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
        return $this->sql_exec("DELETE FROM $this->db_table WHERE id = :id", [[':id', $id]]);
    }
}
