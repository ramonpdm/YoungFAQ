<?php

require_once('init.php');

class Topic extends dbLink
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $mysqli;
    public $insert_id;

    public function getNextID(){
        $this->select('topics', 'MAX(id)');
        $result = $this->sql;
        $row = mysqli_fetch_row($result);
        $id_next_topic = $row['0'] + 1;
    } 

    public function newTopic($fields = array(), $category = null) //Función para crear publicación/tema/discusión.
    {
        $this->insert('topics', $fields);
        echo $this->$insert_id;
        if (!is_null($category)){
            $this->insert('categories', $category);
        }
    }
}