<?php

class Topic extends dbLink
{

    public function __construct($error_message = true)
    {
        parent::__construct($error_message);
    }

    public function nextID($table = "topics") //Función para obtener el siguiente ID que se utilizará para crear una publicación. Este valor se utilizará para asignarselo a la categoría que se quiera agregar.
    {
        $this->select('AUTO_INCREMENT', 'information_schema.TABLES',  'TABLE_SCHEMA = "youngfaq" AND TABLE_NAME = "' . $table . '"');
        $result = $this->sql;
        $row = $result->fetch_array();
        return $row['0'];
    }

    public function nextCategoryID($category_name)
    { //Función para obtener el siguiente ID que se utilizará para crear una categoría que existe o no existe.
        $this->select("id_category", "categories", "name = '$category_name'");
        $result = $this->sql;
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0) {
            return $row['id_category'];
        } else {
            $this->select("MAX(id_category) AS id_max", "categories");
            $result2 = $this->sql;
            $row2 = $result2->fetch_array();
            return $row2[0] + 1;
        }
    }

    public function insertData($type = 'topic', $fields = array(), $category = null) //Función para crear una publicación o un comentario.
    {
        if ($type == 'topic') {


            if ($this->insert('topics', $fields)) {
                if (!is_null($category)) {
                    $this->insert('categories', $category);
                }
            } else {
                throw new Exception('Ha habido un error al crear la publicación. Favor contacte a un administrador.');
            }
        } else if ($type == 'comment') {
            if ($this->insert('comments', $fields)) {
            } else {
                throw new Exception('Ha habido un error al crear el comentario. Favor contacte a un administrador.');
            }
        }
    }

    public function getTopicCategory($id_topic) //Funcion para obtener cantidad de comentarios que tiene una publicación específica.
    {
            $this->select("categories.name, categories.id_category", "categories INNER JOIN topics ON topics.id = categories.id_topic", "categories.id_topic = " . $id_topic);
            $result = $this->sql;
            $row = $result->fetch_array();
            if ($result) {
                if ($result->num_rows > 0) {
                    echo '<a href="/archive?category=' . $row['id_category'] . '"><i class="fa fa-list"></i>' . $row['name'] . '</a>';
                }
            }
        
    }

    public function getTopicComments($id_topic) //Funcion para obtener cantidad de comentarios que tiene una publicación específica.
    {
        $this->select("COUNT(id_topic) AS Cantidad", "comments INNER JOIN topics ON topics.id = comments.id_topic", "comments.id_topic = " . $id_topic);
        $result = $this->sql;
        $row = $result->fetch_array();
        if ($result->num_rows > 0) {
            echo $row['Cantidad'];
        } else {
            echo 0;
        }
    }

    public function getTopicStatus($id_topic, $status)
    { //Función que devuelve un booleano dependiendo del estado de una publicación.
        $this->select("id", "topics", "id = $id_topic and status = '$status'");
        $result = $this->sql;
        if ($result) {
            if ($result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            echo 'No se encontró el post especificado.';
        }
    }
}
