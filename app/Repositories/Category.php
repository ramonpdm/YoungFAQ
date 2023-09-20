<?php

namespace App\Repositories;

use App\Core\Query;

class Category extends Query
{
    protected $model = \App\Models\Category::class;
    protected $db_table = 'categories';

    /** 
     * Devuelve todas las categorías.
     * 
     * @return \App\Models\Category[]
     */
    public function findAll()
    {
        return $this->select("SELECT *, (SELECT COUNT(*) FROM topic_categories WHERE topic_categories.id_category = $this->db_table.id ) AS topics_count FROM $this->db_table");
    }

    /** 
     * Devuelve una categoría por su nombre.
     * 
     * @param string $name
     * 
     * @return \App\Models\Category|null 
     */
    public function findByName($name)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE UPPER(name) = :name", [[':name', mb_strtoupper($name)]])[0] ?? null;
    }
}
