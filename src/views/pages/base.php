<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/libraries/bootswatch/4.5.3/<?= Configuration::STYLE ?>/bootstrap.min.css">
        <link rel="stylesheet" href="/libraries/fontawesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="/css/global.css">
        <title><?= $title ?> | <?= Configuration::BRAND ?></title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="/" class="navbar-brand"><?= Configuration::BRAND ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">
                <?php if(constant("ACCOUNT_ID")): ?>
                    <ul class="navbar-nav mr-auto">
                        <?php foreach(Configuration::NAVIGATION as $path => $id): ?>
                            <li class="nav-item <?php if(constant("PATH") === $path) echo "active"; ?>">
                                <a href="<?= $path ?>" class="nav-link"><?= ucfirst($localization->getText($id)) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <span class="text-light mr-4">
                        <?php
                            if(constant("ACCOUNT")["firstName"] || constant("ACCOUNT")["lastName"]) {
                                echo htmlentities(constant("ACCOUNT")["firstName"] . " " . constant("ACCOUNT")["lastName"]);
                            } elseif(constant("ACCOUNT")["email"]) {
                                echo htmlentities(constant("ACCOUNT")["email"]);
                            }
                        ?>
                    </span>
                    <?php if(constant("ACCOUNT")["type"] === "admin"): ?>
                        <a class="text-light mr-3" href="/dashboard" title="<?= ucfirst($localization->getText("dashboard")) ?>"><i class="fas fa-shield-alt"></i></a>
                    <?php endif; ?>
                    <a class="text-light mr-3" href="/settings" title="<?= ucfirst($localization->getText("settings")) ?>"><i class="fas fa-cog"></i></a>
                    <a class="text-light" href="/actions/sign-out" title="<?= ucfirst($localization->getText("sign_out")) ?>"><i class="fas fa-sign-out-alt"></i></a>
                <?php else: ?>
                    <div class="ml-auto">
                        <a href="/sign-in" class="btn btn-sm btn<?php if(constant("PATH") !== "/sign-in") echo "-outline"; ?>-light"><?= $localization->getText("sign_in") ?></a>
                        <a href="/sign-up" class="btn btn-sm btn<?php if(constant("PATH") !== "/sign-up") echo "-outline"; ?>-light ml-3"><?= $localization->getText("sign_up") ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </nav>
        <?= $content ?>
        <script src="/libraries/jquery/3.5.1/jquery.min.js"></script>
        <script src="/libraries/bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
        <script src="/libraries/bootbox/5.4.0/bootbox.all.min.js"></script>
        <script src="/js/utils.js"></script>
        <script src="/js/global.js"></script>
    </body>
</html>