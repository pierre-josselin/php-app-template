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
                                <input name="first-name" value="<?= htmlentities($account["firstName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("last_name")) ?></label>
                                <input name="last-name" value="<?= htmlentities($account["lastName"]) ?>" type="text" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("gender")) ?></label>
                                <select name="gender" class="form-control">
                                    <option value="" <?php if(!$account["gender"]) echo "selected"; ?>>-</option>
                                    <option value="male" <?php if($account["gender"] === "male") echo "selected"; ?>><?= ucfirst($localization->getText("male")) ?></option>
                                    <option value="female" <?php if($account["gender"] === "female") echo "selected"; ?>><?= ucfirst($localization->getText("female")) ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("email")) ?></label>
                                <input name="email" value="<?= $account["email"] ?>" type="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("phone")) ?></label>
                                <input name="phone" value="<?= htmlentities($account["phone"]) ?>" type="tel" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("birth_date")) ?></label>
                                <input name="birth-date" value="<?= $account["birthDate"] ?>" type="date" min="1900-01-01" max="<?= date("Y-m-d") ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("address")) ?></label>
                                <input name="street" value="<?= $account["address"]["street"] ?>" type="text" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label><?= ucfirst($localization->getText("postal_code")) ?></label>
                                        <input name="postal-code" value="<?= $account["address"]["postalCode"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label><?= ucfirst($localization->getText("city")) ?></label>
                                        <input name="city" value="<?= $account["address"]["city"] ?>" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?= ucfirst($localization->getText("country")) ?></label>
                                <input name="country" value="<?= $account["address"]["country"] ?>" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ucfirst($localization->getText("close")) ?></button>
                            <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                        </div>
                    </form>
                </div>
            </div>
            <?php if($emailAuthenticationMethod): ?>
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
                                    <input name="email" value="<?= $emailAuthenticationMethod["email"] ?>" type="email" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= ucfirst($localization->getText("close")) ?></button>
                                <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
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
                        <a class="nav-link <?= ($tab === "account" ? "active" : "") ?>"
                        data-toggle="pill" href="#settings-account-tab"><?= ucfirst($localization->getText("account")) ?></a>
                        <a class="nav-link <?= ($tab === "profile-picture" ? "active" : "") ?>"
                        data-toggle="pill" href="#settings-profile-picture-tab"><?= ucfirst($localization->getText("profile_picture")) ?></a>
                        <a class="nav-link <?= ($tab === "authentication" ? "active" : "") ?>"
                        data-toggle="pill" href="#settings-authentication-tab"><?= ucfirst($localization->getText("authentication")) ?></a>
                        <a class="nav-link <?= ($tab === "sessions" ? "active" : "") ?>"
                        data-toggle="pill" href="#settings-sessions-tab"><?= ucfirst($localization->getText("sessions")) ?></a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div id="settings-account-tab" class="tab-pane <?= ($tab === "account" ? "active" : "") ?>">
                            <h5><?= ucfirst($localization->getText("account_details")) ?></h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("identifier")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= $account["_id"] ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("sign_up_date")) ?></dt>
                                <dd class="col-lg-9 text-monospace"><?= date("d/m/Y H:i", $account["registrationTime"]) ?></dd>
                            </dl>
                            <h5><?= ucfirst($localization->getText("personal_informations")) ?></h5><hr>
                            <a href="#" class="text-danger" data-toggle="modal" data-target="#update-personal-informations-modal"><?= ucfirst($localization->getText("edit")) ?></a>
                            <dl class="row mt-3">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("first_name")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["firstName"] ? htmlentities($account["firstName"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("last_name")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["lastName"] ? htmlentities($account["lastName"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("gender")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["gender"] ? ucfirst($localization->getText($account["gender"])) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("email")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["email"] ? $account["email"] : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("phone")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["phone"] ? htmlentities($account["phone"]) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("birth_date")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3"><?= ($account["birthDate"] ? date("d/m/Y", strtotime($account["birthDate"])) : "-") ?></dd>
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("address")) ?></dt>
                                <dd class="col-lg-9 text-monospace">
                                    <?= $account["address"]["street"] ?>
                                    <?= $account["address"]["postalCode"] ?>
                                    <?= $account["address"]["city"] ?>
                                    <?= $account["address"]["country"] ?>
                                </dd>
                            </dl>
                            <a href="javascript: settings.deleteAccount();" class="text-danger mt-4"><?= ucfirst($localization->getText("delete_account")) ?></a>
                        </div>
                        <div id="settings-profile-picture-tab" class="tab-pane <?= ($tab === "profile-picture" ? "active" : "") ?>">
                            <h5><?= ucfirst($localization->getText("profile_picture")) ?></h5><hr>
                            <?php if($account["picture"]): ?>
                                <a href="/file?id=<?= $account["picture"] ?>" target="_blank">
                                    <img style="max-width: 300px;" src="/file?id=<?= $account["picture"] ?>" class="border border-primary w-100 mb-3">
                                </a>
                            <?php endif; ?>
                            <form action="/actions/update-profile-picture" method="post" enctype="multipart/form-data">
                                <div class="custom-file mb-3">
                                    <input id="picture" type="file" name="profile-picture" class="custom-file-input"
                                    accept="image/jpeg, image/png, image/gif"required>
                                    <label style="max-width: 300px;" for="picture" class="custom-file-label text-truncate"><?= ucfirst($localization->getText("choose_picture")) ?></label>
                                </div>
                                <button type="submit" class="btn btn-primary"><?= ucfirst($localization->getText("save")) ?></button>
                            </form>
                        </div>
                        <div id="settings-authentication-tab" class="tab-pane <?= ($tab === "authentication" ? "active" : "") ?>">
                            <h5><?= ucfirst($localization->getText("authentication_methods")) ?></h5><hr>
                            <dl class="row">
                                <dt class="col-lg-3"><?= ucfirst($localization->getText("email")) ?></dt>
                                <dd class="col-lg-9 text-monospace mb-3">
                                    <?php if($emailAuthenticationMethod): ?>
                                        <?= $emailAuthenticationMethod["email"] ?><br>
                                        <a href="#" class="text-danger" data-toggle="modal" data-target="#update-email-modal"><?= ucfirst($localization->getText("update_email")) ?></a><br>
                                        <a href="#" class="text-danger" data-toggle="modal" data-target="#update-password-modal"><?= ucfirst($localization->getText("update_password")) ?></a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </dd>
                                <?php foreach(array_keys(Configuration::OAUTH_AUTHENTICATION_METHODS) as $index => $key): ?>
                                    <dt class="col-lg-3"><?= ucfirst($key) ?></dt>
                                    <dd class="col-lg-9 text-monospace <?php if($index < count(Configuration::OAUTH_AUTHENTICATION_METHODS) - 1) echo "mb-3"; ?>">
                                        <?php if(isset($oauthAuthenticationMethods[$key])): ?>
                                            <?= ($oauthAuthenticationMethods[$key]["name"] ?
                                            $oauthAuthenticationMethods[$key]["name"] : $oauthAuthenticationMethods[$key]["id"]) ?>
                                            <a href='javascript: settings.unlinkOAuth(<?= json_encode($key) ?>);' class="text-danger ml-3"><?= ucfirst($localization->getText("unlink")) ?></a>
                                        <?php else: ?>
                                            <a href="<?= htmlspecialchars(constant(strtoupper($key) . "_SIGN_IN_URL")) ?>"><?= ucfirst($localization->getText("link")) ?></a>
                                        <?php endif; ?>
                                    </dd>
                                <?php endforeach; ?>
                            </dl>
                        </div>
                        <div id="settings-sessions-tab" class="tab-pane <?= ($tab === "sessions" ? "active" : "") ?>">
                            <h5><?= ucfirst($localization->getText("sessions")) ?></h5><hr>
                            <div class="mb-2"><small><?= $localization->getText("dialog_delete_current_session") ?></small></div>
                            <div class="mb-3"><a class="btn btn-outline-danger btn-sm" href="javascript: settings.deleteAllSessions();"><?= ucfirst($localization->getText("delete_all_sessions")) ?></a></div>
                            <div style="max-height: 800px; overflow-y: auto;">
                                <?php foreach($sessions as $index => $session): ?>
                                    <div class="card border-<?= ($session["badge"] ? $session["badge"]["type"] : "dark") ?>
                                    <?= ($index < count($sessions) - 1 ? "mb-3" : "") ?>">
                                        <div class="card-body">
                                            <h5 class="card-title"><span class="text-monospace"><?= substr($session["_id"], 0, 16) ?></span><a style="float: right;" href='javascript: settings.deleteSession(<?= json_encode($session["_id"]) ?>);'><i class="fas fa-times text-dark"></i></a></h5>
                                            <dl class="row mb-0">
                                                <dt class="col-sm-3"><?= ucfirst($localization->getText("location")) ?></dt>
                                                <dd class="col-sm-9">
                                                    <?php if($session["ipLocation"]): ?>
                                                        <span data-toggle="tooltip" data-placement="top" title="<?= $session["ip"] ?>"><?= $session["ipLocation"]["city"] ?>, <?= $session["ipLocation"]["postalCode"] ?> <?= $session["ipLocation"]["country"] ?></span>
                                                    <?php else: ?>
                                                        <?= $session["ip"] ?>
                                                    <?php endif; ?>
                                                </dd>
                                                <dt class="col-sm-3"><?= ucfirst($localization->getText("last_access")) ?></dt>
                                                <dd class="col-sm-9"><?= date("d/m/Y H:i:s", $session["updateTime"]) ?></dd>
                                                <dt class="col-sm-3"><?= ucfirst($localization->getText("expiration")) ?></dt>
                                                <dd class="col-sm-9"><?= date("d/m/Y H:i:s", $session["expirationTime"]) ?></dd>
                                            </dl>
                                            <?php if($session["badge"]): ?>
                                                <span class="badge badge-<?= $session["badge"]["type"] ?>"><?= $session["badge"]["name"] ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
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