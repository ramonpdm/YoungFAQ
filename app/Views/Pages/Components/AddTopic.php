            <!-- New Topic -->
            <div class="collapse" id="newtopicWrap">
                <div class="response">
                </div>
                <div class="post newtopic container-fluid">
                    <form role="form" id="newtopicForm" class="form newtopic">
                        <div class="wrap-ut">
                            <div class="posttext">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="text" placeholder="Escribe el título de la publicación" id="title" name="title" class="form-control" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input placeholder="Elige una categoría..." list="categories" id="category" name="category" class="form-control" autocomplete="off">
                                        <?php //$user->getCategories(true); 
                                        ?>
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
                                    <button id="newtopicBtn" type="submit" class="btn btn-primary">Publicar</button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End New Topic -->