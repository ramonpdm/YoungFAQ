<?php

class User extends dbLink
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkLogin($username, $password)
    {
        $this->select("id, username, password", "users", "username = '$username' AND password = '$password'");
        $result = $this->sql;
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function escape_string($value)
    {
        return $this->mysqli->real_escape_string($value);
    }

    public function getUserName($id, $justName = false) //Función para obtener el nombre de la tabla usuarios por el ID.
    {
        if ($this->mysqli) {
            $this->select("name", "users", "id = $id");
            $result = $this->sql;
            if ($result != false) {
                $row = $result->fetch_array();
                if (!empty($row)) {
                    if ($justName == false) {
                        echo '<i class="fa fa-user"></i> <span>' . $row[0] . '</span>';
                    } else {
                        echo '<span>' . $row[0] . '</span>';
                    }
                }
            }
            return;
        }
    }

    public function getUserPost($id = null) //Función para obtener el Widget de Publicaciones del Usuario Logeado del Sidebar.
    {
        if ($this->mysqli) {
            if (isset($_SESSION['user'])) {
                $id = $_SESSION['user'];
                $this->select("id, id_user, title, status", "topics", "id_user = $id");
                $result = $this->sql; ?>

                <!-- Posts Widget -->
                <div class="sidebarblock">
                    <h3>Mis Publicaciones</h3>
                    <?php if ($result->num_rows >= 1) { ?>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <div class="divline"></div>
                            <div class="blocktxt <?php echo $row['status']; ?>">
                                <?php if ($row['status'] == 'pending') { ?><i class="fa fa-clock-o"></i><?php } ?><a href="/forum?topic=<?php echo $row['id']; ?>"> <span><?php echo $row['title']; ?></a><br>
                            </div>
                        <?php endwhile; ?>
                </div>
            <?php } else { ?>
                <div class="divline"></div>
                <div class="blocktxt">
                    <span>No tienes ninguna publicación, </span><a href="javascript:void(0);" data-toggle="collapse" data-target="#newtopicWrap">crea</a> una.
                </div>
                </div><!-- End Posts Widget -->
            <?php

                    }
                }
            }
        }

        public function getCategories() //Función para obtener el Widget de Categorías del Sidebar.
        {
            if ($this->mysqli) {
                $this->select("categories.id, categories.name, topics.status, COUNT(categories.name) AS Cantidad", "categories INNER JOIN topics ON topics.id = categories.id_topic", "topics.status = 'published'", "GROUP by categories.name, topics.status ORDER BY Cantidad");
                $result = $this->sql;
                if ($result != false) {
                    if ($result->num_rows > 0) { ?>
                <!-- Categories Gadget -->
                <div class="sidebarblock">
                    <h3>Categorías</h3>
                    <div class="divline"></div>
                    <div class="blocktxt">
                        <ul class="cats">
                            <?php while ($row = $result->fetch_assoc()) {
                            ?>
                                <li><a href="/category/<?php echo $row['id']; ?>"><?php echo $row['name']; ?><span class="badge pull-right"><?php echo $row['Cantidad']; ?></span></a></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div><!-- End Categories Gadget -->
<?php
                    }
                }
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
