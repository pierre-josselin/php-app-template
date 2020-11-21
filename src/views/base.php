<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="/libraries/bootswatch/4.5.3/<?= Configuration::STYLE ?>/bootstrap.min.css">
        <link rel="stylesheet" href="/libraries/fontawesome/5.15.1/css/all.min.css">
        <title><?= $title ?> | <?= Configuration::BRAND ?></title>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a href="/" class="navbar-brand"><?= Configuration::BRAND ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbar" class="collapse navbar-collapse">
                <div class="ml-auto">
                    <a href="/sign-in" class="btn btn-sm btn<?php if(constant("PATH") != "/sign-in") echo "-outline"; ?>-light">connexion</a>
                    <a href="/sign-up" class="btn btn-sm btn<?php if(constant("PATH") != "/sign-up") echo "-outline"; ?>-light ml-3">inscription</a>
                </div>
            </div>
        </nav>
        <?= $content ?>
        <script src="/libraries/jquery/3.5.1/jquery.min.js"></script>
        <script src="/libraries/bootstrap/4.5.3/js/bootstrap.bundle.min.js"></script>
        <script src="/libraries/bootbox/5.4.0/bootbox.all.min.js"></script>
    </body>
</html>