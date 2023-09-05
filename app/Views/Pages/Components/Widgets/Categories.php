<?php

use App\Core\Exceptions\DatabaseException;
use App\Repositories\Category;

try {
    $categoryRepo = new Category();
    $categories = $categoryRepo->findAll();
} catch (DatabaseException $e) {
    $this->app_exceptions[] = $e;
}
?>

<?php if (!empty($categories)) : ?>
    <datalist id="categories">
        <?php foreach ($categories as $category) : ?>
            <option value="<?= $category->getName() ?>">
            <?php endforeach ?>
    </datalist>
<?php endif ?>

<!-- Start Categories Widget -->
<div class="sidebarblock">
    <h3>Categorías</h3>
    <div class="divline"></div>
    <div class="blocktxt">
        <ul class="cats">
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <li><a href="/archive?category=" class="w-100 d-flex justify-content-between align-items-center"><span><?= $category->getName() ?></span><span class="badge"><?= $category->getTopicsCount() ?></span></a></li>
                <?php endforeach ?>
            <?php else : ?>
                <li><span>No hay categorias</span></li>
            <?php endif ?>
        </ul>
    </div>
</div>
<!-- End Categories Widget -->