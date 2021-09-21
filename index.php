<?php   include 'core/init.php'; 
        include 'require/header.php'; ?>

        <section class="content">
            <br>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-md-8">
<!-- Buttons -->
                                <div class="btn-options row">
                                    <div class="col-sm-2 col-xs-3">
                                        <div class="postadd ">
                                            <button class="btn btn-primary" control-id="ControlID-3" data-toggle="collapse" data-target="#newtopic">Crear tema</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-10 col-xs-9 search">
                                        <div class="wrap">
                                            <form action="#" method="post" class="form">
                                                <div class="pull-left txt">
                                                    <input type="text" class="form-control" placeholder="Buscar temas" control-id="ControlID-1">
                                                </div>
                                                <div class="pull-right">
                                                    <button class="btn btn-default" type="button" control-id="ControlID-2" >
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </div>
                                                <div class="clearfix"></div>
                                            </form>
                                        </div>
                                    </div>

                                </div><!-- POST -->
                                <div class="post collapse" id="newtopic">
                                <form action="#" class="form newtopic" method="post">
                                    <div class="topwrap">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="images/avatar4.jpg" alt="">
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon3.jpg" alt=""><img src="images/icon4.jpg" alt=""><img src="images/icon5.jpg" alt=""><img src="images/icon6.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="posttext pull-left">

                                            <div>
                                                <input type="text" placeholder="Escribe el título del tema" name="title" class="form-control" control-id="ControlID-4">
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <input placeholder="Elige una categoría..." list="categories" name="category" class="form-control" control-id="ControlID-5">
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
                                                        <textarea name="content" id="content" placeholder="Contenido" class="form-control" control-id="ControlID-7"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                    </div>                              
                                    <div class="postinfobot">

                                        <div class="notechbox pull-left">
                                            <input type="checkbox" name="note" id="note" class="form-control" control-id="ControlID-13">
                                        </div>

                                        <div class="pull-left">
                                            <label for="note"> Email me when some one post a reply</label>
                                        </div>

                                        <div class="pull-right postreply">
                                            <div class="pull-left smile"><a href="#"><i class="fa fa-smile-o"></i></a></div>
                                            <div class="pull-left"><button type="submit" class="btn btn-primary" control-id="ControlID-14">Post</button></div>
                                            <div class="clearfix"></div>
                                        </div>


                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div>
                        <?php
                        $query = new database();
                        $query->select("topics", "*");
                        $result = $query->sql;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                                

                                <!-- POST -->
                                <div class="post">
                                    <div class="wrap-ut pull-left">
                                        <div class="userinfo pull-left">
                                            <div class="avatar">
                                                <img src="images/avatar.jpg" alt="">
                                                
                                            </div>

                                            <div class="icons">
                                                <img src="images/icon1.jpg" alt=""><img src="images/icon4.jpg" alt="">
                                            </div>
                                        </div>
                                        <div class="posttext pull-left">
                                        <h2><a href="/topic/<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></h2>
                                            <p><?php echo $row['content']; ?></p>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="postinfo pull-left hidden-xs ">
                                        <div class="comments">
                                            <div class="commentbg">
                                            <?php echo $row['comments']; ?>
                                                <div class="mark"></div>
                                            </div>

                                        </div>
                                        <div class="views"><i class="fa fa-eye"></i> <?php echo $row['views']; ?></div>
                                        <div class="time"><i class="fa fa-clock-o"></i><?php echo get_ago($row['date_created']); ?></div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div><!-- POST -->

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
                    <div class="col-lg-1 col-xs-3 col-sm-2 logo "><a href="#"><img src="images/logo.png" alt=""></a></div>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script type="text/javascript" src="js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="js/jquery.themepunch.revolution.min.js"></script>

    <!-- END REVOLUTION SLIDER -->

</body>

</html>