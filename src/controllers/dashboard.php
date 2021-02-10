<?php
$authorization->mustBeSignedIn();
$authorization->mustBeAdmin();

$options = ["sort" => ["registrationTime" => -1]];
$accounts = $accountManager->read([], $options, true);

$time = time();
$activeSessionCount = 0;
foreach($accounts as $account) {
    $filter = ["accountId" => $account->getId()];
    $sessions = $sessionManager->read($filter, [], true);
    
    foreach($sessions as $session) {
        if($time - $session->getUpdateTime() < 120) {
            $activeSessionCount ++;
            break;
        }
    }
}

require(Configuration::ROOT . "/views/pages/dashboard.php");