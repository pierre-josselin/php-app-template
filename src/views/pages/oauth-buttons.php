<?php if(Configuration::OAUTH_AUTHENTICATION_METHODS): ?>
    <?php foreach(array_keys(Configuration::OAUTH_AUTHENTICATION_METHODS) as $index => $key): ?>
        <a href="<?= htmlspecialchars(constant(strtoupper($key) . "_SIGN_IN_URL")) ?>" class="btn btn-<?= $key ?> w-100
        <?php if($index < count(Configuration::OAUTH_AUTHENTICATION_METHODS) - 1) echo "mb-3"; ?>"><?= ucfirst($localization->getText("continue_with")) ?> <?= ucfirst($key) ?></a>
    <?php endforeach; ?>
    <hr>
<?php endif; ?>