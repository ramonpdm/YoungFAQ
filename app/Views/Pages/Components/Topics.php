  <!-- Start Topic -->
  <?php if (!empty($topics)) : ?>
      <?php foreach ($topics as $topic) :    ?>
          <div class="post container-fluid">
              <div class="wrap-ut" id="postcontent">

                  <div class="row">
                      <div class="col-sm-10 full-col">
                          <div class="posttext" style="overflow: hidden;">
                              <h2><a href="<?= APP_URL ?>/topic?id=<?= $topic->getID(); ?>"><?= $topic->getTitle(); ?></a></h2>
                              <p style="max-height: 100px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?= $topic->getContent(); ?></p>
                          </div>
                      </div>
                      <div class="col-sm-2 d-none d-sm-none d-xs-none d-sm-flex d-md-flex d-flex-j-center-a-center" style="border-left: solid 1px #f1f1f1;">
                          <div class="postinfo" id="postinfo">
                              <div class="comments">
                                  <div class="commentbg">
                                      <?= $topic->getCommentsCount() ?>
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
                                  <div class="avatar">
                                      <img src="/YoungFAQ/public/images/avatar.png" alt="Profile pic" class="d-none d-xs-none d-sm-none d-lg-block">
                                      <?= App\Helpers\UserPresentation::username($topic->getAuthor()); ?>
                                  </div>
                                  <span class="time flex-m">
                                      <i class="fa fa-clock-o"></i>
                                      <?= App\Core\Functions\getAgo($topic->getCreatedAt()); ?>
                                  </span>
                              </div>
                              <div class="next d-none d-sm-block d-sm-none d-md-block">
                                  <?= App\Helpers\TopicPresentation::categories($topic->getCategories()) ?>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      <?php endforeach ?>

  <?php else : ?>

      <div class="post">
          <div class="wrap-ut not-found">
              <div class="posttext">
                  No hay publicaciones ni preguntas para mostrar.
              </div>
              <div class="right">
                  <?php if (App\Models\User::isLogged()) : ?>
                      <button class="btn btn-primary" data-toggle="collapse" data-target="#newtopicWrap">Crear publicación</button>
                  <?php else : ?>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Iniciar Sesión</button>
                      <div class="separator"></div>
                      <button class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">Registarse</button>
                  <?php endif ?>
              </div>
          </div>
      </div>
  <?php endif ?>


  <?php if (isset($error)) : ?>
      <div class="post">
          <div class="wrap-ut not-found">
              <div class="posttext">
                  <h2>Ha habido un error</h2>
                  <p class="text-danger"><?= $error ?></p>
              </div>

          </div>
      </div>
  <?php endif ?>

  <!-- End Topic -->