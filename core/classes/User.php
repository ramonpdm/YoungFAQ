<?php

class User extends dbLink
{

    public function __construct($error_message = true)
    {
        parent::__construct($error_message);
    }

    public function checkCredencials($username, $password = null) //Función (muy básica) para revisar las credenciales.
    {
        if (!is_null($password)) {
            $password_sql = "AND password = " . $password;
        } else {
            $password_sql = "";
        }


        $this->select("id, username, password", "users", "username = '$username' " . $password_sql);
        $result = $this->sql;
        if ($result->num_rows > 0) {
            $row = $result->fetch_array();
            return $row['id'];
        } else {
            return false;
        }
    }

    public function cleanInputs($value) //Función para sanitizar valores que irán en la consulta SQL.
    {
        return strip_tags($this->mysqli->real_escape_string($value));
    }

    public function getUserName($id_user = null, $icon = false) //Función para obtener el nombre de la tabla usuarios por el ID.
    {

        if ($this->mysqli) {
            if ($id_user == null) {
                if ($this->isLogged()) {
                    $id_user = $this->isLogged(true);
                }
            }

            if ($id_user == null) {

                $this->select("name", "users", "id = $id_user");
                $result = $this->sql;

                if ($result) {

                    $row = $result->fetch_array();
                    if ($icon == true) {
                        if ($this->isAdmin($id_user)) {
                            echo '<a class="d-flex-j-center-a-center" style="color: var(--thm-base);" href="/archive?user=' . $id_user . '"><i class="fa fa-star" style="color: var(--thm-base);"></i> <span class="user_name" style="color: var(--thm-base);">' . $row[0] . '</span></a>';
                        } else {
                            echo '<a class="d-flex-j-center-a-center" style="color: var(--thm-gray-1);" href="/archive?user=' . $id_user . '"><i class="fa fa-user"></i> <span class="user_name">' . $row[0] . '</span></a>';
                        }
                    } else {
                        echo '<span class="user_name">' . $row[0] . '</span>';
                    }
                }
            }
        }
    }

    public function getUserPost($id = null) //Función para obtener el Widget de Publicaciones del Usuario Logeado del Sidebar.
    {
        if ($this->mysqli) {
            if ($this->isLogged()) {
                $id_user = $this->isLogged(true);
                $this->select("id, id_user, title, status", "topics", "id_user = $id_user", "ORDER BY date_created DESC");
                $result = $this->sql;
                if ($result) { ?>

                    <!-- Posts Widget -->
                    <div class="sidebarblock">
                        <h3>Mis Publicaciones</h3>
                        <?php
                        if ($result->num_rows > 1) { ?>
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
        }

        public function getCategories() //Función para obtener el Widget de Categorías del Sidebar.
        {
            if ($this->mysqli) {
                $this->select("categories.id_category, categories.name, topics.status, COUNT(categories.name) AS Cantidad", "categories INNER JOIN topics ON topics.id = categories.id_topic", "topics.status = 'approved'", "GROUP by categories.name, topics.status ORDER BY Cantidad");
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
                                <li><a href="/archive?category=<?php echo $row['id_category']; ?>"><?php echo $row['name']; ?><span class="badge pull-right"><?php echo $row['Cantidad']; ?></span></a></li>
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

        public function getPendingComments($id_topic) //Función para obtener el número de comentarios pendientes de un post específico
        {
            $this->select("comments.id, COUNT(comments.id) AS cantidad", "comments INNER JOIN topics on topics.id = comments.id_topic", "topics.id = '" . $id_topic . "' and comments.status = 'pending'");
            $result = $this->sql;
            if ($result) {
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    return $row['cantidad'];
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }

        public function getPendingPosts() //Función para obtener widget de administradores para revisar los post pendientes de aprobación.
        {
            if ($this->isAdmin()) {
                if ($this->mysqli) {
                    $this->select("*", "topics");
                    $result = $this->sql;
                    if ($result != false) { ?>
                <!-- Pending Posts Widget -->
                <div class="sidebarblock">
                    <h3>Pendiente Aprobación</h3>
                    <?php if ($result->num_rows > 0) { ?>
                        <ul class="cats">
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <?php if ($this->getPendingComments($row['id']) > 0 || $row['status'] == 'pending') : ?>
                                    <div class="divline"></div>
                                    <li>
                                        <div class="d-flex-j-between-a-center">
                                            <div class="blocktxt <?php echo $row['status']; ?>">
                                                <?php if ($row['status'] == 'pending') : ?>
                                                    <i class="fa fa-clock-o"></i><a href="/forum?topic=<?php echo $row['id']; ?>"> <span><?php echo $row['title']; ?></a>
                                                <?php else : ?>
                                                    <a href="/forum?topic=<?php echo $row['id']; ?>" style="color: var(--thm-base)"> <span><?php echo $row['title']; ?></a>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($this->getPendingComments($row['id']) > 0) : ?>
                                                <div class="blockbdg">
                                                    <span data-toggle="tooltip" data-placement="bottom" title="Comentarios pendiente" class="badge pull-right"><?php echo $this->getPendingComments($row['id']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </ul>
                </div>
            <?php } else { ?>
                <div class="divline"></div>
                <div class="blocktxt">
                    <span>No hay publicaciones para aprobar.
                </div>
                </div><!-- End Pending Posts Widget -->
            <?php

                        }
                    }
                }
            }
        }

        public function getRefusedPosts() //Función para obtener widget de administradores para revisar los post rechazados.
        {
            if ($this->isAdmin()) {
                if ($this->mysqli) {
                    $this->select("*", "topics", "topics.status = 'refused'", "ORDER BY id DESC");
                    $result = $this->sql;
                    if ($result) {
                        if ($result->num_rows > 0) { ?>
                <!-- Pending Posts Widget -->
                <div class="sidebarblock">
                    <h3>Pendiente Correción</h3>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="divline"></div>
                        <div class="blocktxt <?php echo $row['status']; ?>">
                            <i class="fa fa-clock-o"></i><a href="/forum?topic=<?php echo $row['id']; ?>"> <span><?php echo $row['title']; ?></a><br>
                        </div>
                    <?php endwhile; ?>
                </div>
<?php
                        }
                    }
                }
            }
        }

        public function isLogged($return_user = false) //Función para revisar si hay una sesión abierta.
        {
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user'] != null) {
                    if ($return_user == false) {
                        return true;
                    } else {
                        return $_SESSION['user'];
                    }
                } else {
                    return false;
                }
            }
        }

        public function isAdmin($id_user = null) //Función para verificar nivel de acceso del usuario logueado o especificado.
        {
            if ($id_user == null) {
                if ($this->isLogged()) {
                    $id_user = $this->isLogged(true);
                }
            }
            if (!empty($id_user)) {
                $this->select("level", "users", "id = '$id_user'");
                $result = $this->sql;
                $row = $result->fetch_array();
                if ($result->num_rows > 0) {
                    if ($row['level'] != 1) {
                        return false;
                    } else {
                        return true;
                    }
                }
            }
        }

        public function isAvailable($id_object, $type = "topic") //Función para verificar si el tópico o el comentario especificado está disponible para todos los usuarios.
        {
            if ($type == "topic") {
                $this->select("*", "topics", "id = '$id_object'");
            } else if ($type == "comment") {
                $this->select("*", "comments", "id = '$id_object'");
            }

            $result = $this->sql;
            $row = $result->fetch_array();

            if ($result->num_rows > 0) { //Verificamos que haya una devuelta en la consulta.
                if ($this->isAdmin()) { //¿Eres administrador?
                    return true; //Puedes ver la publicación o el comentario.
                } else { //Si no soy administrador entonces tengo que saber:
                    if ($this->isLogged()) { // ¿Estás logueado? En caso positivo:
                        if ($row['status'] != 'pending' && $row['status'] != 'refused') { //¿La publicación o el comentario está aprobado?
                            return true; //Puedes ver la publicación o el comentario.
                        } else { //Si la publicación no está aprobada tengo que saber:
                            $id_user = $this->isLogged(true); //Obtengo el ID del usuario que está logueado.
                            if ($row['id_user'] == $id_user) { //¿Eres el dueño de esta publicación?
                                return true; //Puedes ver la publicación o el comentario.
                            }
                        }
                    } else { //Si no estás logueado:
                        if ($row['status'] != 'pending' && $row['status'] != 'refused') { //¿La publicación o el comentario está aprobado?
                            return true; //Puedes ver la publicación o el comentario.
                        }
                    }
                }
            } else {
                return false; //Es obvio, pero hay que ponerlo.
            }
        }
    }
