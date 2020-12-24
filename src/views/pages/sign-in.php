<?php $title = ucfirst($localization->getText("title_sign_in")); ?>
<?php ob_start(); ?>
<div class="container my-5 form">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <?php require(Configuration::ROOT . "/views/pages/oauth-buttons.php"); ?>
            <form action="/actions/sign-in" method="post">
                <div class="form-group">
                    <label for="email"><?= ucfirst($localization->getText("email")) ?></label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password"><?= ucfirst($localization->getText("password")) ?></label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= ucfirst($localization->getText("to_sign_in")) ?></button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>