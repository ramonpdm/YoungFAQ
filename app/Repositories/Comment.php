<?php

namespace App\Repositories;

use App\Core\Query;

class Comment extends Query
{
    protected $model = \App\Models\Comment::class;
    protected $db_table = 'comments';

    /** 
     * Devuelve una lista de comentarios
     * según su Topic.
     * 
     * @param int $id_topic
     * 
     * @return \App\Models\Category[]|null 
     */
    public function findTopicComments($id_topic)
    {
        return $this->select("SELECT * FROM $this->db_table WHERE id_topic = :id_topic", [[":id_topic", $id_topic]]);
    }
}
