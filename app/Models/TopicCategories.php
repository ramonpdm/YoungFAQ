<?php

namespace App\Models;

use App\Models\Topic;
use App\Models\Category;
use App\Core\Model;

class TopicCategories extends Model
{
    // Internal Database Props
    protected $id;
    protected $id_topic;
    protected $id_category;
    protected $created_by;
    protected $created_at;

    // Virtual Props
    protected Topic $topic;
    protected Category $categories;

    public function __construct($data = null)
    {
        parent::__construct($data);
    }
}
