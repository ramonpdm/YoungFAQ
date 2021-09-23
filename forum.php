<?php
session_start();


include 'core/init.php';
include 'require/header.php';

$user = new User();

if (isset($_GET['topic']) && is_numeric($_GET['topic'])) : //Si existe el parametro de ID y es numérico (en este caso) se muestra la página.

    $id_topic = $_GET['topic'];


    $conn = new dbLink();
    $conn->select("id, id_user, title, content, date_created, status", "topics", "id = $id_topic");
    if ($conn->on) : //Si la conexión fue exitosa mostrar la página
        $result = $conn->sql;
        $row = $result->fetch_array();

?>

        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 breadcrumbf">
                        <a href="/">Inicio</a> <span class="diviver">&gt;</span>
                        <a href="#">Foro</a>
                        <?php if (!empty($row[2])) {
                            if ($user->isTopicAvailable($row[0])) {
                                echo '<span class="diviver">&gt;</span> <a>' . $row[2];
                            }
                        } ?>
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8">

                        <?php if (isset($_SESSION['user'])) : //Si está logueado permitir que pueda crear una publicación. 
                        ?>
                            <!-- New Topic Form -->
                            <div class="collapse" id="newtopicWrap">
                                <div id="newtopicResponse">
                                </div>
                                <div class="post">
                                    <form role="form" id="newtopicForm" class="form newtopic">
                                        <div class="topwrap">
                                            <div class="userinfo pull-left">
                                                <div class="avatar">
                                                    <img src="/assets/images/avatar.png" alt="">
                                                </div>
                                            </div>
                                            <div class="posttext pull-left">
                                                <div>
                                                    <input type="text" placeholder="Escribe el título del tema" id="title" name="title" class="form-control" control-id="ControlID-4">
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <input placeholder="Elige una categoría..." list="categories" id="category" name="category" class="form-control" control-id="ControlID-5">
                                                        <datalist id="categories">
                                                            <option value="Anuncios">
                                                            <option value="Programación">
                                                            <option value="Educación">
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <textarea name="content" id="content" id="name" placeholder="Contenido" class="form-control" control-id="ControlID-7"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="postinfobot">
                                            <div class="pull-right postreply">
                                                <div class="pull-left">
                                                    <button id="newtopicBtn" type="submit" class="btn btn-primary" control-id="ControlID-14">Publicar</button>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End New Topic Form -->
                        <?php endif; ?>
                        <?php
                        if (!empty($row)) : // Si la consulta principal tiene resultados.
                            if ($user->isTopicAvailable($row[0])) : //Revisar si el usuario tiene acceso a ver este post.
                                $user_id = $row[1]; ?>
                                <div id="forumResponse">
                                    <?php if ($row[5] == 'pending') : ?>
                                        <!-- Pending Advise -->
                                        <div class="post">
                                            <div class="wrap-ut not-found  alert-warning">
                                                <div class="posttext ">
                                                    <i class="fa fa-clock-o" style="margin-right: 5px;"></i><span>Esta publicación está pendiente de aprobación. Sólo los moderadores la pueden ver.</span>
                                                </div>
                                            </div>
                                        </div><!-- End Pending Advise -->
                                    <?php endif; ?>
                                </div>

                                <!-- Post -->
                                <div class="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="/assets/images/avatar.png" alt="">
                                            </div>
                                        </div>
                                        <div class="posttext pull-left">
                                            <h2><a href="#"><?php echo $row[2]; ?></a></h2>
                                            <p><?php echo $row[3]; ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="postinfobot">

                                        <div class="posted pull-left">
                                            <?php echo $user->getUserName($user_id); ?>
                                            <i class="fa fa-clock-o"></i><span><?php echo date('d M Y @ h:m A', strtotime($row['4'])); ?></span>
                                        </div>

                                        <div class="next pull-right">
                                            <a href="#"><i class="fa fa-share"></i></a>
                                        </div>

                                        <div class="clearfix"></div>
                                    </div>
                                </div><!-- End Post -->
                                <hr>

                                <?php
                                $id_topic = $row[0];
                                $conn = new dbLink();
                                $conn->select("id_user, content, date_created, status", "comments", "id_topic = $id_topic and status = 'published'");
                                $result = $conn->sql;

                                if (($result->num_rows) > 0) { //Comprobar que haya comentarios.
                                    while ($row_comment = $result->fetch_assoc()) { ?>

                                        <!-- Comment Section -->
                                        <div class="post">
                                            <div class="topwrap">
                                                <div class="userinfo pull-left">
                                                    <div class="avatar">
                                                        <img src="/assets/images/avatar.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="posttext pull-left">
                                                    <p><?php echo $row_comment['content']; ?></p>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="postinfobot">
                                                <div class="posted pull-left">
                                                    <?php echo $user->getUserName($row_comment['id_user']); ?>
                                                    <i class="fa fa-clock-o"></i><span><?php echo date('d M Y @ h:m A', strtotime($row_comment['date_created'])); ?></span>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div><!-- End Comment Section -->
                                        <hr>

                                    <?php
                                    }
                                }
                                if (!isset($_SESSION['user'])) : //Si no está logueado no se mostrará la caja de comentarios.
                                    ?>

                                    <!-- Log-in Advise -->
                                    <div class="post">
                                        <div class="wrap-ut not-found">
                                            <div class="posttext">
                                                Inicia sesión para unirte a la discusión y publicar un comentario.
                                            </div>
                                            <div class="right">
                                                <button class="btn btn-primary" control-id="ControlID-3" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                            </div>
                                        </div>
                                    </div><!-- End Log-in Advise -->


                                <?php else : //Si está logueado, se podrá comentar. 
                                ?>
                                    <?php if ($row[5] != 'pending') : //Inhabilitar opción de comentar mientras la publicación esté pendiente de aprobación. 
                                    ?>
                                        <!-- Comment Form -->
                                        <div class="post">
                                            <form role="form" id="commentForm" class="form">
                                                <div class="topwrap">
                                                    <div class="userinfo pull-left">
                                                        <div class="avatar">
                                                            <img src="/assets/images/avatar.png" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="posttext pull-left">
                                                        <div class="textwraper">
                                                            <div class="postreply">Publica una respuesta</div>
                                                            <textarea name="commentContent" id="commentContent" placeholder="Escribe tu comentario aquí..." control-id="ControlID-4" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="postinfobot">

                                                    <div class="pull-right postreply">
                                                        <div class="pull-left">
                                                            <input type="hidden" name="id_topic" value="<?php echo ($_GET['topic']); //Esto es muy inseguri. Lo correcto es pasar el valor del post de otra manera. 
                                                                                                        ?>">
                                                            <button id="commentBtn" type="submit" class="btn btn-primary" control-id="ControlID-6">Enviar</button>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>
                                            </form>
                                        </div><!-- End Comment Form -->
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else : //Si la función isTopicAvailable devuelve falso:
                            ?>
                                <!-- POST Not Found -->
                                <div class="post">
                                    <div class="wrap-ut not-found">
                                        <div class="posttext">
                                            El tema o la discusión que estás buscando no existe.
                                        </div>
                                        <div class="right">
                                            <?php if (isset($_SESSION['user'])) : ?>
                                                <button class="btn btn-primary" control-id="ControlID-3" data-toggle="collapse" data-target="#newtopicWrap">Crear tema</button>
                                            <?php else : ?>
                                                <button class="btn btn-primary" control-id="ControlID-3" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div><!-- End POST Not Found -->
                            <?php endif; ?>
                        <?php else : //Si la consulta principal no tiene ningún resultado mostrar este error. 
                        ?>
                            <!-- POST Not Found -->
                            <div class="post">
                                <div class="wrap-ut not-found">
                                    <div class="posttext">
                                        El tema o la discusión que estás buscando no existe.
                                    </div>
                                    <div class="right">
                                        <?php if (isset($_SESSION['user'])) : ?>
                                            <button class="btn btn-primary" control-id="ControlID-3" data-toggle="collapse" data-target="#newtopicWrap">Crear tema</button>
                                        <?php else : ?>
                                            <button class="btn btn-primary" control-id="ControlID-3" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div><!-- End POST Not Found -->
                        <?php endif; ?>
                    <?php endif; ?>


                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php $user->getCategories(); ?>
                        <?php $user->getUserPost(); ?>
                    </div>
                </div>
            </div>

        </section>

    <?php else : ?>
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 breadcrumbf">
                        <a href="/">Inicio</a> <span class="diviver">&gt;</span>
                        <a href="#">Foro</a>
                    </div>

                    <div class="col-lg-8 col-md-8">
                        <?php if (isset($_SESSION['user'])) : //Si está logueado permitir que pueda crear una publicación. 
                        ?>
                            <!-- New Topic Form -->
                            <div class="collapse" id="newtopicWrap">
                                <div id="newtopicResponse">
                                </div>
                                <div class="post">
                                    <form role="form" id="newtopicForm" class="form newtopic">
                                        <div class="topwrap">
                                            <div class="userinfo pull-left">
                                                <div class="avatar">
                                                    <img src="/assets/images/avatar.png" alt="">
                                                </div>
                                            </div>
                                            <div class="posttext pull-left">
                                                <div>
                                                    <input type="text" placeholder="Escribe el título del tema" id="title" name="title" class="form-control" control-id="ControlID-4">
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12">
                                                        <input placeholder="Elige una categoría..." list="categories" id="category" name="category" class="form-control" control-id="ControlID-5">
                                                        <datalist id="categories">
                                                            <option value="Anuncios">
                                                            <option value="Programación">
                                                            <option value="Educación">
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <textarea name="content" id="content" id="name" placeholder="Contenido" class="form-control" control-id="ControlID-7"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="postinfobot">
                                            <div class="pull-right postreply">
                                                <div class="pull-left">
                                                    <button id="newtopicBtn" type="submit" class="btn btn-primary" control-id="ControlID-14">Publicar</button>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End New Topic Form -->
                        <?php endif; ?>

                        <!-- POST Not Found -->
                        <div class="post">
                            <div class="wrap-ut not-found">
                                <div class="posttext">
                                    El tema o la discusión que estás buscando no existe.
                                </div>
                                <div class="right">
                                    <?php if (isset($_SESSION['user'])) : ?>
                                        <button class="btn btn-primary" control-id="ControlID-3" data-toggle="collapse" data-target="#newtopicWrap">Crear tema</button>
                                    <?php else : ?>
                                        <button class="btn btn-primary" control-id="ControlID-3" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div><!-- End POST Not Found -->
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php $user->getCategories(); ?>
                        <?php $user->getUserPost(); ?>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php include('require/footer.php'); ?>