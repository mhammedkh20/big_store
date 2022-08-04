<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FCMService;
use Illuminate\Http\Request;


// Route::post('pushNotification/{id}', 'UserController@sendNotificationrToUser');

// Route::post('pushNotificationsAllUsers', 'UserController@sendNotificationForAllUsers');

// Route::post('push_fotifications_for_user', 'UserController@sendNotificationToUser2');


class UserController extends Controller
{
    public function sendNotificationrToUser($id)
    {
        // get a user to get the fcm_token that already sent. from mobile apps 
        $user = User::findOrFail($id);

        FCMService::sendNotificationForUser(
            $user->fcm_token,
            [
                'title' => 'your title',
                'body' => 'your body',
                // 'image' => $image_url 
            ]
        );
    }

    public function sendNotificationToUser2(Request $request)
    {
        $user = User::findOrFail($request->id_user);

        $notification = [
            'id' => $request->id,
            'title'=> $request->title,
            'body' => $request->body,
            'message' => $request->message,
            'url_image' => $request->url_image,
        ];

        FCMService::sendNotificationForUser2($user->fcm_token,$notification);
    }

    public function sendNotificationForAllUsers()
    {
        $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        
        FCMService::sendNotificationForAllUser($fcmTokens,[
            'title' => 'ALL USERS',
            'body' => 'ALL USERS',
            // 'image' => $image_url 
        ]);
    }
}
