<?php
session_start();

require 'core/classes/dbLink.php';
require('core/modules/functions.php');

if (isset($_GET['topic']) && is_numeric($_GET['topic'])) : //Si existe el parametro de ID y es numérico (en este caso) se muestra la página.
    include 'require/header.php';
    $id_topic = $_GET['topic'];

    $user = new User(false);
    $topic = new Topic();

    $topic->select("*", "topics", "id = $id_topic");

    if ($topic->on) : //Si la conexión fue exitosa mostrar la página
        
        $result = $topic->sql;
        $row = $result->fetch_array();

?>
        <section class="content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 breadcrumbf">
                        <a href="/">Inicio</a> <span class="diviver">&gt;</span>
                        <a href="#">Foro</a>
                        <?php if (!empty($row['title'])) {
                            if ($user->isAvailable($row['id'])) {
                                echo '<span class="diviver">&gt;</span> <a>' . $row['title'];
                            }
                        } ?>
                        </a>
                    </div>
                    <div class="col-lg-8 col-md-8">

                        <?php if ($user->isLogged()) : //Si está logueado permitir que pueda crear una publicación. 
                        ?>
                            <!-- New Topic -->
                            <div class="collapse" id="newtopicWrap">
                                <div id="newtopicResponse">
                                </div>
                                <div class="post newtopic container-fluid">
                                    <form role="form" id="newtopicForm" class="form newtopic">
                                        <div class="wrap-ut">
                                            <div class="posttext">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <input type="text" placeholder="Escribe el título de la publicación" id="title" name="title" class="form-control"  autocomplete="off" required
                                                        >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input placeholder="Elige una categoría..." list="categories" id="category" name="category" class="form-control" autocomplete="off" >
                                                        <datalist id="categories">
                                                            <option value="Anuncios">
                                                            <option value="Programación">
                                                            <option value="Educación">
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div>
                                                            <textarea name="content" id="content" id="name" placeholder="Contenido" class="form-control" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="postinfobot">
                                            <div class="pull-right postreply">
                                                <div class="pull-left">
                                                <input type="hidden" name="action" value="newtopic">
                                                    <button id="newtopicBtn" type="submit" class="btn btn-primary" >Publicar</button></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End New Topic -->
                        <?php endif; ?>
                        <?php
                        if (!empty($row)) : // Si la consulta principal tiene resultados.
                            if ($user->isAvailable($row['id'])) : //Revisar si el usuario tiene acceso a ver este post. ?>
                                <div id="forumResponse">
                                    <?php if ($user->isAdmin()) : ?>
                                        
                                        <!-- Post Revision -->
                                        <div class="post">
                                            <div class="wrap-ut revision">
                                                <div class="btn-options">
                                                    <?php if (!$topic->getTopicStatus($id_topic, 'approved')) : ?><button class="approveBtn btn btn-primary" data-type="topics" data-response="#forumResponse" data-id="<?php echo $id_topic; ?>" id="approveTopicBtn">Aprobar Publicación</button><div class="separator"></div><?php endif; ?>
                                                    <?php if ($topic->getTopicStatus($id_topic,  'refused'))  : ?><button class="removeBtn btn btn-danger" data-type="topics" data-response="#forumResponse" data-id="<?php echo $id_topic; ?>"  id="removeTopicBtn" >Eliminar Definitivamente</button><?php endif; ?>
                                                    <?php if (!$topic->getTopicStatus($id_topic, 'refused'))  : ?><button class="btn btn-danger" data-toggle="collapse" data-target="#revisionTopic">Rechazar Publicación</button><?php endif; ?>
                                                </div>
                                            </div>
                                            <?php if (!$topic->getTopicStatus($id_topic, 'refused')) : ?>
                                            <div class="collapse newtopic container-fluid" id="revisionTopic">
                                                <form role="form" class="form">
                                                    <div class="wrap-ut revision">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <p>Razón del rechazo</p>
                                                                <textarea placeholder="Escribe la razón por la que quieres rechazar esta publicación..." id="refuseReason" class="form-control" style="margin: 0;" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="postinfobot">
                                                        <div class="pull-right postreply">
                                                            <div class="pull-left">
                                                                <button data-id="<?php echo $id_topic; ?>" id="refuseTopicBtn" type="submit" class="btn btn-danger">Confirmar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <?php endif; ?>
                                        </div><!-- Post Revision -->
                                        
                                    <?php endif; ?>

                                    <?php if ($row['status'] == 'pending') : //Avisar al usuario de que su publicación se encuentra en revisón ?>
                                        <!-- Pending Advise -->
                                        <div class="post">
                                            <div class="wrap-ut revision  alert-warning">
                                                <div class="posttext ">
                                                    <i class="fa fa-clock-o" style="margin-right: 5px;"></i><span>Esta publicación está pendiente de aprobación. Sólo los moderadores la pueden ver.</span>
                                                </div>
                                            </div>
                                        </div><!-- End Pending Advise -->
                                    <?php endif; ?>

                                    <?php if ($row['status'] == 'refused') : //Avisar al usuario de que su publicación se encuentra rechazada para que haga los cambios pertinentes. ?>
                                        <!-- Pending Advise -->
                                        <div class="post">
                                            <div class="wrap-ut not-found  alert-danger">
                                                <div class="posttext">
                                                    <i class="fa fa-warning" style="margin-right: 5px;"></i><span><strong><?php echo $user->getUserName($row['reviewed_by']); ?></strong> ha rechazado esta publicación por la siguiente razón:</span>
                                                    <p style="color: var(--thm-danger); font-weight: bold"><?php echo $row['reason']; ?></p>
                                                    <p><i class="fa fa-clock-o" style="margin-right: 5px;"></i><?php echo date('d F, Y @ h:i A', strtotime($row['reviewed_date'])); ?></p>
                                                </div>
                                            </div>
                                        </div><!-- End Pending Advise -->
                                    <?php endif; ?>

                                </div>

                                <!-- POST -->
                                <div class="post container-fluid">
                                    <div class="wrap-ut" id="postcontent">
                                        <div class="row">
                                            <div class="col-sm-2 hidden-xs hidden-sm">
                                                <div class="userinfo">
                                                    <div class="avatar">
                                                        <img src="/assets/images/avatar.png" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="posttext"  >
                                                    <h2><a href="/forum?topic=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                                                    <p><?php echo $row['content']; ?></p>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 hidden-xs hidden-sm d-flex-j-center-a-center" style="border-left: solid 1px #f1f1f1;">
                                                <div class="postinfo " id="postinfo">
                                                    <div class="comments">
                                                        <div class="commentbg">
                                                            <?php $topic->getTopicComments($row['id']); ?>
                                                            <div class="mark"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="postinfobot container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="wrap-bt">
                                                    <div class="posted">
                                                        <?php $user->getUserName($row['id_user'], true); ?>
                                                        <i class="fa fa-clock-o"></i><span><?php echo date('d M Y @ h:i A', strtotime($row['reviewed_date'])); ?></span>
                                                    </div>
                                                    <div class="next hidden-xs">
                                                        <?php $topic->getTopicCategory($row['id']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- POST -->
                                <hr>

                                <?php
                                $comment = new Topic();
                                $comment->select("*", "comments", "id_topic = $id_topic", "ORDER BY reviewed_date");
                                $result = $comment->sql;

                                if (($result->num_rows) > 0) { //Comprobar que haya comentarios.
                                    while ($row_comment = $result->fetch_assoc()) : ?>
                                    <?php if ($user->isAvailable($row_comment['id'], "comment")) : //Verificar si el comentario está disponible para todos ?>
                                        <!-- Comment Section -->
                                        <div class="post container-fluid">
                                        <?php if ($row_comment['status'] == 'pending') : //Avisar al usuario de que su publicación se encuentra en revisón ?>
                                        <!-- Pending Advise -->
                                        <div id="commentResponse<?php echo $row_comment['id']; ?>">
                                            <div class="wrap-ut comment alert-warning">
                                                <div class="posttext container-fluid">
                                                    <div class="row">
                                                        <div class="col-lg-8">
                                                            <div class="blocktxt">
                                                                  <i class="fa fa-clock-o" style="margin-right: 5px;"></i><span>Este comentario está pendiente de aprobación. Sólo los moderadores lo pueden ver.</span>
                                                            </div>
                                                        </div>
                                                        <?php if ($user->isAdmin()) : ?>
                                                        <div class="col-lg-4">
                                                            <div class="cotainer-fluid">
                                                                <div class="row">
                                                                    <div class="col-xs-6">
                                                                     <button class="approveBtn btn btn-primary" data-type="comments" data-response="#commentResponse<?php echo $row_comment['id']; ?>" data-id="<?php echo $row_comment['id']; ?>" id="approveCommentBtn">Aprobar</button>
                                                                    </div>
                                                                    <div class="col-xs-6">
                                                                        <button class="removeBtn btn btn-danger" data-type="comments" data-response="#commentResponse<?php echo $row_comment['id']; ?>" data-id="<?php echo $row_comment['id']; ?>" data-target="removeCommentBtn">Eliminar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                  
                                                </div>
                                            </div>
                                        </div><!-- End Pending Advise -->
                                            
                                        <?php endif; ?>
                                            <div class="wrap-ut" id="postcontent">
                                                <div class="row">
                                                    <div class="col-sm-2 hidden-xs hidden-sm">
                                                        <div class="userinfo">
                                                            <div class="avatar">
                                                                <img src="/assets/images/avatar.png" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <div class="posttext">
                                                            <p><?php echo $row_comment['content']; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="postinfobot container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="wrap-bt">
                                                            <div class="posted">
                                                                <?php $user->getUserName($row_comment['id_user'], true); ?>
                                                                <i class="fa fa-clock-o"></i><span><?php echo date('d M Y @ h:i A', strtotime($row_comment['reviewed_date'])); ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- End Comment Section -->
                                        <hr>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                     
                                    <?php
                                }
                                if (!$user->isLogged()) : //Si no está logueado no se mostrará la caja de comentarios.
                                    ?>

                                    <!-- Log-in Advise -->
                                    <div class="post">
                                        <div class="wrap-ut not-found">
                                            <div class="posttext">
                                                Inicia sesión o regístrate para unirte a la discusión y publicar un comentario.
                                            </div>
                                            <div class="right">
                                                <button class="btn btn-primary"  data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                                <div class="separator"></div>
                                                <button class="btn btn-secondary" data-toggle="modal" data-target="#registerModal" control-id="ControlID-8">Registarse</button>
                                            </div>
                                        </div>
                                    </div><!-- End Log-in Advise -->


                                <?php else : //Si está logueado, se podrá comentar. 
                                ?>
                                    <?php if ($row['status'] != 'pending') : //Inhabilitar opción de comentar mientras la publicación esté pendiente de aprobación. 
                                    ?>
                                   
                                    <div id="commentResponse"></div>
                                        <!-- Comment Form -->
                                        <div class="post container-fluid">
                                            <div class="wrap-ut">
                                            <form role="form" id="commentForm" class="form">
                                                <div class="row">
                                                    <div class="col-sm-2 hidden-xs hidden-sm">
                                                        <div class="topwrap">
                                                            <div class="userinfo pull-left">
                                                                <div class="avatar">
                                                                    <img src="/assets/images/avatar.png" alt="">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="posttext">
                                                            <div class="textwraper">
                                                                <div class="postreply">Publica una respuesta</div>
                                                                <input type="hidden" name="action" value="comment">
                                                                <textarea id="commentContent" name="content" placeholder="Escribe tu comentario aquí..."  required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="postinfobot">
                                                    <div class="postreply pull-right">
                                                        <div class="">
                                                            <input type="hidden" name="id_object" value="<?php echo ($_GET['topic']); //Esto es muy inseguro. Lo correcto es pasar el valor del post de otra manera. ?>">
                                                            <button id="commentBtn" type="submit" class="btn btn-primary" >Enviar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            </div>
                                        </div><!-- End Comment Form -->
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else : //Si la función isTopicAvailable devuelve falso:
                            ?>
                                <!-- POST Not Found -->
                                <div class="post">
                                    <div class="wrap-ut not-found">
                                        <div class="posttext">
                                            La publicación o la pregunta que estás buscando no existe.
                                        </div>
                                        <div class="right">
                                            <?php if ($user->isLogged()) : ?>
                                                <button class="btn btn-primary"  data-toggle="collapse" data-target="#newtopicWrap">Crear publicación</button>
                                            <?php else : ?>
                                                <button class="btn btn-primary"  data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
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
                                        La publicación o la pregunta que estás buscando no existe.
                                    </div>
                                    <div class="right">
                                        <?php if ($user->isLogged()) : ?>
                                            <button class="btn btn-primary"  data-toggle="collapse" data-target="#newtopicWrap">Crear publicación</button>
                                        <?php else : ?>
                                            <button class="btn btn-primary"  data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div><!-- End POST Not Found -->
                            <!-- Buttons -->
                            <div class="btn-options row">
                                <div class="col-sm-12 search">
                                    <div class="wrap">
                                        <input id="searchInput" type="text" class="form-control" placeholder="Intenta buscando alguna palabra clave..." >
                                        <button class="btn btn-default" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div><!-- End Buttons -->
                            <div id="searchResponse" class="post sidebarblock">
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>


                    </div>
                    <div class="col-lg-4 col-md-4">
                        <?php $user->getPendingPosts(); ?>
                        <?php $user->getRefusedPosts(); ?>
                        <?php $user->getCategories(); ?>
                        <?php $user->getUserPost(); ?>
                    </div>
                </div>
            </div>

        </section>
        <?php include('require/footer.php'); ?>
    <?php else : ?>
        <?php header('location: /'); ?>
    <?php endif; ?>
