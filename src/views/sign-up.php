<?php $title = "Inscription"; ?>
<?php ob_start(); ?>
<div class="container my-5 form">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require("{$root}/views/alerts.php"); ?>
            <?php if(isset(Configuration::AUTHENTICATION_METHODS["facebook"])): ?>
                <a href="<?= htmlspecialchars($facebookLoginUrl) ?>" class="btn btn-facebook w-100 mb-3">Continuer avec Facebook</a>
            <?php endif; ?>
            <?php if(isset(Configuration::AUTHENTICATION_METHODS["keyrock"])): ?>
                <a href="<?= htmlspecialchars($keyrockLoginUrl) ?>" class="btn btn-keyrock w-100 mb-3">Continuer avec Keyrock</a>
            <?php endif; ?>
            <hr>
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
                    <input id="password-confirmation" type="password" minlength="6" maxlength="128" class="form-control" onchange="checkPasswordConfirmation(this);" required>
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
<script src="/js/sign-up.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>