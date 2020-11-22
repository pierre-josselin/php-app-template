<?php $title = "Développement"; ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require("{$root}/views/alerts.php"); ?>
            <form action="/actions/development" method="post" enctype="multipart/form-data">
                <div class="custom-file">
                    <input id="file" type="file" name="file" class="custom-file-input">
                    <label for="file" class="custom-file-label">Choisir un fichier</label>
                </div>
                <button type="submit" class="btn btn-primary mt-4">Envoyer</button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>