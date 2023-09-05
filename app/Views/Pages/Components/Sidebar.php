<?php if (!App\Models\User::isLogged()) : ?>
<?= $this->renderView('Pages/Components/Widgets/Buttons') ?>
<?php endif ?>

<?php if (App\Models\User::isLogged()) : ?>
<?= $this->renderView('Pages/Components/Widgets/UserTopics') ?>
<?php endif ?>

<?= $this->renderView('Pages/Components/Widgets/Categories') ?>

<?php 

// $user->getRefusedPosts(); 
