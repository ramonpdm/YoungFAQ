<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Foro | YoungFAQ</title>

        <!-- CSS -->
        <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min2.css">
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
    
                        <div class="col  avt">
                            <div class="avatar pull-right dropdown">
                                
                                <a data-toggle="dropdown" href="#">
                                    <?php $user = new User(false); $user->getUserName();  ?>
                                    <img src="/assets/images/avatar.png" alt="">
                                </a> <b class="caret"></b>
                                
                                <ul class="dropdown-menu" role="menu">
                                    <?php if ($user->isLogged()) : ?>
                                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/logout<?php getSlug('logout'); ?>">Cerrar Sesión</a></li>
                                    <?php else : ?>   
                                    <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a></li>
                                    <li role="presentation"><a role="menuitem" tabindex="-2" data-toggle="modal" data-target="#registerModal">Registrarse</a></li>
                                    <?php endif; ?>   
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div><!-- End Header -->
            
            <?php if (!$user->isLogged()) : ?>

            <!-- Login Modal -->
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                            <button tabindex="-3" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form role="form" id="loginForm">
                            <div class="modal-body">
                                <div id="loginResponse">
                                </div>
                                
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Usuario" type="text" id="username" name="username" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Contraseña" type="password" id="password" name="password" required>
                                        </div>
                                    </fieldset>
                                
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="action" value="login">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="loginBtn" type="submit" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i> Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- End Login Modal -->

            <!-- Register Modal -->
            <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="display: flex; align-items: center; justify-content: space-between;">
                            <h5 class="modal-title" id="registerModalLabel">Crear una cuenta</h5>
                            <button tabindex="-3" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form role="form" id="registerForm">
                            <div class="modal-body">
                                <div id="registerResponse">
                                </div>
                                    <fieldset>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Usuario" type="text" id="usernameReg" name="username" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Nombre completo" type="text" id="fullnameReg" name="fullname" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Correo electrónico" type="email" id="emailReg" name="email" autofocus required>
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" placeholder="Contraseña" type="password" id="passwordReg" name="password" required>
                                        </div>
                                </fieldset>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="action" value="register">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button id="registerBtn" type="submit" type="button" class="btn btn-primary"><i class="fa fa-sign-in"></i> Registrarse</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> <!-- End Register Modal -->

            <?php endif; ?>
