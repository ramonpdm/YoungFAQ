<?= $this->renderView('Templates/Header') ?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 breadcrumbf">
                <a href="/">Inicio</a>
            </div>
            <div class="col-lg-8 col-md-8">

                <!-- Buttons -->
                <div class="btn-options container-fluid mb-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="wrap">
                                <input id="searchInput" type="text" class="form-control" placeholder="Buscar publicaciones...">
                                <button class="btn btn-default search" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                                <?php if (\App\Models\User::isLogged()) : ?>
                                    <button class="btn btn-primary addtopic" data-toggle="collapse" data-target="#newtopicWrap">Crear publicación</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Buttons -->

                <?php if (\App\Models\User::isLogged()) echo $this->renderView('Pages/Components/AddTopic') ?>

                <div id="searchResponse"></div>

                <?= $this->renderView('Pages/Components/Topic', ['topic' =>  $topic, 'comments' =>  $comments]) ?>

            </div>

            <div class="col-lg-4 col-md-4">
                <?= $this->renderView('Pages/Components/Sidebar') ?>
            </div>

        </div>
    </div>
</section>
<?= $this->renderView('Templates/Footer') ?>