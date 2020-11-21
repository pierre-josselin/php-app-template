<?php $title = "Accueil"; ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <div>Hello world !</div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>