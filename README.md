# Cpanel Email Creator

To create an email using your own domain.

## Example

```php
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

```
### Response
#### Success
```json
{"status":1,"messages":"Account successfully created"}
```
#### Failed
```json
{"status":0,"messages":"errors"}
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
