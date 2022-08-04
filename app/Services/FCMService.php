<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class FCMService
{ 
    public static function sendNotificationForUser($token, $notification)
    {
        Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $token,
                'notification' => $notification,
            ]
        );
    }

    public static function sendNotificationForUser2($token, $notification)
    {
        $url = "https://fcm.googleapis.com/fcm/send";            
        $header = [
        'authorization: key=' . config('fcm.token'),
            'content-type: application/json'
        ];    
//myTopic1
        $postdata = '{
            "to" : "/topics/myTopic1",
            "notification" : {
                "title":"' . $notification['title'] . '",
                "text" : "' . $notification['message'] . '",
                "body" : "' . $notification['body'] . '"
            },
            "data" : {
                "url_image" : "'.$notification['url_image'].'",
                "id" : "'.$notification['id'].'",
                "title":"' . $notification['title'] . '",
                "description" : "' . $notification['message'] . '",
                "text" : "' . $notification['message'] . '",
                "is_read": 0
            }
        }';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);    
        curl_close($ch);

        return $result;
    }

    public static function sendNotificationForAllUser( $tokens,$notification)
    {
        Http::acceptJson()->withToken(config('fcm.token'))->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'to' => $tokens,
                'notification' => $notification,
            ]
        );
    }
}