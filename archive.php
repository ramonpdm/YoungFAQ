<?php 
session_start(); 
require 'core/classes/dbLink.php';
require('core/modules/functions.php');
require('require/header.php');
if (!isset($_GET['category']) && !isset($_GET['user'])){
    header('location: /');
}
$user = new User(false); $topic = new Topic();
?>
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 breadcrumbf">
                            <a href="/">Inicio</a>
                        </div>
                        <div class="col-lg-8 col-md-8">
                        <?php if (isset($_SESSION['user'])) : ?>
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
                                                        <input type="text" placeholder="Escribe el título de la publicación" id="title" name="title" class="form-control" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <input placeholder="Elige una categoría..." list="categories" id="category" name="category" class="form-control" autocomplete="off">
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
                                                    <button id="newtopicBtn" type="submit" class="btn btn-primary">Publicar</button></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- End New Topic -->
                            <?php endif; ?>   

                            <!-- Archive Header -->
                            <div class="btn-options container-fluid">
                                <?php 

                                    if (isset($_GET['category'])){
                                        $archive = 'category';
                                        $id_object = $_GET['category'];
                                        $topic->select("name", "categories", "id_category = " . $id_object);
                                        $result = $topic->sql;
                                        if ($result){
                                            $row = $result->fetch_array();
                                            if ($result->num_rows > 0) {
                                                $title = 'Categoría: <strong>' . $row['name'] . '</strong>';
                                            }else{
                                                $title = false;
                                            }  
                                        }
                                    } 
                                    
                                    if (isset($_GET['user'])){
                                        $archive = 'user';
                                        $id_object = $_GET['user'];
                                        $topic->select("name", "users", "id = " . $id_object);
                                        $result = $topic->sql;
                                        if ($result){
                                            $row = $result->fetch_array();
                                            if ($result->num_rows > 0) {
                                                $title = 'Autor: <strong>' . $row['name'] . '</strong>';
                                            }else{
                                                $title = false;
                                            }  
                                        }
                                    }

                                    if ($title != false) :
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="post">
                                            <div class="wrap-ut not-found">
                                                <div class="posttext">
                                                    <h2><?php echo $title; ?></h2>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="row">
                                    <div class="col-sm-12 search">
                                        <div class="wrap">
                                            <input id="searchInput" type="text" class="form-control" placeholder="Buscar publicaciones...">
                                            <button class="btn btn-default" type="button">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- Archive Header -->
                    
                            <div id="searchResponse" class="post sidebarblock">
                            </div>

                            <?php
                           
                            if ($archive == 'category'): $topic->select("topics.id, topics.id_user, topics.title, topics.content, topics.reviewed_date, categories.id_topic, categories.name", "topics INNER JOIN categories on categories.id_topic = topics.id", "status = 'approved' and categories.id_category = '$id_object '", "ORDER BY reviewed_date DESC"); endif;
                            if ($archive == 'user'): $topic->select("*", "topics", "status = 'approved' and topics.id_user = '$id_object '", "ORDER BY reviewed_date DESC"); endif;

                            if ($topic->on) {
                                $result = $topic->sql;
                                if ($result){
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                            ?>
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
                                                    <div class="col-sm-8 full-col">
                                                        <div class="posttext">
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
                                                                <i class="fa fa-clock-o"></i><span><?php echo getAgo($row['reviewed_date']); ?></span>
                                                            </div>
                                                            <div class="next hidden-xs">
                                                                <?php $topic->getTopicCategory($row['id']); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- POST -->

                                    <?php
                                    }
                                } else { ?>
                                    <!-- POST Not Found -->
                                    <div class="post">
                                        <div class="wrap-ut not-found">
                                            <div class="posttext">
                                                No hay publicaciones ni preguntas para mostrar.
                                            </div>
                                            <div class="right">
                                            <button class="btn btn-primary" data-toggle="collapse" data-target="#newtopicWrap" control-id="ControlID-1" aria-expanded="true">Crear publicación</button>
                                            </div>
                                        </div>
                                    </div><!-- End POST Not Found-->
                            <?php 
                                    }    
                                }
                            } ?>
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

<?php 

require('require/footer.php');
