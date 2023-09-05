<?php

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    // Internal Database Props
    protected $id;
    protected $name;
    protected $created_by;
    protected $created_at;
    protected $updated_by;
    protected $updated_at;

    // Virtual Props
    protected $topics_count;

    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /** 
     * Category ID getter
     * 
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /** 
     * Category name getter
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /** 
     * Category topics count getter
     * 
     * @return string
     */
    public function getTopicsCount()
    {
        return $this->topics_count;
    }
}
