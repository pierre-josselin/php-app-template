<?php $title = ucfirst($localization->getText("title_sign_up")); ?>
<?php ob_start(); ?>
<div class="container my-5 form">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <?php require(Configuration::ROOT . "/views/pages/oauth-buttons.php"); ?>
            <form action="/actions/sign-up" method="post">
                <div class="form-group">
                    <label for="email"><?= ucfirst($localization->getText("email")) ?></label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password"><?= ucfirst($localization->getText("password")) ?></label>
                    <input id="password" type="password" name="password" minlength="6" maxlength="128" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password-confirmation"><?= ucfirst($localization->getText("password_confirmation")) ?></label>
                    <input id="password-confirmation" type="password" minlength="6" maxlength="128" class="form-control" onchange="utils.checkPasswordConfirmation(this);" required>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input id="privacy-policy" type="checkbox" class="custom-control-input" required>
                    <label for="privacy-policy" class="custom-control-label"><?= ucfirst($localization->getText("i_accept_the")) ?></a> <a href="/privacy-policy" target="_blank"><?= $localization->getText("privacy_policy") ?></a>.</label>
                </div>
                <button type="submit" class="btn btn-primary w-100"><?= ucfirst($localization->getText("to_sign_up")) ?></button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>