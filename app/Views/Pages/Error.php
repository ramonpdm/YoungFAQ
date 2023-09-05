<?php echo $this->renderView('Templates/Header') ?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 breadcrumbf">
                <a href="/">Inicio</a>
            </div>
            <div class="col-lg-8 col-md-8">

                <div class="post">
                    <div class="wrap-ut not-found">
                        <div class="posttext">
                            <h2>Ha habido un error</h2>
                            <p class="text-danger"><?= $error ?></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4">
                <?php  // $user->getPendingPosts(); 
                ?>
                <?php  // $user->getRefusedPosts(); 
                ?>
                <?php  // $user->getCategories(); 
                ?>
                <?php  // $user->getUserPost(); 
                ?>
            </div>

        </div>
    </div>
</section>
<?php echo $this->renderView('Templates/Footer') ?>