<?php

class Topic extends dbLink
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $mysqli;

    public function nextID($table = "topics")
    {
        $this->select('AUTO_INCREMENT','information_schema.TABLES',  'TABLE_SCHEMA = "youngfaq" AND TABLE_NAME = "'.$table.'"');
        $result = $this->sql;
        $row = mysqli_fetch_row($result);
        return $row['0'];
    }

    public function insertData($type = 'topic', $fields = array(), $category = null) //Función para crear publicación/tema/discusión.
    {
        if ($type == 'topic'){
            if ($this->insert('topics', $fields)){
                if (!is_null($category)){
                    $this->insert('categories', $category);
                }
            }else{
                throw new Exception('Ha habido un error al crear la publicación. Favor contacte a un administrador.');
            }
        }else if ($type == 'comment'){
            if ($this->insert('comments', $fields)){
            }else{
                throw new Exception('Ha habido un error al crear el comentario. Favor contacte a un administrador.');
            }
        }
        
    }
}
