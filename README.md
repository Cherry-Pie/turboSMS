turboSMS
========

turbosms.ua api package for laravel 4


app/config/app.php
'Yaro\Turbo\TurboServiceProvider',
'Turbo'         => 'Yaro\Turbo\Facades\Turbo',


Turbo::getCredits() // 4.00
Turbo::sms($phone, $message, $sender) // array($resultMessage, array $messageIDs)
Turbo::auth() // auth result message
Turbo::getStatus($idMessage)
Turbo::getPendingMessages() // array $messageIDs
