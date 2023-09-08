<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Foro | YoungFAQ</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="public/css/main.css">
    <link rel="stylesheet" type="text/css" href="public/css/util.css">
    <link rel="stylesheet" type="text/css" href="public/css/color.css">
    <link rel="stylesheet" type="text/css" href="public/css/responsive.css">

    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="public/vendor/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

</head>

<body>
    <div class="container-fluid">

        <!-- Start Header -->
        <div class="headernav">
            <div class="container">
                <div class="row">
                    <div class="col logo">
                        <a href="<?= APP_URL ?>/"><img src="public/images/logo.png" alt=""></a>
                    </div>
                    <div class="col-lg-8 col-xs-4 col-sm-5 col-md-6 d-none d-sm-block d-sm-none d-md-block selecttopic">
                        <a href="<?= APP_URL ?>/">YoungFAQ</a>
                    </div>
                    <div class="col avt">
                        <div class="avatar pull-right h-100">
                            <span class="user" data-toggle="dropdown">
                                <?= App\Helpers\UserPresentation::FullName(App\Models\User::session()); ?>
                                <img class="pic" src="public/images/avatar.png" alt="Profile picture">
                                <i class="fa fa-caret-down"></i>
                            </span>

                            <ul class="dropdown-menu" role="menu">
                                <?php if (App\Models\User::isLogged()) : ?>
                                    <a class="dropdown-item" role="menuitem" tabindex="-1" href="<?= APP_URL ?>/profile<">Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="menuitem" tabindex="-2" href="<?= APP_URL ?>/logout">Cerrar Sesión</a>
                                <?php else : ?>
                                    <a class="dropdown-item" role="menuitem" tabindex="-1" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</a>
                                    <a class="dropdown-item" role="menuitem" tabindex="-2" data-toggle="modal" data-target="#registerModal">Registrarse</a>
                                <?php endif ?>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Header -->

        <?php if (!App\Models\User::isLogged()) : ?>
            <?= $this->renderView('Pages/Components/Modals/Login') ?>
            <?= $this->renderView('Pages/Components/Modals/Register') ?>
        <?php endif ?>