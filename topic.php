<?php 

include 'core/init.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $topic_id = $_GET['id'];
    include 'require/header.php'; 
    $conn = new dbLink();
    $conn->select("topics", "id, id_user, title, content, date_created, status", "id = $topic_id and status = 'published'");
    if ($conn->on) {
        $result = $conn->sql;
        $row = mysqli_fetch_row($result);
        
    ?>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 breadcrumbf">
                    <a href="/">Inicio</a> <span class="diviver">&gt;</span> <a href="#">Anuncios</a> <span class="diviver">&gt;</span> <a><?php echo $row['2']; ?></a>
                </div>
                <div class="col-lg-8 col-md-8"> 
                    <?php if (!empty($row)) { $user_id = $row['1']; ?>   
                        <!-- Post -->
                    <div class="post">
                                <div class="topwrap">
                                    <div class="userinfo pull-left">
                                        <div class="avatar">
                                            <img src="/assets/images/avatar.png" alt="">
                                        </div>
                                    </div>
                                    <div class="posttext pull-left">
                                        <h2><a href="#"><?php echo $row['2']; ?></a></h2>
                                        <p><?php echo $row['3']; ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="postinfobot">

                                    <div class="posted pull-left">
                                        <?php echo $conn->getUser($user_id); ?>
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
                            $topic_id = intval($row['0']);
                            $conn = new dbLink();
                            $conn->select("comments", "id_user, content, date_created, status", "id_topic = $topic_id and status = 'published'");
                            $result = $conn->sql;

                            if (mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_row($result);
                                
                            ?>
                            
                            <!-- Comment -->
                                <div class="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="/assets/images/avatar.png" alt="">
                                            </div>
                                        </div>
                                        <div class="posttext pull-left">
                                            <p><?php echo $row['1']; ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="postinfobot">
                                        <div class="posted pull-left">
                                            <?php echo $conn->getUser($row['0']); ?>
                                            <i class="fa fa-clock-o"></i><span><?php echo date('d M Y @ h:m A', strtotime($row['2'])); ?></span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div><!-- End Comment -->
                                <hr>

                                <?php  } if (!isset($_SESSION['user'])) : ?>
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
                                <?php else : ?>   
                                    <!-- Log-in Form -->
                                    <div class="post">
                                        <form action="#" class="form" method="post">
                                            <div class="topwrap">
                                                <div class="userinfo pull-left">
                                                    <div class="avatar">
                                                        <img src="/assets/images/avatar.png" alt="">
                                                    </div>
                                                </div>
                                                <div class="posttext pull-left">
                                                    <div class="textwraper">
                                                        <div class="postreply">Publica una respuesta</div>
                                                        <textarea name="reply" id="reply" placeholder="Escribe tu comentario aquí..." control-id="ControlID-4"></textarea>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="postinfobot">

                                                <div class="pull-right postreply">
                                                    <div class="pull-left"><button type="submit" class="btn btn-primary" control-id="ControlID-6">Enviar</button></div>
                                                    <div class="clearfix"></div>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                        </form>
                                    </div><!-- End Log-in Form -->
                                <?php endif; ?>   
                            <?php
                        } else { ?>
                            <!-- POST Not Found -->
                            <div class="post">
                                <div class="wrap-ut not-found">
                                    <div class="posttext">
                                        El tema o la discusión que estás buscando no existe o no ha sido aprobado.
                                    </div>
                                    <div class="right">
                                        <button class="btn btn-primary" control-id="ControlID-3" data-toggle="collapse" data-target="#newtopicWrap">Crear tema</button>
                                    </div>
                                </div>
                            </div><!-- End POST Not Found -->

                            <?php if (isset($_SESSION['user'])) : ?>
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
                                                    <button id="newtopicBtn" type="submit" class="btn btn-primary" control-id="ControlID-14">Publicar</button></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End New Topic Form -->
                            <?php endif; ?>   
                    <?php
                        }
                    } ?>

                </div>
                <?php include('require/sidebar.php'); ?>
            </div>
        </div>

    </section>
<?php include('require/footer.php');
} ?>