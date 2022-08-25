<?php

namespace MFrouh\Sms4jawaly;

use Illuminate\Support\Facades\Http;
use Exception;

class BaseClass
{
    const Base_Url = 'https://4jawaly.net/api';

    public function getBalance()
    {
        try {
            $data = [
                'username' => config('sms4jawaly.username'),
                'password' => config('sms4jawaly.password'),
                'return' => 'json'
            ];

            $response = Http::get(self::Base_Url . '/getbalance.php', $data);

            return ['status' => true, 'response' => $response->currentuserpoints, 'message' => $response->MessageIs];
        } catch (Exception $error) {
            return ['status' => false, 'response' => $error, 'message' => 'error'];
        }
    }

    public function sendSms($message, $phoneNumber, $phoneCode)
    {
        try {
            $data = [
                'username' => config('sms4jawaly.username'),
                'password' => config('sms4jawaly.password'),
                "message"  =>  urlencode($message),
                "numbers"  => '+' . $phoneCode . $this->convertArabicNumbers(ltrim($phoneNumber, '0')),
                "sender"   => config('sms4jawaly.sender_name'),
                "unicode"  => 'e',
                'return'   => 'json'
            ];

            $response = Http::get(self::Base_Url . '/sendsms.php', $data);

            return $response;
        } catch (Exception $error) {
            return $error;
        }
    }

    private function convertArabicNumbers($number)
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $english = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        return str_replace($arabic, $english, $number);
    }
}
