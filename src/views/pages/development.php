<?php $title = ucfirst($localization->getText("title_development")); ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <form action="/actions/development" method="post" enctype="multipart/form-data">
                <div class="custom-file">
                    <input id="file" type="file" name="file" class="custom-file-input">
                    <label for="file" class="custom-file-label"><?= ucfirst($localization->getText("select_file")) ?></label>
                </div>
                <button type="submit" class="btn btn-primary mt-4"><?= ucfirst($localization->getText("send")) ?></button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>