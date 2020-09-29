<?php

require 'src/email.php';

$mail = new cpanelEmailCreator();
$mail->url = 'https://telury.dev:2083';
$mail->username = 'teluryd1';
$mail->password = '09april2004#';

$login = json_decode($mail->loginCpanel());

echo $mail->createEmail($login->cpanelUser, 'telury.dev', 'admin', '09april2004#', 1024);
