<?php
$authorization->mustBeSignedIn();
$authorization->mustBeAdmin();

$options = ["sort" => ["registrationTime" => -1]];
$accounts = $accountManager->read([], $options, true);

$time = time();
$activeAccounts = [];
foreach($accounts as $account) {
    $filter = ["accountId" => $account->getId()];
    $options = ["sort" => ["updateTime" => -1]];
    $session = $sessionManager->read($filter, $options);
    if(!$session) continue;
    if($time - $session->getUpdateTime() > 120) continue;
    $activeAccounts[] = $account->getId();
}

require(Configuration::ROOT . "/views/pages/dashboard.php");