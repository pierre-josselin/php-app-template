<?php $title = "Paramètres"; ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require("{$root}/views/alerts.php"); ?>
            <div id="edit-personal-informations" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/account/update" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Informations personnelles</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="firstName">Prénom</label>
                                <input id="firstName" name="firstName" value="<?= $account["firstName"] ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lastName">Nom</label>
                                <input id="lastName" name="lastName" value="<?= $account["lastName"] ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="gender">Genre</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="" <?php if(!$account["gender"]) echo "selected"; ?>>-</option>
                                    <option value="male" <?php if($account["gender"] === "male") echo "selected"; ?>>Homme</option>
                                    <option value="female" <?php if($account["gender"] === "female") echo "selected"; ?>>Femme</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Adresse e-mail</label>
                                <input id="email" name="email" value="<?= $account["email"] ?>" type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Numéro de téléphone</label>
                                <input id="phone" name="phone" value="<?= $account["phone"] ?>" type="tel" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="birthDate">Date de naissance</label>
                                <input id="birthDate" name="birthDate" value="<?= $account["birthDate"] ?>" type="date" min="1900-01-01" max="<?= date("Y-m-d") ?>" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link active" data-toggle="pill" href="#settings-account">Compte</a>
                        <a class="nav-link" data-toggle="pill" href="#settings-authentication">Authentification</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="settings-account" class="tab-pane active">
                            <h5>Détails du compte</h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3">Identifiant</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= $account["_id"] ?></dd>
                                <dt class="col-lg-3">Date d'inscription</dt>
                                <dd class="col-lg-9 text-monospace"><?= date("d/m/Y H:i", $account["registrationTime"]) ?></dd>
                            </dl>
                            <h5>Informations personnelles</h5><hr>
                            <div class="mb-3">
                                <a href="#" class="text-danger" data-toggle="modal" data-target="#edit-personal-informations">modifier</a>
                            </div>
                            <dl class="row">
                                <dt class="col-lg-3">Prénom</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["firstName"] ? $account["firstName"] : "-") ?></dd>
                                <dt class="col-lg-3">Nom</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["lastName"] ? $account["lastName"] : "-") ?></dd>
                                <dt class="col-lg-3">Genre</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["gender"] ? $genders[$account["gender"]] : "-") ?></dd>
                                <dt class="col-lg-3">Adresse e-mail</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["email"] ? $account["email"] : "-") ?></dd>
                                <dt class="col-lg-3">Numéro de téléphone</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["phone"] ? $account["phone"] : "-") ?></dd>
                                <dt class="col-lg-3">Date de naissance</dt>
                                <dd class="col-lg-9 text-monospace"><?= ($account["birthDate"] ? date("d/m/Y", strtotime($account["birthDate"])) : "-") ?></dd>
                            </dl>
                        </div>
                        <div id="settings-authentication" class="tab-pane">
                            <h5>Méthodes d'authentification</h5><hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>