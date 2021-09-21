<?php   include 'core/init.php'; 
$topic_id = $_GET['id'];
if (isset($topic_id)){
        include 'require/header.php'; ?>

        <section class="content">
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8">

                        <?php
                        $query = new database();
                        $query->select("topics", "*", "id = $topic_id");
                        $result = $query->sql;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="post">
                                <div class="topwrap">
                                    <div class="userinfo pull-left">
                                        <div class="avatar">
                                            <img src="/images/avatar.jpg" alt="">
                                        </div>

                                        <div class="icons">
                                            <img src="/images/icon1.jpg" alt=""><img src="/images/icon4.jpg" alt=""><img src="/images/icon5.jpg" alt=""><img src="/images/icon6.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="posttext pull-left">
                                        <h2><?php echo $row['title']; ?></h2>
                                        <p><?php echo $row['content']; ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                              
                                <div class="postinfobot">

                                    <div class="posted pull-left"><i class="fa fa-clock-o"></i> 
                                    Publicado el: <?php echo date('d M Y @ h:m A', strtotime($row['date_created'])); ?>
                                </div>

                                    <div class="next pull-right">                                        
                                        <a href="#"><i class="fa fa-share"></i></a>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <hr>
                            <?php
                            }
                        } else { ?>

                            <div class="post">
                                <div class="wrap-ut not-found">
                                    <div class="posttext">
                                        No hay temas ni discusiones para mostrar.
                                    </div>
                                    <div class="right">
                                        <button class="btn btn-primary" control-id="ControlID-3">Crear tema</button>
                                    </div>
                                </div>

                            </div>

                        <?php } ?>

                        <?php
                        $query = new database();
                        $query->select("comments", "*", "id_topic = $topic_id");
                        $result = $query->sql;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <div class="post">
                                <div class="topwrap">
                                    <div class="userinfo pull-left">
                                        <div class="avatar">
                                            <img src="/images/avatar.jpg" alt="">
                                        </div>

                                        <div class="icons">
                                            <img src="/images/icon1.jpg" alt=""><img src="/images/icon4.jpg" alt=""><img src="/images/icon5.jpg" alt=""><img src="/images/icon6.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="posttext pull-left">
                                        <p><?php echo $row['content']; ?></p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                              
                                <div class="postinfobot">

                                    <div class="posted pull-left"><i class="fa fa-clock-o"></i> 
                                    Publicado el: <?php echo date('d M Y @ h:m A', strtotime($row['date_created'])); ?>
                                </div>

                                    <div class="next pull-right">                                        
                                        <a href="#"><i class="fa fa-share"></i></a>
                                    </div>

                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <hr>
                            <?php
                            }
                        }?>

                        <div class="post">
                                <form action="#" class="form" method="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="/images/avatar4.jpg" alt="">
                                            </div>

                                            <div class="icons">
                                                <img src="/images/icon3.jpg" alt=""><img src="/images/icon4.jpg" alt=""><img src="/images/icon5.jpg" alt=""><img src="/images/icon6.jpg" alt="">
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
                            </div>

                    </div>
                    <div class="col-lg-4 col-md-4">
                    <?php
                        $query = new database();
                        $query->select("categories", "*");
                        $result = $query->sql;
                        if (mysqli_num_rows($result) > 0) {
                            
                        ?>
                        <!-- -->
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
                        </div>
                        <?php } ?>

                        <!-- -->
                        <div class="sidebarblock">
                            <h3>Mis Publicaciones</h3>
                            <div class="divline"></div>
                            <div class="blocktxt">
                                <a href="#">This Dock Turns Your iPhone Into a Bedside Lamp</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-1 col-xs-3 col-sm-2 logo "><a href="#"><img src="/images/logo.png" alt=""></a></div>
                    <div class="col-lg-8 col-xs-9 col-sm-5 ">Copyrights 2021 YoungFAQ</div>
                    <div class="col-lg-3 col-xs-12 col-sm-5 sociconcent">
                        <ul class="socialicons">
                            <li><a href="#"><i class="fa fa-facebook-square"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-cloud"></i></a></li>
                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- get jQuery from the google apis -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.js"></script>


    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="/js/jquery.themepunch.revolution.min.js"></script>

    <script src="/js/bootstrap.min.js"></script>


    <!-- LOOK THE DOCUMENTATION FOR MORE INFORMATIONS -->
    <script type="text/javascript">
        var revapi;

        jQuery(document).ready(function() {
            "use strict";
            revapi = jQuery('.tp-banner').revolution({
                delay: 15000,
                startwidth: 1200,
                startheight: 278,
                hideThumbs: 10,
                fullWidth: "on"
            });

        }); //ready
    </script>

    <!-- END REVOLUTION SLIDER -->

</body>

</html>
<?php } ?>