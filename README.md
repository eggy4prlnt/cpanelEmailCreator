# Cpanel Email Creator

To create an email using your own domain.

## Example

```php
<?php

require 'src/email.php';

$mail = new cpanelEmailCreator();
$mail->url = 'CPANEL_URL';
$mail->username = 'CPANEL_USERNAME';
$mail->password = 'CPANEL_PASSWORD';

$login = json_decode($mail->loginCpanel());

$quota = 1024; // mb

echo $mail->createEmail($login->cpanelUser, 'DOMAIN', 'USERNAME', 'PASSWORD', $quota);
```
### Response
#### Success
```json
{"warnings":null,"status":1,"messages":[""],"data":"username+domain","errors":null,"metadata":{}}
```
#### Failed
```json
{"warnings":null,"status":0,"messages":null,"errors":[""],"data":null,"metadata":{}}
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
