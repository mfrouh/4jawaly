<?php

namespace MFrouh\Sms4jawaly;

use Illuminate\Support\Facades\Http;
use Exception;

class BaseClass
{
    const Base_Url = 'https://4jawaly.net/api';
    const Base_Url_New = 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send';

    public function getBalance()
    {
        try {
            $data = [
                'username' => config('sms4jawaly.username'),
                'password' => config('sms4jawaly.password'),
                'return' => 'json'
            ];

            $response = Http::withOptions(['verify' => false])->get(self::Base_Url . '/getbalance.php', $data);
            $response = json_decode($response);
            return ['status' => true, 'response' => $response->currentuserpoints, 'message' => $response->MessageIs];
        } catch (Exception $error) {
            return ['status' => false, 'response' => $error, 'message' => 'error'];
        }
    }

    public function sendSms($message, $phoneNumber, $phoneCode)
    {
        $messages = [];
        $messages["messages"] = [];
        $messages["messages"][0]["text"] = $message;
        $messages["messages"][0]["numbers"][] = $phoneCode . $this->convertArabicNumbers(ltrim($phoneNumber, '0'));
        $messages["messages"][0]["sender"] = config('sms4jawaly.sender_name');

        $response = Http::withBasicAuth(config('sms4jawaly.username'), config('sms4jawaly.password'))
            ->post(self::Base_Url_New, $messages);

        return json_decode($response);
    }

    private function convertArabicNumbers($number)
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $english = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        return str_replace($arabic, $english, $number);
    }
}
