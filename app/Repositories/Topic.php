<?php

namespace App\Repositories;

use App\Core\Query;

class Topic extends Query
{
    protected $model = \App\Models\Topic::class;
    protected $db_table = 'topics';

    /** 
     * Devuelve todas las publicaciones.
     * 
     * @return \App\Models\Topic[]
     */
    public function findAll()
    {
        return $this->select("SELECT *, (SELECT COUNT(*) FROM comments WHERE comments.id_topic = $this->db_table.id ) AS comments_count FROM $this->db_table");
    }

    /** 
     * Devuelve todas las publicaciones
     * que haya creado un usuario por su ID.
     * 
     * @param int $id_user
     * @param array $limit
     * 
     * @return \App\Models\Topic[]
     */
    public function findTopicsByCreator($id_user, $limit = [])
    {
        return $this->select("SELECT * FROM $this->db_table WHERE created_by = :id_user", [[':id_user', $id_user]], $limit);
    }

    /** 
     * Devuelve una sola publicación por su ID.
     * 
     * @param int $id 
     * 
     * @return \App\Models\Topic|null     
     */
    public function find($id)
    {
        return $this->select("SELECT *, (SELECT COUNT(*) FROM comments WHERE comments.id_topic = $this->db_table.id ) AS comments_count FROM $this->db_table WHERE id = :id", [[':id', $id]])[0] ?? null;
    }
}
