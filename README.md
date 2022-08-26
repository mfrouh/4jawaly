### Package For 4jawaly Sms For Laravel

#

```bash
 composer require mfrouh/4jawaly
```

#

## Package have 2 method

1- Get Balance

2- Send Sms

#

1- Get Balance

```php

use MFrouh\Sms4jawaly\Facades\Sms4jawaly;

 Sms4jawaly::getBalance();

```

#

2- Send Sms

```php

use MFrouh\Sms4jawaly\Facades\Sms4jawaly;

 Sms4jawaly::sendSms($message,$phone_number, $phone_code);

```

#

## .env File

```env

4JAWALY_USERNAME=
4JAWALY_PASSWORD=
4JAWALY_SENDER_NAME=

```
