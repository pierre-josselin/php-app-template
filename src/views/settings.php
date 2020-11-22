<?php $title = "Paramètres"; ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require("{$root}/views/alerts.php"); ?>
            <div id="update-personal-informations-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-personal-informations" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Informations personnelles</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Prénom</label>
                                <input name="first-name" value="<?= htmlentities($settingsAccount["firstName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nom</label>
                                <input name="last-name" value="<?= htmlentities($settingsAccount["lastName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Genre</label>
                                <select name="gender" class="form-control">
                                    <option value="" <?php if(!$settingsAccount["gender"]) echo "selected"; ?>>-</option>
                                    <option value="male" <?php if($settingsAccount["gender"] === "male") echo "selected"; ?>>Homme</option>
                                    <option value="female" <?php if($settingsAccount["gender"] === "female") echo "selected"; ?>>Femme</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Adresse e-mail</label>
                                <input name="email" value="<?= $settingsAccount["email"] ?>" type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Numéro de téléphone</label>
                                <input name="phone" value="<?= htmlentities($settingsAccount["phone"]) ?>" type="tel" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Date de naissance</label>
                                <input name="birth-date" value="<?= $settingsAccount["birthDate"] ?>" type="date" min="1900-01-01" max="<?= date("Y-m-d") ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Adresse</label>
                                <input name="street" value="<?= $settingsAccount["address"]["street"] ?>" type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Code postal</label>
                                        <input name="postal-code" value="<?= $settingsAccount["address"]["postalCode"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Ville</label>
                                        <input name="city" value="<?= $settingsAccount["address"]["city"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Pays</label>
                                <input name="country" value="<?= $settingsAccount["address"]["country"] ?>" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="update-email-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-email" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Adresse e-mail</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Adresse e-mail</label>
                                <input name="email" value="<?= $settingsEmailAuthenticationMethod["email"] ?>" type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="update-password-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-password" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title">Mot de passe</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Mot de passe actuel</label>
                                <input name="password" type="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nouveau mot de passe</label>
                                <input id="password" name="new-password" type="password" minlength="6" maxlength="128" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirmation du nouveau mot de passe</label>
                                <input type="password" minlength="6" maxlength="128" class="form-control" onchange="utils.checkPasswordConfirmation(this);" required>
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
                        <a class="nav-link active" data-toggle="pill" href="#settings-account-tab">Compte</a>
                        <a class="nav-link" data-toggle="pill" href="#settings-authentication-tab">Authentification</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="settings-account-tab" class="tab-pane active">
                            <h5>Détails du compte</h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3">Identifiant</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= $settingsAccount["_id"] ?></dd>
                                <dt class="col-lg-3">Date d'inscription</dt>
                                <dd class="col-lg-9 text-monospace"><?= date("d/m/Y H:i", $settingsAccount["registrationTime"]) ?></dd>
                            </dl>
                            <h5>Informations personnelles</h5><hr>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#update-personal-informations-modal">modifier</a>
                            <dl class="row mt-3">
                                <dt class="col-lg-3">Prénom</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["firstName"] ? htmlentities($settingsAccount["firstName"]) : "-") ?></dd>
                                <dt class="col-lg-3">Nom</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["lastName"] ? htmlentities($settingsAccount["lastName"]) : "-") ?></dd>
                                <dt class="col-lg-3">Genre</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["gender"] ? $genders[$settingsAccount["gender"]] : "-") ?></dd>
                                <dt class="col-lg-3">Adresse e-mail</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["email"] ? $settingsAccount["email"] : "-") ?></dd>
                                <dt class="col-lg-3">Numéro de téléphone</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["phone"] ? htmlentities($settingsAccount["phone"]) : "-") ?></dd>
                                <dt class="col-lg-3">Date de naissance</dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["birthDate"] ? date("d/m/Y", strtotime($settingsAccount["birthDate"])) : "-") ?></dd>
                                <dt class="col-lg-3">Adresse</dt>
                                <dd class="col-lg-9 text-monospace">
                                    <?= $settingsAccount["address"]["street"] ?>
                                    <?= $settingsAccount["address"]["postalCode"] ?>
                                    <?= $settingsAccount["address"]["city"] ?>
                                    <?= $settingsAccount["address"]["country"] ?>
                                </dd>
                            </dl>
                            <a href="javascript: settings.deleteAccount();" class="text-danger mt-4">supprimer le compte</a>
                        </div>
                        <div id="settings-authentication-tab" class="tab-pane">
                            <h5>Méthodes d'authentification</h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3">Email</dt>
                                <dd class="col-lg-9 text-monospace mb-3">
                                    <?php if($settingsEmailAuthenticationMethod): ?>
                                        <?= $settingsEmailAuthenticationMethod["email"] ?>
                                        <a href="#" class="text-danger ml-3" data-toggle="modal" data-target="#update-email-modal">mettre à jour</a><br>
                                        <a href="#" class="text-danger" data-toggle="modal" data-target="#update-password-modal">modifier le mot de passe</a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </dd>
                                <?php foreach(array_keys($oauthAuthenticationMethods) as $index => $key): ?>
                                    <dt class="col-lg-3"><?= ucfirst($key) ?></dt>
                                    <dd class="col-lg-9 text-monospace <?php if($index < count($oauthAuthenticationMethods) - 1) echo "mb-3"; ?>">
                                        <?php if(isset($settingsOAuthAuthenticationMethods[$key])): ?>
                                            <?= ($settingsOAuthAuthenticationMethods[$key]["name"] ?
                                            $settingsOAuthAuthenticationMethods[$key]["name"] :
                                            $settingsOAuthAuthenticationMethods[$key]["id"]) ?>
                                            <a href='javascript: settings.unlinkOauth(<?= json_encode($key) ?>);' class="text-danger ml-3">déconnecter</a>
                                        <?php else: ?>
                                            <a href="<?= htmlspecialchars($oauthAuthenticationMethods[$key]["signInUrl"]) ?>">connecter</a>
                                        <?php endif; ?>
                                    </dd>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/settings.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require("{$root}/views/base.php"); ?>