<?php
class dbLink
{
    public $que;
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

    public function insert($table, $para = array())
    {
        $table_columns = implode(',', array_keys($para));
        $table_value = implode("','", $para);

        $sql = "INSERT INTO $table($table_columns) VALUES('$table_value')";
        
        if ($this->mysqli) {
            $this->mysqli->query($sql);
        }
    }

    public function update($table, $para = array(), $id)
    {
        $args = array();

        foreach ($para as $key => $value) {
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

    public $sql;

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

    public function getUser($id, $justName = false)
    {
        if ($this->mysqli) {
            $s = "SELECT name FROM users WHERE id = $id";
            $r = $this->mysqli->query($s);
            if ($r != false) {
                $user = mysqli_fetch_row($r);
                if (!empty($user)) {
                    if ($justName == false){
                    return '<i class="fa fa-user"></i> <span>' . $user[0] . '</span>';
                }else{
                    return '<span>' . $user[0] . '</span>';
                }
                }
            }
            return;
        }
    }

    public function getUserPost($id = null)
    {
        if ($this->mysqli) {
            if (isset($_SESSION['user'])) {
                $id = $_SESSION['user'];
                $s = "SELECT id, id_user, title FROM topics WHERE id_user = $id AND status = 'published'";
                $r = $this->mysqli->query($s);
                if ($r != false) {
                    while ($row = mysqli_fetch_assoc($r)) {?>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <a href="/topic/<?php echo $row['id']; ?>"> <span><?php echo $row['title']; ?></a><br>
                    </div>
             <?php  }
                }
            } else {
                return '<div class="divline"></div>
                <div class="blocktxt">
                No estás logueado, <a data-toggle="modal" data-target="#loginModal">inicia sesión</a> o <a data-toggle="modal" data-target="#registerModal">regístrate</a> </div>.' . PHP_EOL;
            }
        } else {
            return '<div class="posttext">Ha habido un error en el sistema. Favor contacte a un administrador.</div>' . PHP_EOL;
        }
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}

class Topic extends dbLink
{
    public function __construct()
    {
        parent::__construct();
    }

    public function create($fields = array()) {
        if(!$this->insert('topics', $fields)) {
            throw new Exception('Lo siento, ha habido un problema al creada tu publicación.');
        }
    }
}

class User extends dbLink
{

    public function __construct()
    {
        parent::__construct();
    }

    public function check_login($username, $password)
    {

        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $query = $this->mysqli->query($sql);

        if ($query->num_rows > 0) {
            $row = $query->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function details($sql)
    {

        $query = $this->mysqli->query($sql);
        $row = $query->fetch_array();
        return $row;
    }

    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }
}

function getAgo($time)
{
    date_default_timezone_set('America/Santo_Domingo');
    $periods = array("second", "min", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();

    $difference     = $now - strtotime($time);
    $tense         = "ago";

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j] .= "s";
    }

    return " $difference $periods[$j] ago ";
}
