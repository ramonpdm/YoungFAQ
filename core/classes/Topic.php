<?php

class Topic extends dbLink
{
    public function __construct()
    {
        parent::__construct();
    }

    protected $mysqli;

    public function nextID($table = "topics") //Función para obtener el siguiente ID que se utilizará para crear una publicación. Este valor se utilizará para asignarselo a la categoría que se quiera agregar.
    {
        $this->select('AUTO_INCREMENT', 'information_schema.TABLES',  'TABLE_SCHEMA = "youngfaq" AND TABLE_NAME = "' . $table . '"');
        $result = $this->sql;
        $row = $result->fetch_array();
        return $row['0'];
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

    public function getTopicCategory($id_topic) //Funcion para obtener cantidad de comentarios que tiene una publicación específica.
    {
        $this->select("categories.name, categories.id", "categories INNER JOIN topics ON topics.id = categories.id_topic", "categories.id_topic = " . $id_topic);
        $result = $this->sql;
        $row = $result->fetch_array();
        if ($result->num_rows > 0) {
            echo '<a href="/category/' . $row['id'] . '"><i class="fa fa-list"></i>' . $row['name'] . '</a>';
        }
    }

    
    public function isTopicAvailable($id_topic) //Función para verificar si el tópico especificado está disponible para todos los usuarios.
    {
        $this->select("*", "topics", "id = '$id_topic'");
        $result = $this->sql;
        $row = $result->fetch_array();

        if (!empty($result)) {
            if ($result->num_rows >= 1) {
                if ($row['status'] == 'pending') {
                    if (isset($_SESSION['user'])) {
                        $id_user = $_SESSION['user'];
                        if ($row['id_user'] == $id_user) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
