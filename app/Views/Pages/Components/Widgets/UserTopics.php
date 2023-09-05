<?php

use App\Core\Exceptions\DatabaseException;
use App\Models\User;

use function App\Core\Functions\getAgo;

try {
    $user = User::session();
    $topics = $user->getUserTopics();
} catch (DatabaseException $e) {
    $this->app_exceptions[] = $e;
}
?>

<!-- Start User Posts Widget -->
<div class="sidebarblock">
    <h3>Mis Publicaciones</h3>

    <div class="divline"></div>
    <?php if (!empty($topics)) : ?>

        <?php foreach ($topics as $topic) : ?>
            <div class="blocktxt">
                <span class="title"><a href="/forum?topic="><?= $topic->getTitle() ?></a></span> <br>
                <span style="color: var(--thm-gray-1);"><i class="fa fa-clock-o"> </i> <?= getAgo($topic->getCreatedAt()); ?></span>
            </div>
            <div class="divline"></div>
        <?php endforeach ?>

    <?php else : ?>

        <div class="blocktxt">
            <span>No tienes ninguna publicación, </span><a href="javascript:void(0);" data-toggle="collapse" data-target="#newtopicWrap">crea</a> una.
        </div>
    <?php endif ?>

</div>
<!-- End User Posts Widget -->