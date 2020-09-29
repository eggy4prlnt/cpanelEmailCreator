<?php

require 'src/email.php';

$mail = new cpanelEmailCreator();
$mail->url = 'CPANEL_URL';
$mail->username = 'CPANEL_USERNAME';
$mail->password = 'CPANEL_PASSWORD';

$login = json_decode($mail->loginCpanel());

$quota = 1024; // mb

echo $mail->createEmail($login->cpanelUser, 'DOMAIN', 'USERNAME', 'PASSWORD', $quota);
