<?php
class dbLink
{
    public $on = false;
    private $DBHOST = 'localhost';
    private $DBUSER = 'root';
    private $DBPASS = '';
    private $DBNAME = 'youngfaq';
    private $result = array();
    protected $mysqli;

    public function __construct()
    {
        try {
            $this->mysqli = @mysqli_connect($this->DBHOST, $this->DBUSER, $this->DBPASS, $this->DBNAME);
            $this->on = true;
            if (!$this->mysqli) {
                $this->on = false;
                throw new Exception('Ha habido un error en el sistema. Favor contacte a un administrador.');
            }
        } catch (Exception $e) {
            $this->on = false; ?>

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
        return $this->mysqli;
    }

    public $insert_id;
    public $sql;

    public function insert($table, $data = array())
    {
        $table_columns = implode(',', array_keys($data));
        $table_value = implode("','", $data);

        $sql = "INSERT INTO $table($table_columns) VALUES('$table_value')";

        if ($this->mysqli) {
            $this->mysqli->query($sql);
            return $insert_id = $this->mysqli->insert_id;

        }
    }

    public function update($table, $data = array(), $id)
    {
        $args = array();

        foreach ($data as $key => $value) {
            $args[] = "$key = '$value'";
        }

        $sql = "UPDATE  $table SET " . implode(',', $args);
        $sql .= " WHERE $id";
        $result = $this->mysqli->query($sql);
    }

    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table";
        $sql .= " WHERE $id ";
        $sql;
        $result = $this->mysqli->query($sql);
    }

    public function select($table, $rows = "*", $where = null)
    {
        if ($this->mysqli) {
            if ($where != null) {
                $sql = "SELECT $rows FROM $table WHERE $where";
            } else {
                $sql = "SELECT $rows FROM $table";
            }
            $this->sql = $result = $this->mysqli->query($sql);
        }
    }

    public function getUser($id, $justName = false) //Función para obtener el nombre de la tabla usuarios por el ID.
    {
        if ($this->mysqli) {
            $sql = "SELECT name FROM users WHERE id = $id";
            $result = $this->mysqli->query($sql);
            if ($result != false) {
                $user = mysqli_fetch_row($result);
                if (!empty($user)) {
                    if ($justName == false) {
                        return '<i class="fa fa-user"></i> <span>' . $user[0] . '</span>';
                    } else {
                        return '<span>' . $user[0] . '</span>';
                    }
                }
            }
            return;
        }
    }

    public function getCategories() //Función para obtener el Widget de Categorías del Sidebar.
    {
        if ($this->mysqli) {
            $sql = "SELECT * FROM categories";
            $result = $this->mysqli->query($sql);
            if ($result != false) {
                if (mysqli_num_rows($result) > 0) { ?>
                    <!-- Categories Gadget -->
                    <div class="sidebarblock">
                        <h3>Categorías</h3>
                        <div class="divline"></div>
                        <div class="blocktxt">
                            <ul class="cats">
                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                    <li><a href="/category/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?><span class="badge pull-right"><?php echo $row['count']; ?></span></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div><!-- End Categories Gadget -->
                <?php  }
            }
        }
    }

    public function getUserPost($id = null) //Función para obtener el Widget de Publicaciones del Usuario Logeado del Sidebar.
    {
        if ($this->mysqli) {
            if (isset($_SESSION['user'])) {
                $id = $_SESSION['user'];
                $sql = "SELECT id, id_user, title, status FROM topics WHERE id_user = $id";
                $result = $this->mysqli->query($sql);
                if ($result != false) { ?>
                    <!-- Posts Widget -->
                    <div class="sidebarblock">
                        <h3>Mis Publicaciones</h3>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <div class="divline"></div>
                            <div class="blocktxt <?php echo $row['status']; ?>">
                                <?php if ($row['status'] == 'pending') { ?><i class="fa fa-clock-o"></i><?php } ?><a href="/topic/<?php echo $row['id']; ?>"> <span><?php echo $row['title']; ?></a><br>
                            </div>
                        <?php endwhile; ?>
                    </div><!-- End Posts Widget -->
<?php
                }
            }
        }
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}

include('userClass.php');
include('topicCLass.php');
include('functions.php');
