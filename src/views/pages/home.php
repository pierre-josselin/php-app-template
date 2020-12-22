<?php $title = ucfirst($localization->getText("title_home")); ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>