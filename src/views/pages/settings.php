<?php $title = ucfirst($localization->getText("title_settings")); ?>
<?php ob_start(); ?>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <div id="update-personal-informations-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-personal-informations" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= ucfirst($localization->getText("personal_informations")) ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("first_name")) ?></label>
                                <input name="first-name" value="<?= htmlentities($settingsAccount["firstName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("last_name")) ?></label>
                                <input name="last-name" value="<?= htmlentities($settingsAccount["lastName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("gender")) ?></label>
                                <select name="gender" class="form-control">
                                    <option value="" <?php if(!$settingsAccount["gender"]) echo "selected"; ?>>-</option>
                                    <option value="male" <?php if($settingsAccount["gender"] === "male") echo "selected"; ?>><?= ucfirst($localization->getText("male")) ?></option>
                                    <option value="female" <?php if($settingsAccount["gender"] === "female") echo "selected"; ?>><?= ucfirst($localization->getText("female")) ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("email")) ?></label>
                                <input name="email" value="<?= $settingsAccount["email"] ?>" type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("phone")) ?></label>
                                <input name="phone" value="<?= htmlentities($settingsAccount["phone"]) ?>" type="tel" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("birth_date")) ?></label>
                                <input name="birth-date" value="<?= $settingsAccount["birthDate"] ?>" type="date" min="1900-01-01" max="<?= date("Y-m-d") ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("address")) ?></label>
                                <input name="street" value="<?= $settingsAccount["address"]["street"] ?>" type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><?= ucfirst($localization->getText("postal_code")) ?></label>
                                        <input name="postal-code" value="<?= $settingsAccount["address"]["postalCode"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label><?= ucfirst($localization->getText("city")) ?></label>
                                        <input name="city" value="<?= $settingsAccount["address"]["city"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("country")) ?></label>
                                <input name="country" value="<?= $settingsAccount["address"]["country"] ?>" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ucfirst($localization->getText("close")) ?></button>
                            <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="update-email-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-email" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= ucfirst($localization->getText("email")) ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("email")) ?></label>
                                <input name="email" value="<?= $settingsEmailAuthenticationMethod["email"] ?>" type="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ucfirst($localization->getText("close")) ?></button>
                            <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="update-password-modal" class="modal fade" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable">
                    <form class="modal-content" action="/actions/update-password" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= ucfirst($localization->getText("password")) ?></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("current_password")) ?></label>
                                <input name="password" type="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("new_password")) ?></label>
                                <input id="password" name="new-password" type="password" minlength="6" maxlength="128" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("new_password_confirmation")) ?></label>
                                <input type="password" minlength="6" maxlength="128" class="form-control" onchange="utils.checkPasswordConfirmation(this);" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ucfirst($localization->getText("close")) ?></button>
                            <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="nav flex-column nav-pills">
                        <a class="nav-link active" data-toggle="pill" href="#settings-account-tab"><?= ucfirst($localization->getText("account")) ?></a>
                        <a class="nav-link" data-toggle="pill" href="#settings-authentication-tab"><?= ucfirst($localization->getText("authentication")) ?></a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="settings-account-tab" class="tab-pane active">
                            <h5><?= ucfirst($localization->getText("account_details")) ?></h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("identifier")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= $settingsAccount["_id"] ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("sign_up_date")) ?></dt>
                                <dd class="col-lg-9 text-monospace"><?= date("d/m/Y H:i", $settingsAccount["registrationTime"]) ?></dd>
                            </dl>
                            <h5><?= ucfirst($localization->getText("personal_informations")) ?></h5><hr>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#update-personal-informations-modal"><?= ucfirst($localization->getText("edit")) ?></a>
                            <dl class="row mt-3">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("first_name")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["firstName"] ? htmlentities($settingsAccount["firstName"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("last_name")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["lastName"] ? htmlentities($settingsAccount["lastName"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("gender")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["gender"] ? $genders[$settingsAccount["gender"]] : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("email")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["email"] ? $settingsAccount["email"] : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("phone")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["phone"] ? htmlentities($settingsAccount["phone"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("birth_date")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($settingsAccount["birthDate"] ? date("d/m/Y", strtotime($settingsAccount["birthDate"])) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("address")) ?></dt>
                                <dd class="col-lg-9 text-monospace">
                                    <?= $settingsAccount["address"]["street"] ?>
                                    <?= $settingsAccount["address"]["postalCode"] ?>
                                    <?= $settingsAccount["address"]["city"] ?>
                                    <?= $settingsAccount["address"]["country"] ?>
                                </dd>
                            </dl>
                            <a href="javascript: settings.deleteAccount();" class="text-danger mt-4"><?= ucfirst($localization->getText("delete_account")) ?></a>
                        </div>
                        <div id="settings-authentication-tab" class="tab-pane">
                            <h5><?= ucfirst($localization->getText("authentication_methods")) ?></h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("email")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3">
                                    <?php if($settingsEmailAuthenticationMethod): ?>
                                        <?= $settingsEmailAuthenticationMethod["email"] ?>
                                        <a href="#" class="text-danger ml-3" data-toggle="modal" data-target="#update-email-modal"><?= ucfirst($localization->getText("update")) ?></a><br>
                                        <a href="#" class="text-danger" data-toggle="modal" data-target="#update-password-modal"><?= ucfirst($localization->getText("change_password")) ?></a>
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
                                            <a href='javascript: settings.unlinkOauth(<?= json_encode($key) ?>);' class="text-danger ml-3"><?= ucfirst($localization->getText("unlink")) ?></a>
                                        <?php else: ?>
                                            <a href="<?= htmlspecialchars($oauthAuthenticationMethods[$key]["signInUrl"]) ?>"><?= ucfirst($localization->getText("link")) ?></a>
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
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>