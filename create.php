<?php

require 'src/email.php';

$mail = new cpanelEmailCreator();
$mail->url = 'https://site.com:2083';
$mail->username = 'user';
$mail->password = 'pass';
$quota = 1024; // mb

$login = json_decode($mail->loginCpanel());

try {
    echo $mail->createEmail($login->cpanelUser, 'site.com', 'eggy', 'password123', $quota);
} catch (\Throwable $th) {
    //throw $th;
}
