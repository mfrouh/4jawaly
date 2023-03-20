<?php

namespace MFrouh\Sms4jawaly;

use Illuminate\Support\Facades\Http;
use Exception;

class BaseClass
{
    const Base_Url = 'https://api-sms.4jawaly.com/api/v1/account/area';

    public function getBalance()
    {
        $query = [];
        $query["is_active"] = 1; // get active only
        $query["order_by"] = "id"; // package_points, current_points, expire_at or id (default)
        $query["order_by_type"] = "desc"; // desc or asc
        $query["page"] = 1;
        $query["page_size"] = 10;
        $query["return_collection"] = 1; // if you want to get all collection
        $response = Http::withBasicAuth(config('sms4jawaly.username'), config('sms4jawaly.password'))
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
            ->get(self::Base_Url . '/me/packages?' . http_build_query($query));
        $response = (array)json_decode($response);

        if ($response['code'] == 200) {
            return ['status' => true, 'response' => $response['total_balance'], 'message' => $response['message']];
        } else {
            return ['status' => false, 'response' => 'error', 'message' => $response['message']];
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
            ->post(self::Base_Url . '/sms/send', $messages);

        return json_decode($response);
    }

    private function convertArabicNumbers($number)
    {
        $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $english = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

        return str_replace($arabic, $english, $number);
    }
}
