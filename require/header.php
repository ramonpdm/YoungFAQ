<?php session_start(); ?>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Foro | YoungFAQ</title>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/main.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/color.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="/assets/css/settings.css">

        <!-- Fonts -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">

    </head>
    <body>
        <div class="container-fluid">
            
            <!-- Header -->
            <div class="headernav">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1 col-xs-3 col-sm-2 col-md-2 logo ">
                            <a href="/"><img src="/assets/images/logo.png" alt=""></a>
                        </div>
                        <div class="col-lg-7 col-xs-4 col-sm-5 col-md-6 selecttopic">
                            <div class="dropdown">
                                <a href="/">YoungFAQ</a>
                            </div>
                        </div>
    
                        <div class="col-lg-4 col-sm-5 col-md-4 avt">
                            <div class="avatar pull-right dropdown">
                                <a data-toggle="dropdown" href="#"><img src="/assets/images/avatar.png" alt=""></a> <b class="caret"></b>
                                
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Mi Perfil</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-" href="/logout">Cerrar Sesión</a></li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div><!-- End Header -->
            
            <?php if (!isset($_SESSION['user'])) : ?>

            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;
">
                        <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
		    			<div id="loginResponse">
					    </div>
                        <form role="form" id="loginForm">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Usuario" type="text" id="username" name="username" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Contraseña" type="password" id="password" name="password" required>
                                </div>
                                <button id="loginBtn" type="submit"  class="btn btn-lg btn-primary btn-block">
                                    <i class="fa fa-sign-in"></i> Login</button>
                            </fieldset>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Entrar</button>
                    </div>
                    </div>
                </div>
            </div><!-- End Login Modal -->

            <!-- Register Modal -->
            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div> <!-- End Register Modal -->

            <?php endif; ?>
