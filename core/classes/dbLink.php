<?php
class dbLink
{
    public $sql, $on = false;
    protected $mysqli;
    private $DBHOST = 'localhost', $DBUSER = 'root', $DBPASS = '', $DBNAME = 'youngfaq', $result = array();


    public function __construct($error_message = true)
    {
        try { //Intentar conectarnos
            $this->mysqli = @mysqli_connect($this->DBHOST, $this->DBUSER, $this->DBPASS, $this->DBNAME);
            $this->on = true;
            if (!$this->mysqli) { //lógica para excepción/error.
                $this->on = false;
                if ($error_message == true) {
                    throw new Exception('Ha habido un error en el sistema. Favor contacte a un administrador.');
                }
            }
        } catch (Exception $e) {
            $this->on = false;
            if ($error_message == true) { ?>

                <!-- Error -->
                <div class="post">
                    <div class="wrap-ut not-found">
                        <div class="posttext">
                            <?php echo $e->getMessage() . PHP_EOL; ?>
                        </div>
                    </div>
                </div><!-- End Error -->

<?php
            }
        }
        return $this->mysqli;
    }

    public function insert($table, $data = array()) //Función para insertar datos a una tabla específica a través de un arreglo.
    {
        $table_columns = implode(',', array_keys($data));
        $table_value = implode("','", $data);

        $sql = "INSERT INTO $table($table_columns) VALUES('$table_value')";

        if ($this->mysqli) {
            $this->mysqli->query($sql);
            return true;
        }
    }

    public function update($table, $data = array(), $where)
    {
        $args = array();

        foreach ($data as $key => $value) {
            $args[] = "$key = '$value'";
        }

        $sql = "UPDATE  $table SET " . implode(',', $args);
        $sql .= " WHERE $where";
        $result = $this->mysqli->query($sql);
    }

    public function delete($table, $where)
    {
        $sql = "DELETE FROM $table";
        $sql .= " WHERE $where ";
        $sql;
        $result = $this->mysqli->query($sql);
    }

    public function select($rows = "*", $table, $where = null, $aditional = null) //Función para hacer consultas a nuestra base de datos.
    {
        if ($this->mysqli) {
            if ($where != null || $aditional != null) {
                $sql = "SELECT $rows FROM $table WHERE $where $aditional";
            } else {
                $sql = "SELECT $rows FROM $table";
            }
            $this->sql = $result = $this->mysqli->query($sql);
        }
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}

include('User.php');
include('Topic.php');


?>