<?php $title = ucfirst($localization->getText("title_dashboard")); ?>
<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" href="/libraries/datatables/1.10.23/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="/libraries/datatables/1.10.23/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/libraries/datatables/1.10.23/js/dataTables.bootstrap4.min.js"></script>
<div class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= $title ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <dl class="row mb-0">
                <dt class="col-sm-3">Nombre d'utilisateurs</dt>
                <dd class="col-sm-9"><?= count($accounts) ?></dd>
                <dt class="col-sm-3">Nombre d'utilisateurs en ligne</dt>
                <dd class="col-sm-9"><?= $activeSessionCount ?></dd>
            </dl>
            <hr>
            <div class="table-responsive">
                <table id="accounts" class="table mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th><?= ucfirst($localization->getText("enabled")) ?></th>
                            <th><?= ucfirst($localization->getText("type")) ?></th>
                            <th><?= ucfirst($localization->getText("identifier")) ?></th>
                            <th><?= ucfirst($localization->getText("first_name")) ?></th>
                            <th><?= ucfirst($localization->getText("last_name")) ?></th>
                            <th><?= ucfirst($localization->getText("email")) ?></th>
                            <th><?= ucfirst($localization->getText("sign_up_date")) ?></th>
                        </tr>
                    </thead>
                    <tbody class="text-monospace">
                        <?php foreach($accounts as $account): ?>
                            <tr>
                                <td class="text-center">
                                    <?php if($account->getEnabled()): ?>
                                        <i class="fas fa-check text-success"></i>
                                    <?php else: ?>
                                        <i class="fas fa-times text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= ucfirst($localization->getText($account->getType())) ?></td>
                                <td><?= $account->getId() ?></td>
                                <td><?= htmlentities(Utils::truncateText($account->getFirstName(), 30, "..")) ?></td>
                                <td><?= htmlentities(Utils::truncateText($account->getLastName(), 30, "..")) ?></td>
                                <td><?= Utils::truncateText($account->getEmail(), 80, "..") ?></td>
                                <td><?= date("Y-m-d", $account->getRegistrationTime()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/dashboard.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>