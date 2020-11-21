<?php $title = "Connexion"; ?>
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
            <form action="/actions/sign-in" method="post">
                <div class="form-group">
                    <label for="email">Adresse e-mail</label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>