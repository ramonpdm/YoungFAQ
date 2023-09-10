<?php

namespace App\Repositories;

use App\Core\Query;

class TopicCategories extends Query
{
    protected $model = \App\Models\Category::class;
    protected $db_table = 'topic_categories';

    /** 
     * Devuelve una lista de categorías
     * según su Topic.
     * 
     * @param int $id_topic
     * 
     * @return \App\Models\Category[]|null 
     */
    public function findTopicCategories($id_topic)
    {
        return $this->select("SELECT categories.* FROM $this->db_table INNER JOIN categories ON categories.id = $this->db_table.id_category WHERE id_topic = :id_topic", [[":id_topic", $id_topic]]);
    }
}
