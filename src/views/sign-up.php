<?php $title = "Inscription"; ?>
<?php ob_start(); ?>
<div class="container my-5 form">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require("{$root}/views/alerts.php"); ?>
            <?php if($oauthAuthenticationMethods): ?>
                <?php foreach(array_keys($oauthAuthenticationMethods) as $index => $key): ?>
                    <a href="<?= htmlspecialchars($oauthAuthenticationMethods[$key]["signInUrl"]) ?>" class="btn btn-<?= $key ?> w-100
                    <?php if($index < count($oauthAuthenticationMethods) - 1) echo "mb-3"; ?>">Continuer avec <?= ucfirst($key) ?></a>
                <?php endforeach; ?>
                <hr>
            <?php endif; ?>
            <form action="/actions/sign-up" method="post">
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" minlength="6" maxlength="128" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password-confirmation">Confirmation du mot de passe</label>
                    <input id="password-confirmation" type="password" minlength="6" maxlength="128" class="form-control" onchange="utils.checkPasswordConfirmation(this);" required>
                </div>
                <div class="form-group custom-control custom-checkbox">
                    <input id="privacy-policy" type="checkbox" class="custom-control-input" required>
                    <label for="privacy-policy" class="custom-control-label">J'accepte la <a href="/privacy-policy" target="_blank">politique de confidentialité</a>.</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>