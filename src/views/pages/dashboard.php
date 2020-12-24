<?php $title = ucfirst($localization->getText("title_dashboard")); ?>
<?php ob_start(); ?>
<div style="max-width: 1600px;" class="container my-5">
    <div class="card">
        <h5 class="card-header"><?= ucfirst($localization->getText("accounts")) ?></h5>
        <div class="card-body">
            <?php require(Configuration::ROOT . "/views/pages/alerts.php"); ?>
            <div style="max-height: 800px;" class="table-responsive">
                <table class="table mb-0">
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
                                    <?php if($account["enabled"]): ?>
                                        <i class="fas fa-check text-success"></i>
                                    <?php else: ?>
                                        <i class="fas fa-times text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td><?= ucfirst($localization->getText($account["type"])) ?></td>
                                <td><?= $account["_id"] ?></td>
                                <td><?= htmlentities(Utils::truncateText($account["firstName"], 30, "..")) ?></td>
                                <td><?= htmlentities(Utils::truncateText($account["lastName"], 30, "..")) ?></td>
                                <td><?= Utils::truncateText($account["email"], 80, "..") ?></td>
                                <td><?= date("d/m/Y", $account["registrationTime"]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require(Configuration::ROOT . "/views/pages/base.php"); ?>