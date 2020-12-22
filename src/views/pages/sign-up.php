<?php $title = ucfirst($localization->getText("title_sign_up")); ?>
<?php ob_start(); ?>
<div class="container my-5 form">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <?php if(Configuration::OAUTH_AUTHENTICATION_METHODS): ?>
                <?php foreach(array_keys(Configuration::OAUTH_AUTHENTICATION_METHODS) as $index => $key): ?>
                    <a href="<?= htmlspecialchars(constant(strtoupper($key) . "_SIGN_IN_URL")) ?>" class="btn btn-<?= $key ?> w-100
                    <?php if($index < count(Configuration::OAUTH_AUTHENTICATION_METHODS) - 1) echo "mb-3"; ?>"><?= ucfirst($localization->getText("continue_with")) ?> <?= ucfirst($key) ?></a>
                <?php endforeach; ?>
                <hr>
            <?php endif; ?>
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
                <button type="submit" class="btn btn-primary w-100"><?= ucfirst($localization->getText("to_sign_in")) ?></button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>